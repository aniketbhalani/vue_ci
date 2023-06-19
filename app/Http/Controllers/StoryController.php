<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Story;

class StoryController extends Controller
{
    //
    public function index()
    {
        $stories = Story::with('mission', 'user')->get();
        return response()->json($stories);
    }

    public function show($id)
    {
        //$story = Story::findOrFail($id);
        $story = Story::with('mission', 'user','storyMedia')->findOrFail($id);
        return response()->json($story);
    }

    public function publish($id)
    {
        $story = Story::findOrFail($id);
        $story->status = 'PUBLISHED';
        $story->save();

        return response()->json(['message' => 'Story published successfully']);
    }

    public function decline($id)
    {
        $story = Story::findOrFail($id);
        $story->status = 'DECLINED';
        $story->save();

        return response()->json(['message' => 'Story declined successfully']);
    }

    public function destroy($id)
    {
        $story = Story::findOrFail($id);
        $story->delete();

        return response()->json(['message' => 'Story deleted successfully']);
    }
}
