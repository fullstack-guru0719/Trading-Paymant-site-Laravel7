<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PromotionTool;
use Illuminate\Http\Request;
use App\Rules\FileTypeValidate;

class PromotionalToolController extends Controller
{
	public function index(){
	    $tools = PromotionTool::orderBy('id','desc')->paginate(getPaginate());
	    $page_title = "All Promotion Tools";
	    $empty_message = "No Tools Yet";
	    return view('admin.promotion.tool', compact('page_title', 'empty_message', 'tools'));
	}

	public function store(Request $request)
    {
        $validation_rule = [
            'name'              => 'required|string|max:100',
            'image_input'       => ['required', 'image', new FileTypeValidate(['jpeg', 'jpg', 'png', 'gif'])]
        ];

        $request->validate($validation_rule);

        if ($request->hasFile('image_input')) {

            try {
                $request->merge(['image' => uploadFile($request->image_input, imagePath()['promotions']['path'])]);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Could not upload the Image.'];
                return back()->withNotify($notify);
            }
        }

        $promotion                   = new PromotionTool();
        $promotion->name             = $request->name;
        $promotion->banner           = $request->image;
        $promotion->save();
        $notify[] = ['success', 'Promotion Banner Added Successfully'];

        return redirect()->back()->withNotify($notify);
    }

    public function update(Request $request, $id){
    	$validation_rule = [
            'name'              => 'required|string|max:100',
            'image_input'  => ['nullable', 'image', new FileTypeValidate(['jpeg', 'jpg', 'png', 'gif'])]
        ];

        $request->validate($validation_rule);

        $promotion = PromotionTool::findOrFail($id);

        if ($request->hasFile('image_input')) {

            try {
                $request->merge(['image' => uploadFile($request->image_input, imagePath()['promotions']['path'], null,$promotion->banner)]);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Could not upload the Image.'];
                return back()->withNotify($notify);
            }
            $promotion->banner = $request->image;
        }
        $promotion->name       = $request->name;
        $promotion->save();

        $notify[] = ['success', 'Banner Updated Successfully'];
        return redirect()->back()->withNotify($notify);
    }

    public function remove($id)
    {
    	$promotion = PromotionTool::findOrFail($id);
        $promotion->delete();
        removeFile(imagePath()['promotions']['path'] . '/' . $promotion->banner);
        $notify[] = ['success', 'Banner Deleted Successfully'];
        return redirect()->back()->withNotify($notify);
    }
}
