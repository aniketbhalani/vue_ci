<?php

namespace App\Http\Controllers;


use App\Http\Requests\StoreSkillRequest;
use App\Http\Requests\UpdateSkillRequest;
use App\Models\Skill;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;

class MissionSkillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index(Request $request)
    // {
    //     $data = Skill::where([
    //         ['skill_name', '!=', Null],
    //         [function ($query) use ($request) {
    //             if (($s = $request->s)) {
    //                 $query->orWhere('skill_name', 'LIKE', '%' . $s . '%')
    //                     ->get();
    //             }
    //         }]
    //     ])->orderBy('created_at','desc')
    //         ->paginate(10);
    //     $pagination = $data->links()->render();
    //     if($data instanceof LengthAwarePaginator){
    //         $pagination = $data->appends(request()->all())->links('pagination.default');
    //     }
    //     //$data = Skill::orderBy('skill_id','desc')->paginate(10);
    //     return view("admin.missionskill.index", compact('data','pagination'));
    // }
    public function index()
    {
        return Skill::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     return view('admin.missionskill.create');
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSkillRequest $request)
    {
        //dd($request->toArray());
        return Skill::create($request->all());
        //dd(Skill::all());

    }

    /**
     * Display the specified resource.
     */
    public function show(Skill $missionskill)
    {
        return $missionskill;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Skill $skill, $id)
    {
        // $skill = $skill->find($id);
        // return view('admin.missionskill.edit', compact('skill'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSkillRequest $request, Skill $missionskill)
    {
        //dd($request->toArray());
        $missionskill->update($request->all());

        return $missionskill;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Skill $missionskill)
    {
        $missionskill->delete();

        return response()->json(['message' => 'Product deleted successfully']);
    }
}
