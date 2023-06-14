<?php

namespace App\Http\Controllers;


use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\CmsPage;
use App\Http\Requests\StoreCmsPageRequest;
use App\Http\Requests\UpdateCmsPageRequest;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class CmsPageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return CmsPage::all();
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.cmspage.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCmsPageRequest $request)
    {
        // $request->validated();

        return CmsPage::create($request->post());


    }

    /**
     * Display the specified resource.
     */
    public function show(CmsPage $cmspage)
    {
        return $cmspage;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CmsPage $cmspage)
    {
       dd($cmspage);


    }
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCmsPageRequest $request, CmsPage $cmspage)
    {


        $cmspage->update($request->all());

        return $cmspage;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CmsPage $cmspage)
    {
        $cmspage->delete();

        return response()->json(['message' => 'Product deleted successfully']);
    }
}
