<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banners = Banner::get();
        return view('admin.banner.index', compact(['banners']));

    }

    public function list()
    {
        $banners = Banner::orderBy('order','asc')->get();
        return response()->json([
            'result' => 'success',
            'data' => $banners
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         return view('admin.banner.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $banner = new Banner();

        /*$image = $request->file('image');
        $imageName = time() . '_' . $image->getClientOriginalName();
        $imagePath = public_path() . '/uploads/banners/';
        $image->move($imagePath, $imageName);*/
        $image="";
        if ($request->hasFile('image')){
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension(); // you can also use file name
            $fileName = time().'.'.$extension;
            $path = public_path().'/uploads/banners/';
            $uplaod = $file->move($path,$fileName);
            $image = url('/').'/uploads/banners/'.$fileName;
        }

        $banner->image = $image;
        $banner->link = $request->link;
        $banner->order = $request->order;

        $banner->save();
        return redirect()->back()->with('Success', 'Banner is succesfully added!');
        return response()->json([
            'result' => 'success',
            'message' => 'Banner is succesfully added!'
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $banner = Banner::find($id);
        return response()->json([
            'result' => 'success',
            'data' => $banner
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $banner = Banner::find($id);
        return view('admin.banner.edit', compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $banner = Banner::find($id);

        $image="";
        if ($request->hasFile('image')){
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension(); // you can also use file name
            $fileName = time().'.'.$extension;
            $path = public_path().'/uploads/banners/';
            $uplaod = $file->move($path,$fileName);
            $image = url('/').'/uploads/banners/'.$fileName;
        }

        $banner->image = $image;
        
        $banner->link = $request->link;
        $banner->order = $request->order;

        if ($banner->save()) {
            return redirect()->back()->with('Success', 'Category Updated Successfully.');
        } else {
            return redirect()->back()->with('Error', 'Unable to update category at this moment.');
        }
        return response()->json([
            'result' => 'success',
            'message' => 'Banner is succesfully updated!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $banner = Banner::find($id);
        $banner->delete();
        return response()->json([
            'result' => 'success',
            'message' => 'Banner is succesfully deleted!'
        ]); 
    }
}
