<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SupportAttachment;
use App\Models\SupportMessage;
use App\Models\SupportTicket;
use Auth;
use Image;
use File;
use Validator;
use Session;
use Carbon\Carbon;

class TicketController extends Controller
{

    public function __construct()
    {
        $this->activeTemplate = activeTemplate();
    }


    // Support Ticket
    public function supportTicket()
    {
        if (Auth::id() == null) {
            abort(404);
        }
        $page_title = "Support Tickets";
        $supports = SupportTicket::where('user_id', Auth::id())->latest()->paginate(15);
        $empty_message = 'No Data Found!';
        return view($this->activeTemplate . 'user.support.index', compact('supports', 'page_title','empty_message'));
    }


    public function openSupportTicket()
    {
        if (!Auth::user()) {
            abort(404);
        }
        $page_title = "Support Tickets";
        $user = Auth::user();
        return view($this->activeTemplate . 'user.support.create', compact('page_title', 'user'));
    }

    public function storeSupportTicket(Request $request)
    {
        $ticket = new SupportTicket();
        $message = new SupportMessage();

        $imgs = $request->file('attachments');
        $allowedExts = array('jpg', 'png', 'jpeg', 'pdf');


        $this->validate($request, [
            'attachments' => [
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
            'email' => 'required|email|max:191',
            'subject' => 'required|max:100',
            'message' => 'required',
        ]);


        $ticket->user_id = Auth::id();
        $random = rand(100000, 999999);
        $ticket->ticket = $random;
        $ticket->name = $request->name;
        $ticket->email = $request->email;
        $ticket->subject = $request->subject;
        $ticket->last_reply = Carbon::now();
        $ticket->status = 0;
        $ticket->save();

        $message->supportticket_id = $ticket->id;
        $message->message = $request->message;
        $message->save();


        $path = imagePath()['ticket']['path'];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as  $image) {
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
        return redirect()->route('ticket')->withNotify($notify);
    }

    public function viewTicket($ticket)
    {
        $page_title = "Support Tickets";
        $my_ticket = SupportTicket::where('ticket', $ticket)->latest()->first();
        $messages = SupportMessage::where('supportticket_id', $my_ticket->id)->latest()->get();
        $user = auth()->user();

        if(auth()->user()){
            $extend_blade =  $this->activeTemplate.'layouts.master';
        }else{
            $extend_blade = $this->activeTemplate.'layouts.frontend';
        }
        return view($this->activeTemplate. 'user.support.view', compact('my_ticket', 'messages', 'page_title', 'user','extend_blade'));

    }

    public function replyTicket(Request $request, $id)
    {
        $ticket = SupportTicket::findOrFail($id);
        $message = new SupportMessage();

        if ($request->replayTicket == 1) {
            $imgs = $request->file('attachments');
            $allowedExts = array('jpg', 'png', 'jpeg', 'pdf');

            $this->validate($request, [
                'attachments' => [
                    'max:4096',
                    function ($fail) use ($imgs, $allowedExts) {
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
                'message' => 'required',
            ]);

            $ticket->status = 2;
            $ticket->last_reply = Carbon::now();
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

            $notify[] = ['success', 'Support ticket replied successfully!'];
        } elseif ($request->replayTicket == 2) {
            $ticket->status = 3;
            $ticket->last_reply = Carbon::now();
            $ticket->save();
            $notify[] = ['success', 'Support ticket closed successfully!'];
        }
        return back()->withNotify($notify);

    }





    public function ticketDownload($ticket_id)
    {
        $attachment = SupportAttachment::findOrFail(decrypt($ticket_id));
        $file = $attachment->image;

        $path = imagePath()['ticket']['path'];
        $full_path = $path.'/'. $file;

        $title = str_slug($attachment->supportMessage->ticket->subject);
        $ext = pathinfo($file, PATHINFO_EXTENSION);
        $mimetype = mime_content_type($full_path);


        header('Content-Disposition: attachment; filename="' . $title . '.' . $ext . '";');
        header("Content-Type: " . $mimetype);
        return readfile($full_path);
    }

}
