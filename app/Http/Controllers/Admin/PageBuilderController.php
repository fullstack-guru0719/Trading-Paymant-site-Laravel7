<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageBuilderController extends Controller
{
    public function __construct()
    {
        $this->activeTemplate = activeTemplate();
    }

    public function managePages()
    {
        //// HOME PAGE
        $count = Page::where('tempname',$this->activeTemplate)->where('slug','home')->count();
        if($count == 0){
            $in['tempname'] = $this->activeTemplate;
            $in['name'] = 'HOME';
            $in['slug'] = 'home';
            Page::create($in);
        }

        $pdata = Page::where('tempname',$this->activeTemplate)->get();
        $page_title = 'Manage Section';
        $empty_message = 'No Page Created Yet';

        return view('admin.frontend.builder.pages', compact('page_title','pdata','empty_message'));
    }

    public function managePagesSave(Request $request){

        $request->validate([
            'name' => 'required|min:3',
            'slug' => 'required|min:3',
        ]);

        $exist = Page::where('tempname', $this->activeTemplate)->where('slug', str_slug($request->slug))->count();
        if($exist != 0){
            $notify[] = ['error', 'This Page Already Exist on your Current Template. Please Change the Slug.'];
            return back()->withNotify($notify);
        }

        $in['tempname'] = $this->activeTemplate;
        $in['name'] = $request->name;
        $in['slug'] = str_slug($request->slug);

        Page::create($in);
        $notify[] = ['success', 'Save Successfully'];
        return back()->withNotify($notify);

    }

    public function managePagesUpdate(Request $request){

        $page = Page::where('id',$request->id)->where('tempname',$this->activeTemplate)->first();
        $request->validate([
            'name' => 'required|min:3',
            'slug' => 'required|min:3|unique:pages,slug,'.$page->id,
        ]);

        $page->name = $request->name;
        $page->slug = str_slug($request->slug);
        $page->save();


        $notify[] = ['success', 'Update Successfully'];
        return back()->withNotify($notify);

    }

    public function managePagesDelete(Request $request){
        $page = Page::where('id',$request->id)->first();
        $page->delete();
        $notify[] = ['success', 'Delete Successfully'];
        return back()->withNotify($notify);
    }



    public function manageSection($id)
    {
        $pdata = Page::findOrFail($id);
        $page_title = 'Manage Section of '.$pdata->name;
        $sections =  getPageSections(true);
        ksort($sections);
        return view('admin.frontend.builder.index', compact('page_title','pdata','sections'));
    }



    public function manageSectionUpdate($id, Request $request)
    {
        $request->validate([
            'secs' => 'required',
        ],[
            'secs.required' => 'Page should Contain Minimum One Section'
        ]);

        $page = Page::findOrFail($id);
        $page->secs = json_encode($request->secs);
        $page->save();
        $notify[] = ['success', 'Update Successfully'];
        return back()->withNotify($notify);
    }
}
