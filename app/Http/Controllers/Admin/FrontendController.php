<?php

namespace App\Http\Controllers\Admin;

use App\Models\Frontend;
use App\Models\GeneralSetting;
use App\Http\Controllers\Controller;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;

class FrontendController extends Controller
{

    public function templates()
    {
        $page_title = 'Templates';
        $temPaths = array_filter(glob('core/resources/views/templates/*'), 'is_dir');
        $i = 0;
        foreach ($temPaths as $temp) {
            $arr = explode('/', $temp);
            $tempname = end($arr);
            $templates[$i]['name'] = $tempname;
            $templates[$i]['image'] = asset($temp) . '/preview.jpg';
            $i++;
        }
        $extra_templates = json_decode(getTemplates(), true);
        return view('admin.frontend.templates', compact('page_title', 'templates', 'extra_templates'));

    }

    public function templatesActive(Request $request)
    {
        $general = GeneralSetting::first();
        $general->active_template=  $request->name;
        $general->save();

        $notify[] = ['success', 'Updated Successfully'];
        return back()->withNotify($notify);
    }

    public function seoEdit()
    {
        $page_title = 'SEO Configuration';
        $seo = Frontend::where('data_keys', 'seo.data')->first();
        if(!$seo){
            $data_values = '{"keywords":["admin","blog"],"description":"Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit","social_title":"WEBSITENAME","social_description":"Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit","image":null}';
            $data_values = json_decode($data_values, true);
            Frontend::create([
               'data_keys'=> 'seo.data',
               'data_values'=> $data_values,
            ]);
        }
        return view('admin.frontend.seo', compact('page_title', 'seo'));
    }



    public function frontendSections($key)
    {
        $section = @getPageSections()->$key;
        if (!$section) {
            return abort(404);
        }

        $content = Frontend::where('data_keys', $key . '.content')->latest()->first();
        $elements = Frontend::where('data_keys', $key . '.element')->orderBy('id')->get();

        $page_title = $section->name ;
        $empty_message = 'No item create yet.';
        return view('admin.frontend.index', compact('section', 'content', 'elements', 'key', 'page_title', 'empty_message'));
    }


    public function frontendContent(Request $request, $key)
    {
        $purifier = new \HTMLPurifier();
        $valInputs = $request->except('_token', 'image_input', 'key', 'status', 'type');
        foreach ($valInputs as $keyName => $input) {
            if (gettype($input) == 'array') {
                $inputContentValue[$keyName] = $input;
                continue;
            }
            $inputContentValue[$keyName] = $purifier->purify($input);
        }
        $type = $request->type;
        if (!$type) {
            abort(404);
        }
        $imgJson = @getPageSections()->$key->$type->images;
        $validation_rule = [];
        $validation_message = [];
        foreach ($request->except('_token', 'video') as $input_field => $val) {
            if ($input_field == 'has_image' && $imgJson) {
                foreach ($imgJson as $imgValKey => $imgJsonVal) {
                    $validation_rule['image_input.'.$imgValKey] = ['nullable','image','mimes:jpeg,jpg,png'];
                    $validation_message['image_input.'.$imgValKey.'.image'] = inputTitle($imgValKey).' must be an image';
                    $validation_message['image_input.'.$imgValKey.'.mimes'] = inputTitle($imgValKey).' file type not supported';
                }
                continue;
            }elseif($input_field == 'seo_image'){
                $validation_rule['image_input'] = ['nullable', 'image', new FileTypeValidate(['jpeg', 'jpg', 'png'])];
                continue;
            }
            $validation_rule[$input_field] = 'required';
        }
        $request->validate($validation_rule, $validation_message, ['image_input' => 'image']);
        if ($request->id) {
            $content = Frontend::findOrFail($request->id);
        } else {
            $content = Frontend::where('data_keys', $key . '.' . $request->type)->first();
            if (!$content || $request->type == 'element') {
                $content = Frontend::create(['data_keys' => $key . '.' . $request->type]);
            }
        }
        if ($type == 'data') {
            $inputContentValue['image'] = @$content->data_values->image;
            if ($request->hasFile('image_input')) {
                try {
                    $inputContentValue['image'] = uploadImage($request->image_input,imagePath()['seo']['path'], imagePath()['seo']['size'], @$content->data_values->image);
                } catch (\Exception $exp) {
                    $notify[] = ['error', 'Could not upload the Image.'];
                    return back()->withNotify($notify);
                }
            }
        }else{
            if ($imgJson) {
                foreach ($imgJson as $imgKey => $imgValue) {
                    $imgData = @$request->image_input[$imgKey];
                    if (is_file($imgData)) {
                        try {
                            $inputContentValue[$imgKey] = $this->storeImage($imgJson,$type,$key,$imgData,$imgKey,@$content->data_values->$imgKey);
                        } catch (\Exception $exp) {
                            $notify[] = ['error', 'Could not upload the Image.'];
                            return back()->withNotify($notify);
                        }
                    } else if (isset($content->data_values->$imgKey)) {
                        $inputContentValue[$imgKey] = $content->data_values->$imgKey;
                    }
                }
            }
        }
        $content->update(['data_values' => $inputContentValue]);
        $notify[] = ['success', 'Content has been updated.'];
        return back()->withNotify($notify);
    }





    public function frontendElement($key, $id = null)
    {
        $section = @getPageSections()->$key;
        if (!$section) {
            return abort(404);
        }

        unset($section->element->modal);
        $page_title = $section->name . ' Items';
        if ($id) {
            $data = Frontend::findOrFail($id);
            return view('admin.frontend.element', compact('section', 'key', 'page_title', 'data'));
        }
        return view('admin.frontend.element', compact('section', 'key', 'page_title'));
    }



    protected function storeImage($imgJson,$type,$key,$image,$imgKey,$old_image = null)
    {
        $path = 'assets/images/frontend/' . $key;
        if ($type == 'element' || $type == 'content') {
            $size = @$imgJson
                ->$imgKey->size;
            $thumb = @$imgJson
                ->$imgKey->thumb;
        }else{
            $path = imagePath()[$key]['path'];
            $size = imagePath()[$key]['size'];
            $thumb = @imagePath()[$key]['thumb'];
        }
        return uploadImage($image, $path, $size, $old_image, $thumb);
    }

    public function remove(Request $request)
    {
        $request->validate(['id' => 'required']);
        $frontend = Frontend::findOrFail($request->id);
        if (isset($frontend->value->image)) {
            removeFile( 'assets/images/frontend/'.$frontend->key. '/' . $frontend->value->image);
        }
        $frontend->delete();
        $notify[] = ['success', 'Content has been removed.'];
        return back()->withNotify($notify);
    }


}
