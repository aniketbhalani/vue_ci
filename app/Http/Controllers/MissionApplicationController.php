<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MissionApplication;
use App\Models\Mission;
use App\Models\TimeMission;

class MissionApplicationController extends Controller
{
    public function getMissionApplications()
    {
        $missionApplications = MissionApplication::with('mission', 'user')->get();
        return response()->json($missionApplications);
    }

    public function approveApplication(Request $request)
    {
        $applicationId = $request->query('mission_application_id');
        $application = MissionApplication::find($applicationId);

        if (!$application) {
            return response()->json(['message' => 'Application not found'], 404);
        }

        $application->approval_status = "APPROVE";
        $application->save();

        $mission = Mission::find($application->mission_id);

        if ($mission && $mission->timeMission) {
            $timeMission = TimeMission::find($mission->timeMission->time_mission_id);

            if ($timeMission) {
                $timeMission->total_seats = $timeMission->total_seats - 1;
                $timeMission->save();
            }
        }

        return response()->json(['message' => 'Application approved successfully']);
    }

    public function rejectApplication(Request $request)
    {
        $applicationId = $request->query('mission_application_id');
        $application = MissionApplication::find($applicationId);

        if (!$application) {
            return response()->json(['message' => 'Application not found'], 404);
        }

        if ($application->approval_status == "APPROVE") {
            $mission = Mission::find($application->mission_id);

            if ($mission && $mission->timeMission) {
                $timeMission = TimeMission::find($mission->timeMission->time_mission_id);

                if ($timeMission) {
                    $timeMission->total_seats = $timeMission->total_seats + 1;
                    $timeMission->save();
                }
            }
        }

        $application->approval_status = "DECLINE";
        $application->save();

        return response()->json(['message' => 'Application rejected successfully']);
    }
}
