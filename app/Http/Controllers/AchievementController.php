<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AchievementController extends Controller
{
    public function index()
    {
        try {
            $allAchievement = Achievement::all();
            return BaseController::success('All achievement list', $allAchievement);
        } catch (Exception $e) {
            return $e;
            return BaseController::error('Something went wrong.');
        }
    }

    //a achievement create function
    public function create(Request $request)
    {
        try {

            $validator =  Validator::make($request->all(), [
                'title' => 'required',
                'points' => 'required|integer',
                'limit' => 'required|integer',
            ]);

            if ($validator->fails()) {
                return BaseController::error('Validation error', $validator->errors());
            }

            $achievement = new Achievement();
            $achievement->title = $request->title;
            $achievement->description = isset($request->note) ? $request->description : null;
            $achievement->points = $request->points;
            $achievement->limit = $request->limit;

            $achievement->save();
            $allAchievement = Achievement::all();

            return BaseController::success('Achievement created successfully', $allAchievement);
        } catch (Exception $e) {
            return $e;
            return BaseController::error('Something went wrong.');
        }
    }

    //delete a achievement
    public function delete(Request $request)
    {
        try {

            $validator =  Validator::make($request->all(), [
                'id' => 'required|integer'
            ]);
            if ($validator->fails()) return BaseController::error($validator->errors()->first(), $validator->errors());
            $achievement = Achievement::find($request->id);
            if ($achievement) {
                $achievement->delete();
                $allAchievement = Achievement::all();
                return BaseController::success('Achievement deleted successfully', $allAchievement);
            } else {
                return BaseController::error('Achievement not found');
            }
        } catch (Exception $e) {
            return $e;
            return BaseController::error('Something went wrong.');
        }
    }
}
