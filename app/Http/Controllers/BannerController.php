<?php

namespace App\Http\Controllers;


use App\Http\Requests\StoreBannerRequest;
use App\Http\Requests\UpdateBannerRequest;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return Banner::all();
    }

    /**
     * Show the form for creating a new resource.
     */


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBannerRequest $request)
    {
        $banner = new Banner;
        $banner->text = $request->text;
        $banner->sort_order = $request->sort_order;
             //This is photo storing code
        $photo = $request->image;
        //dd($photo);
        $imageName = $photo->getClientOriginalName().'.'.uniqid().'.'.$photo->getClientOriginalExtension();

        $imagePath = $photo->storeAs('banner',$imageName, 'public');
        $banner->image = $imagePath;
        $banner->save();
        $message = "Banner created successfully";

        return response()->json(['banner' => $banner, 'message' => $message]);
    }


    /**
     * Display the specified resource.
     */
    public function show(Banner $banner)
    {
        return response()->json($banner);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        // $banner = Banner::find($id);
        // return view('admin.banner.edit',compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBannerRequest $request,string $id)
    {
        $banner=Banner::find($id);
        $banner->text = $request->text;
        $banner->sort_order = $request->sort_order;
        if($request->image!=null){
            $photo = $request->file('image');
            $imageName = $photo->getClientOriginalName().'.'.uniqid().'.'.$photo->getClientOriginalExtension();
            $imagePath = $photo->storeAs('banner',$imageName, 'public');
            $banner->image = $imagePath;
        }
        $banner->update();
        $message = "Banner updated successfully";

        return response()->json(['banner' => $banner, 'message' => $message]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Banner $banner)
    {
        $banner->delete();

        return response()->json(['message' => 'Product deleted successfully']);
    }
}

