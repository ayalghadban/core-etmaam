<?php

namespace App\Http\Controllers;

use App\BasicExtended;
use App\BasicExtra;
use App\Language;
use App\Package;
use App\PackageCategory;
use App\RequestCategory;
use App\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class RequestController extends Controller
{
    public function index(Request $request)
    {
        $lang = Language::where('code', $request->language)->first();

        $lang_id = $lang->id;
        $data['requests'] = \App\Request::with('category')->where('language_id', $lang_id)->orderBy('id', 'DESC')->get();
        //$data['abx'] = $lang->basic_extra;
      //  dd($data);
        $data['lang_id'] = $lang_id;

      //  $data['categoryInfo'] = BasicExtra::first();

        return view('admin.request.index', $data);
    }

    public function getCategories($langId)
    {
        $main_categories = RequestCategory::where('language_id', $langId)
            ->where('cat_id', 0)
            ->where('active', 1)
            ->get();

        return $main_categories;
    }
    public function getSubCategories($catid)
    {
        $sub_categories = RequestCategory::where('cat_id', $catid)
            ->where('active', 1)
            ->orderBy('order_cat')
            ->get();

        return $sub_categories;
    }
    public function getPackages($catid)
    {
        $packages = Section::where('id',$catid)->with('packages')->get();

        return $packages;
    }
    public function getServices($catid)
    {
        $services = \App\Request::where('cat_id', $catid)
            ->where('active', 1)->get()->sortByDesc(function($cat){
            return strlen($cat->name);
        });

        return $services;
    }
    public function delete(Request $request)
    {
        $package = \App\Request::findOrFail($request->request_id);

        $package->delete();

        Session::flash('success', 'Request deleted successfully!');
        return back();
    }
    public function categories(Request $request)
    {
        $lang = Language::where('code', $request->language)->first();

        $lang_id = $lang->id;
        $data['categories'] = RequestCategory::where('language_id', $lang_id)->orderBy('id', 'DESC')->get();
        $data['abx'] = $lang->basic_extra;

        $data['lang_id'] = $lang_id;

        return view('admin.request.categories', $data);
    }

    public function enable(Request $request)
    {
        $package = \App\Request::find($request->request_id);
    //    dd($request->active);
        $package->active = $request->active;
        $package->save();

        if ($request->active == 1) {
            Session::flash('success', 'Enabled successfully!');
        } else {
            Session::flash('success', 'Disabled successfully!');
        }

        return back();
    }

    public function store(Request $request)
    {

        $rules = [
            'language_id' => 'required',
            'category_id' => 'required',
            'title' => 'required|max:50'
        ];


        $messages = [
            'language_id.required' => 'The language field is required'
        ];

            $messages['category_id.required'] = 'The category field is required';




        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $package = new \App\Request;
        $package->language_id = $request->language_id;
        $package->name = $request->title;

        if( $request->active == "true") $package->active = 1;

        $package->description = $request->description;

        $package->cat_id = $request->category_id;
        $package->save();

        Session::flash('success', 'Service added successfully!');
        return "success";
    }

}
