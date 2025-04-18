<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use App\Models\Section;
use App\Models\NavBar;
use App\Models\Content;
use Illuminate\Support\Facades\Validator;

class ContentController extends Controller
{
    public function getPageContent(Request $request, $pageId)
    {

        $validator = Validator::make(['pageId' => $pageId], [
            'pageId' => 'required|exists:navbar,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $content = Section::where('nav_id', $pageId)->with('sectionContent')->get();
        foreach ($content as $singleSection) {
            foreach ($singleSection->sectionContent as $singleContent) {
                $singleContent->image1_path = $singleContent->image1_path ? asset($singleContent->image1_path) : $singleContent->image1_path;
                $singleContent->image2_path = $singleContent->image2_path ? asset($singleContent->image2_path) : $singleContent->image2_path;
                $singleContent->image3_path = $singleContent->image3_path ? asset($singleContent->image3_path) : $singleContent->image3_path;
                $singleContent->image4_path = $singleContent->image4_path ? asset($singleContent->image4_path) : $singleContent->image4_path;
                $singleContent->image5_path = $singleContent->image5_path ? asset($singleContent->image5_path) : $singleContent->image5_path;
                $singleContent->image6_path = $singleContent->image6_path ? asset($singleContent->image6_path) : $singleContent->image6_path;
            }
        }
        return $content ? $content : null;
    }

    public function getNavBar(Request $request)
    {
        return NavBar::all();
    }

    public function saveContent(Request $request)
    {
        $request->validate([
            'section_id' => 'required|exists:sections,id',
            'title' => 'nullable',
            'content' => 'nullable',
            'image1_path' => 'nullable',
            'image1_name' => 'nullable',
            'image2_path' => 'nullable',
            'image2_name' => 'nullable',
            'image3_path' => 'nullable',
            'image3_name' => 'nullable',
            'image4_path' => 'nullable',
            'image4_name' => 'nullable',
            'image5_path' => 'nullable',
            'image5_name' => 'nullable',
            'image6_path' => 'nullable',
            'image6_name' => 'nullable',
        ]);
        $content = new Content;
        $content->section_id = $request->section_id;
        $content->title = $request->title;
        $content->content = $request->content;
        if ($request->hasFile('image1_path')) {
            $file = $request->file('image1_path');
            $filename = time() . '_' . $file->getClientOriginalName(); // Unique filename
            $path = $file->storeAs('uploads/images', $filename, 'public'); // Store in storage/app/public/uploads/images
            $content->image1_path = 'storage/' . $path; // Store relative path in DB
        }
        $content->image1_name = $request->image1_name;
        if ($request->hasFile('image2_path')) {
            $file = $request->file('image2_path');
            $filename = time() . '_' . $file->getClientOriginalName(); // Unique filename
            $path = $file->storeAs('uploads/images', $filename, 'public'); // Store in storage/app/public/uploads/images
            $content->image2_path = 'storage/' . $path; // Store relative path in DB
        }
        $content->image2_name = $request->image2_name;
        if ($request->hasFile('image3_path')) {
            $file = $request->file('image3_path');
            $filename = time() . '_' . $file->getClientOriginalName(); // Unique filename
            $path = $file->storeAs('uploads/images', $filename, 'public'); // Store in storage/app/public/uploads/images
            $content->image3_path = 'storage/' . $path; // Store relative path in DB
        }
        $content->image3_name = $request->image3_name;
        if ($request->hasFile('image4_path')) {
            $file = $request->file('image4_path');
            $filename = time() . '_' . $file->getClientOriginalName(); // Unique filename
            $path = $file->storeAs('uploads/images', $filename, 'public'); // Store in storage/app/public/uploads/images
            $content->image4_path = 'storage/' . $path; // Store relative path in DB
        }
        $content->image4_name = $request->image4_name;
        if ($request->hasFile('image5_path')) {
            $file = $request->file('image5_path');
            $filename = time() . '_' . $file->getClientOriginalName(); // Unique filename
            $path = $file->storeAs('uploads/images', $filename, 'public'); // Store in storage/app/public/uploads/images
            $content->image5_path = 'storage/' . $path; // Store relative path in DB
        }
        $content->image5_name = $request->image5_name;
        if ($request->hasFile('image6_path')) {
            $file = $request->file('image6_path');
            $filename = time() . '_' . $file->getClientOriginalName(); // Unique filename
            $path = $file->storeAs('uploads/images', $filename, 'public'); // Store in storage/app/public/uploads/images
            $content->image6_path = 'storage/' . $path; // Store relative path in DB
        }
        $content->image6_name = $request->image6_name;
        $content->save();
        return $content;
    }

    public function updateContent(Request $request)
    {

        // dd($request->all());

        // $validatedData = $request->validate([
        //     'id' => 'required|exists:contents,id',
        //     'section_id' => 'required|exists:sections,id',
        //     'title' => 'nullable|string',
        //     'content' => 'nullable|string',
        //     'image1_path' => 'nullable|image',
        //     'image1_name' => 'nullable|string',
        //     'image2_path' => 'nullable|image',
        //     'image2_name' => 'nullable|string',
        //     'image3_path' => 'nullable|image',
        //     'image3_name' => 'nullable|string',
        //     'image4_path' => 'nullable|image',
        //     'image4_name' => 'nullable|string',
        //     'image5_path' => 'nullable|image',
        //     'image5_name' => 'nullable|string',
        //     'image6_path' => 'nullable|image', // Ensure it's validated as an image
        //     'image6_name' => 'nullable|string',
        // ]);
        //  dd($request->all());
        $content = Content::find($request->id);
        if (!$content) {
            return response()->json(['message' => 'Content not found'], 404);
        }

        $title  = $request->title ? $request->title : $content->title;
        $contentText = $request->content ? $request->content : $content->content;
        $content->title = $title;
        $content->content = $contentText;

        // dd($request->hasFile('image1_path'));
        if ($request->hasFile('image1_path')) {
            $file = $request->file('image1_path');
            $filename = time() . '_' . $file->getClientOriginalName(); // Unique filename
            $path = $file->storeAs('uploads/images', $filename, 'public'); // Store in storage/app/public/uploads/images
            $content->image1_path = 'storage/' . $path; // Store relative path in DB
            $content->image1_name = $request->image1_name ? $request->image1_name : $content->image1_name;
        }

        if ($request->hasFile('image2_path')) {
            $file = $request->file('image2_path');
            $filename = time() . '_' . $file->getClientOriginalName(); // Unique filename
            $path = $file->storeAs('uploads/images', $filename, 'public'); // Store in storage/app/public/uploads/images
            $content->image2_path = 'storage/' . $path; // Store relative path in DB
            $content->image2_name = $request->image2_name ? $request->image2_name : $content->image2_name;
        }

        if ($request->hasFile('image3_path')) {
            $file = $request->file('image3_path');
            $filename = time() . '_' . $file->getClientOriginalName(); // Unique filename
            $path = $file->storeAs('uploads/images', $filename, 'public'); // Store in storage/app/public/uploads/images
            $content->image3_path = 'storage/' . $path; // Store relative path in DB
            $content->image3_name = $request->image3_name ? $request->image3_name : $content->image3_name;
        }

        if ($request->hasFile('image4_path')) {
            $file = $request->file('image4_path');
            $filename = time() . '_' . $file->getClientOriginalName(); // Unique filename
            $path = $file->storeAs('uploads/images', $filename, 'public'); // Store in storage/app/public/uploads/images
            $content->image4_path = 'storage/' . $path; // Store relative path in DB
            $content->image4_name = $request->image4_name ? $request->image4_name : $content->image4_name;
        }

        if ($request->hasFile('image5_path')) {
            $file = $request->file('image5_path');
            $filename = time() . '_' . $file->getClientOriginalName(); // Unique filename
            $path = $file->storeAs('uploads/images', $filename, 'public'); // Store in storage/app/public/uploads/images
            $content->image5_path = 'storage/' . $path; // Store relative path in DB
            $content->image5_name = $request->image5_name ? $request->image5_name : $content->image5_name;
        }

        if ($request->hasFile('image6_path')) {
            $file = $request->file('image6_path');
            $filename = time() . '_' . $file->getClientOriginalName(); // Unique filename
            $path = $file->storeAs('uploads/images', $filename, 'public'); // Store in storage/app/public/uploads/images
            $content->image6_path = 'storage/' . $path; // Store relative path in DB
            $content->image6_name = $request->image6_name ? $request->image6_name : $content->image6_name;
        }



        $content->save();

        $section = Section::find($content->section_id);
        $contents = Section::where('nav_id',  $section->nav_id)->with('sectionContent')->get();
        foreach ($contents as $singleSection) {
            foreach ($singleSection->sectionContent as $singleContent) {
                $singleContent->image1_path = $singleContent->image1_path ? asset($singleContent->image1_path) : $singleContent->image1_path;
                $singleContent->image2_path = $singleContent->image2_path ? asset($singleContent->image2_path) : $singleContent->image2_path;
                $singleContent->image3_path = $singleContent->image3_path ? asset($singleContent->image3_path) : $singleContent->image3_path;
                $singleContent->image4_path = $singleContent->image4_path ? asset($singleContent->image4_path) : $singleContent->image4_path;
                $singleContent->image5_path = $singleContent->image5_path ? asset($singleContent->image5_path) : $singleContent->image5_path;
                $singleContent->image6_path = $singleContent->image6_path ? asset($singleContent->image6_path) : $singleContent->image6_path;
            }
        }
        return $contents;
    }

    public function updateAddress(Request $request)
    {
        $validator = Validator::make([$request->all()], [
            'id'=>'required|exists:address,id',
            'address_line_1'=>'required',
            'address_line_2'=>'nullable',
            'city'=>'required',
            'state'=>'required',
            'country'=>'required',
            'postal_code'=>'required',
            'phone_number'=>'nullable',
            'phone_2'=>'nullable',
            'email_address'=>'required',
            'google_map_url'=>'required',
            'is_default'=>'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $address = Address::find($request->id);
        $address->address_line_1 = $request->address_line_1;
        $address->address_line_2 = $request->address_line_2;
        $address->is_default = $request->is_default;
        $address->city = $request->city;
        $address->state = $request->state;
        $address->country = $request->country;
        $address->postal_code = $request->postal_code;
        $address->phone_number = $request->phone_number;
        $address->phone_2 = $request->phone_2;
        $address->email_address = $request->email_address;
        $address->google_map_url = $request->google_map_url;
        $address->save();
    }

    public function getAddress(Request $request){
        $address = Address::all();
        return $address;
    }
}
