<?php

namespace App\Http\Controllers;

use App\Models\Frontend;
use App\Models\GeneralSetting;
use App\Models\Language;
use App\Models\Page;
use App\Models\Plan;
use App\Models\Subscriber;
use App\Models\SupportAttachment;
use App\Models\SupportMessage;
use App\Models\SupportTicket;
use App\Support\DocxConversion;
use App\Models\TimeSetting;
use App\Models\UserWallet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;


class SiteController extends Controller
{
    public function __construct()
    {
        
        $this->activeTemplate = activeTemplate();
        $this->activeTemplateTrue = activeTemplate(true);
    }

    public function index(){
        $count = Page::where('tempname',$this->activeTemplate)->where('slug','home')->count();
        if($count == 0){
            $in['tempname'] = $this->activeTemplate;
            $in['name'] = 'HOME';
            $in['slug'] = 'home';
            Page::create($in);
        }
        $data['page_title'] = 'Home';
        $data['sections'] = Page::where('tempname',$this->activeTemplate)->where('slug','home')->firstOrFail();
        return view($this->activeTemplate . 'home', $data);
    }




    public function pages($slug)
    {
        $page = Page::where('tempname',activeTemplate())->where('slug',$slug)->firstOrFail();
        $data['page_title'] = $page->name;
        $data['sections'] = $page;
        return view(activeTemplate() . 'pages', $data);
    }


    public function contact()
    {
        $data['page_title'] = "Contact Us";
        return view($this->activeTemplate . 'contact', $data);
    }


    public function contactSubmit(Request $request)
    {
        $ticket = new SupportTicket();
        $message = new SupportMessage();

        $imgs = $request->file('attachments');
        $allowedExts = array('jpg', 'png', 'jpeg', 'pdf');

        $this->validate($request, [
            'attachments' => [
                'sometimes',
                'max:4096',
                function ($attribute, $value, $fail) use ($imgs, $allowedExts) {
                    foreach ($imgs as $img) {
                        $ext = strtolower($img->getClientOriginalExtension());
                        if (($img->getSize() / 1000000) > 2) {
                            return $fail("Images MAX  2MB ALLOW!");
                        }
                        if (!in_array($ext, $allowedExts)) {
                            return $fail("Only png, jpg, jpeg, pdf images are allowed");
                        }
                    }
                    if (count($imgs) > 5) {
                        return $fail("Maximum 5 images can be uploaded");
                    }
                },
            ],
            'name' => 'required|max:191',
            'email' => 'required|max:191',
            'subject' => 'required|max:100',
            'message' => 'required',
        ]);


        $random = getNumber();
        $ticket->user_id = auth()->id();
        $ticket->name = $request->name;
        $ticket->email = $request->email;

        $ticket->ticket = $random;
        $ticket->subject = $request->subject;
        $ticket->last_reply = Carbon::now();
        $ticket->status = 0;
        $ticket->save();

        $message->supportticket_id = $ticket->id;
        $message->message = $request->message;
        $message->save();

        $path = imagePath()['ticket']['path'];

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $image) {
                try {
                    SupportAttachment::create([
                        'support_message_id' => $message->id,
                        'image' => uploadImage($image, $path),
                    ]);
                } catch (\Exception $exp) {
                    $notify[] = ['error', 'Could not upload your ' . $image];
                    return back()->withNotify($notify)->withInput();
                }

            }
        }
        $notify[] = ['success', 'ticket created successfully!'];
        return redirect()->route('ticket.view', [$ticket->ticket])->withNotify($notify);
    }

    public function changeLanguage($lang = null)
    {
        $language = Language::where('code', $lang)->first();
        if (!$language) $lang = 'en';
        session()->put('lang', $lang);
        return redirect()->back();
    }
    
    public function blog()
    {
        $blogs = Frontend::where('data_keys', 'blog.element')->latest()->paginate(9);
        $page_title = "blog";
        return view($this->activeTemplate. 'blog', compact('blogs', 'page_title'));
    }

    public function blogDetails($slug = null, $id, $data_keys = 'blog.element')
    {
        $post = Frontend::where('id', $id)->where('data_keys', $data_keys)->firstOrFail();
        $page_title = "Blog Details";
        $data['title'] = $post->data_values->title;
        $data['details'] = $post->data_values->description;
        $data['image'] =  asset('assets/images/frontend/blog/'.$post->data_values->image);
        $blogs = Frontend::where('id','!=', $id)->where('data_keys', $data_keys)->latest()->limit(4)->get();
        return view($this->activeTemplate . 'blog-details', compact('post', 'data', 'page_title','blogs'));
    }

    public function subscribe(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email' => 'required|email|max:255|unique:subscribers',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }
        Subscriber::create($request->only('email'));
        return response()->json(['success'=>'Subscribe successfully']);
    }

    public function plan()
    {
        if(auth()->user()){
            return redirect()->route('user.plan');
        }else{
            $data['extend_blade'] = $this->activeTemplate.'layouts.frontend';
        }

        $data['page_title'] = "Investment Plan";
        $data['plans'] = Plan::where('status', 1)->get();
        $data['planContent'] = getContent('plan.content',true);
        return view($this->activeTemplate . 'plan', $data);
    }


    public function planCalculator(Request $request)
    {

        // $request->planId = 8;
        // $request->investAmount = 2000;
        if ($request->planId == null) {
            return response(['errors'=> 'Please Select a Plan!']);
        }
        $requestAmount = $request->investAmount;
        if ($requestAmount == null ||  0 > $requestAmount) {
            return response(['errors'=> 'Please Enter Invest Amount!']);
        }
        $gnl = GeneralSetting::first();

        $plan = Plan::where('id', $request->planId)->where('status', 1)->first();
        if (!$plan) {
            return response(['errors'=> 'Invalid Plan!']);
        }

        if ($plan->fixed_amount == '0') {
            if ($requestAmount < $plan->minimum) {
                return response(['errors'=> 'Minimum Invest ' . getAmount($plan->minimum) . ' ' . $gnl->cur_text]);
            }
            if ($requestAmount > $plan->maximum) {
                return response(['errors'=> 'Maximum Invest ' . getAmount($plan->maximum) . ' ' . $gnl->cur_text]);
            }
        } else {
            if ($requestAmount != $plan->fixed_amount) {
                return response(['errors'=> 'Fixed Invest amount ' . getAmount($plan->fixed_amount) . ' ' . $gnl->cur_text]);
            }
        }
        //start
        if ($plan->interest_status == 1) {
            $interest_amount = ($requestAmount * $plan->interest) / 100;
        } else {
            $interest_amount = $plan->interest;
        }


        $time_name = TimeSetting::where('time', $plan->times)->first();



        if($plan->lifetime_status == 0){
            $ret = $plan->repeat_time;
            $total = ($interest_amount*$plan->repeat_time).' '.$gnl->cur_text;
            $totalMoney = $interest_amount*$plan->repeat_time;

            if($plan->capital_back_status == 1){
                $total .= '+Capital';
                $totalMoney += $request->investAmount;
            }


        $result['description'] = 'Return '.$interest_amount.' '.$gnl->cur_text.' Every '.$time_name->name.' For '.$ret.' '.$time_name->name.'. Total '.$total;
        $result['totalMoney'] = $totalMoney;
        $result['netProfit'] = $totalMoney-$request->investAmount;

        }else{
        $result['description'] = 'Return '.$interest_amount.' '.$gnl->cur_text.' Every '.$time_name->name.' For Lifetime';
        }
        
        return response($result);
        //end
    }

    public function linkDetails($slug,$id){

        $gnl = GeneralSetting::first();
        $item = Frontend::where('id',$id)->where('data_keys','links.element')->firstOrFail();
        $page_title = html_entity_decode($item->data_values->title);
        return view($this->activeTemplate.'linkDetails',compact('page_title','item'));
    }

    public function cookieAccept(){
        session()->put('cookie_accepted',true);
        return response()->json('Cookie accepted successfully');
    }

    public function placeholderImage($size = null){
        if ($size != 'undefined') {
            $size = $size;
            $imgWidth = explode('x',$size)[0];
            $imgHeight = explode('x',$size)[1];
            $text = $imgWidth . '×' . $imgHeight;
        }else{
            $imgWidth = 150;
            $imgHeight = 150;
            $text = 'Undefined Size';
        }
        $fontFile = realpath('assets/font') . DIRECTORY_SEPARATOR . 'RobotoMono-Regular.ttf';
        $fontSize = round(($imgWidth - 50) / 8);
        if ($fontSize <= 9) {
            $fontSize = 9;
        }
        if($imgHeight < 100 && $fontSize > 30){
            $fontSize = 30;
        }

        $image     = imagecreatetruecolor($imgWidth, $imgHeight);
        $colorFill = imagecolorallocate($image, 100, 100, 100);
        $bgFill    = imagecolorallocate($image, 175, 175, 175);
        imagefill($image, 0, 0, $bgFill);
        $textBox = imagettfbbox($fontSize, 0, $fontFile, $text);
        $textWidth  = abs($textBox[4] - $textBox[0]);
        $textHeight = abs($textBox[5] - $textBox[1]);
        $textX      = ($imgWidth - $textWidth) / 2;
        $textY      = ($imgHeight + $textHeight) / 2;
        header('Content-Type: image/jpeg');
        imagettftext($image, $fontSize, 0, $textX, $textY, $colorFill, $fontFile, $text);
        imagejpeg($image);
        imagedestroy($image);
    }


}
