<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMissionRequest;
use App\Http\Requests\UpdateMissionRequest;
use App\Models\GoalMission;
use Illuminate\Http\Request;
use App\Models\Mission;
use App\Models\MissionDocument;
use App\Models\MissionMedia;
use App\Models\MissionSkill;
use App\Models\TimeMission;
use Illuminate\Support\Facades\Storage;

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
    public function store(StoreMissionRequest $request)
    {

        //dd($request);
        $mission = Mission::create($request->post());
        // $document_path = $request->file('document_name')->store('mission_documents');

        // // Get the document type from the file extension
        // $document_type = $request->file('document_name')->getClientOriginalExtension();

        // // Create a new mission document record in the database
        // $mission_document = new MissionDocument([
        //     'document_name' => $request->file('document_name')->getClientOriginalName(),
        //     'document_type' => $document_type,
        //     'document_path' => $document_path
        // ]);
        // // $mission_document->save();
        // $mission->missionDocument()->save($mission_document);



        if ($request->hasfile('document_name')) {
            foreach ($request->file('document_name') as $file) {
                $fileName = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $uniqueName = uniqid() . '_' . $fileName;
                $file->storeAs('missions_documents', $uniqueName, 'public');
                MissionDocument::create([
                    'mission_id' => $mission->mission_id,
                    'document_name' => $uniqueName,
                    'document_type' => $extension,
                    'document_path' => 'storage/missions_documents/' . $uniqueName,
                ]);
            }
        }

        //  mission images code
        $images = $request->file('media_name');
        if ($images) {
            foreach ($images as $key => $image) {
                // generating unique name for the image with uniqueid
                $imageName = uniqid() . '.' . $image->getClientOriginalExtension();

                // save image to storage/mission_media directory with the above generated name
                $imagePath = $image->storeAs('mission_media', $imageName, 'public');

                // get file extension
                $extension = $image->getClientOriginalExtension();

                //saving in database
                $missionMedia = new MissionMedia([
                    'mission_id' => $mission->mission_id,
                    'media_name' => $image->getClientOriginalName(),
                    'media_type' => $extension,
                    'media_path' => $imagePath,
                    'default' => ($key == 0 ? 1 : 0) // mark first image as default
                ]);

                $missionMedia->save();
            }
        }


        // mission video code
        $videoUrl = $request->input('media_names');
        if ($videoUrl) {
            // check if youtube url is valid
            $pattern = '/^(https?\:\/\/)?(www\.)?(youtube\.com|youtu\.?be)\/.+$/';
            if (preg_match($pattern, $videoUrl)) {
                // create mission media entry for the video
                $missionMedia = new MissionMedia([
                    'mission_id' => $mission->mission_id,
                    'media_name' => 'youtube',
                    'media_type' => 'MP4',
                    'media_path' => $videoUrl,
                    'default' => 1 // mark first video as default
                ]);

                $missionMedia->save();
            }
        }
        // missiob skill code
        foreach ($request->input('skill_id') as $skill_id) {
            $missionSkill = new MissionSkill([
                'skill_id' => $skill_id,
                'mission_id' => $mission->mission_id,
            ]);
            $missionSkill->save();
        }
        if ($request->get('mission_type') === 'GOAL') {
            $goalMission = new GoalMission([
                'goal_objective_text' => $request->input('goal_objective_text'),
                'goal_value' => $request->input('goal_value'),
                'mission_id' => $mission->mission_id,
            ]);

            $goalMission->save();
        }
        if ($request->get('mission_type') === 'TIME') {
            $timeMission = new TimeMission([
                'total_seats' => $request->input('total_seats'),
                'registration_deadline' => $request->input('registration_deadline'),
                'mission_id' => $mission->mission_id,
            ]);

            $timeMission->save();
        }
        $message = " mission created successfully";
        return response()->json(['message' => $message], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $mission = mission::with('skill', 'country', 'city', 'missionTheme', 'missionDocument', 'missionMedia', 'missionSkill', 'goalMission', 'timeMission')->findOrFail($id);
        return response()->json($mission);
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
    public function update(UpdateMissionRequest $request, $id)
    {
        //dd($request->toArray());
        // $mission=new Mission;
        // $request->validated();
        // $mission->find($id)
        //              ->fill($request->post())
        //              ->save();
        //              dd($mission->mission_type);
        // return redirect()->route('mission.index')->with('success','field Has Been updated successfully');

        $mission = Mission::find($id);
        $currentMissionType = $mission->mission_type;
        //dd($currentMissionType);
        $newMissionType = $request->post('mission_type');
        //dd($newMissionType);
        $mission->fill($request->post())->save();

        $mission->update($request->all());

        // Move mission data between tables based on mission type change
        if ($currentMissionType !== $newMissionType) {
            if ($currentMissionType === 'TIME') {
                $timeMission = TimeMission::where('mission_id', $id)->first();
                $goalMission = new GoalMission();
                $goalMission->fill([
                    'mission_id' => $mission->mission_id,
                    'goal_objective_text' => $request->post('goal_objective_text'),
                    'goal_value' => $request->post('goal_value'),
                ])->save();

                if ($timeMission) {
                    $timeMission->delete();
                }
            } elseif ($currentMissionType === 'GOAL') {
                $goalMission = GoalMission::where('mission_id', $id)->first();
                $timeMission = new TimeMission();
                $timeMission->fill([
                    'mission_id' => $mission->mission_id,
                    'total_seats' => $request->post('total_seats'),
                    'registration_deadline' => $request->post('registration_deadline'),
                ])->save();

                if ($goalMission) {
                    $goalMission->delete();
                }
            }
        }

        $selectedDocuments = $request->input('selected_documents', []);
       // dd($selectedDocuments);
        $documentsToDelete = array_diff($mission->missionDocument()->pluck('mission_document_id')->toArray(), $selectedDocuments);

        if($documentsToDelete){
        foreach ($documentsToDelete as $documentId) {
            $document = MissionDocument::find($documentId);

            if ($document) {
                $filePath = $document->document_path;
                Storage::delete('public/' .  $filePath);
            }
            $document->delete();
        }
    }
        if ($request->hasfile('document_name')) {
            foreach ($request->file('document_name') as $file) {
                $fileName = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $uniqueName = uniqid() . '_' . $fileName;
                $file->storeAs('missions_documents', $uniqueName, 'public');
                MissionDocument::create([
                    'mission_id' => $mission->mission_id,
                    'document_name' => $uniqueName,
                    'document_type' => $extension,
                    'document_path' => 'storage/missions_documents/' . $uniqueName,
                ]);
            }
        }

        // handle mission images
        $selectedMedia = $request->input('selected_media', []);
        $imagesToDelete = array_diff($mission->missionMedia()->where('media_name', '!=', 'youtube')->pluck('mission_media_id')->toArray(), $selectedMedia);
        //dd($imagesToDelete);
        //dd($selectedMedia);
        $missionImages = MissionMedia::where('mission_id', $id)->get();
        //dd($missionImages);
        if($imagesToDelete);
        foreach ($imagesToDelete as $mediaId) {
            $media = MissionMedia::find($mediaId);

            if ($media) {
                $filePath = $media->media_path;
                Storage::delete('public/' .  $filePath);
            }
            $media->delete();
        }

        $images = $request->file('media_name');
        if ($images) {
            foreach ($images as $key => $image) {
                // generate unique name for the image
                $imageName = uniqid() . '.' . $image->getClientOriginalExtension();

                // save image to storage/mission_media directory with the generated name
                $imagePath = $image->storeAs('mission_media', $imageName, 'public');

                // get file extension
                $extension = $image->getClientOriginalExtension();

                // create mission media entry for the image
                $missionMedia = new MissionMedia([
                    'mission_id' => $mission->mission_id,
                    'media_name' => $image->getClientOriginalName(),
                    'media_type' => $extension,
                    'media_path' => $imagePath,
                    'default' => ($key == 0 ? 1 : 0) // mark first image as default
                ]);

                $missionMedia->save();
            }
        }

        $videoUrl = $request->input('media_names');
        if ($videoUrl) {
            // checking youtube url is valid
            $pattern = '/^(https?\:\/\/)?(www\.)?(youtube\.com|youtu\.?be)\/.+$/';
            if (preg_match($pattern, $videoUrl)) {
                // creating mission media entry for  video
                $missionMedia = new MissionMedia([
                    'mission_id' => $mission->mission_id,
                    'media_name' => 'youtube',
                    'media_type' => 'MP4',
                    'media_path' => $videoUrl,
                    'default' => 1
                ]);

                $missionMedia->save();
            }
        }

        // Update the mission skills
        $selected_skills = $request->input('skill_id');

        // Delete the unselected skills
        $unselected_skills = MissionSkill::where('mission_id', $mission->mission_id)
            ->whereNotIn('skill_id', $selected_skills)
            ->delete();

        // Insert the new selected skills
        foreach ($selected_skills as $skill_id) {
            $missionSkill = MissionSkill::where('mission_id', $mission->mission_id)
                ->where('skill_id', $skill_id)
                ->first();

            if (!$missionSkill) {
                $missionSkill = new MissionSkill([
                    'skill_id' => $skill_id,
                    'mission_id' => $mission->mission_id,
                ]);
                $missionSkill->save();
            }
        }

        $message = " mission updated successfully";
        return response()->json(['message' => $message], 200);
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
