<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mission;
class MissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Mission::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mission $mission)
    {
        $mission->delete();

        return response()->json(['message' => 'Product deleted successfully']);
    }
}