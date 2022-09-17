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

    //update a achievement
    public function update(Request $request)
    {
        try {

            $validator =  Validator::make($request->all(), [
                'id' => 'required|integer'
            ]);
            if ($validator->fails()) return BaseController::error($validator->errors()->first(), $validator->errors());

            // validate if request limit is less then existing assigned count
            $achievement = Achievement::find($request->id);
            if ($achievement->assigned_count > $request->limit) {
                return BaseController::error('Limit can not be decreased. It is already assigned to some todo.');
            }

            $achievement = Achievement::where('id', $request->id)->first();
            if (!$achievement) return BaseController::error('Achievement not found');
            $achievement->title = isset($request->title) ? $request->title : $achievement->title;
            $achievement->description = isset($request->note) ? $request->description : $achievement->description;
            $achievement->points = isset($request->points) ? $request->points : $achievement->points;
            $achievement->limit = isset($request->limit) ? $request->limit : $achievement->limit;


            $achievement->save();
            $allAchievement = Achievement::all();

            return BaseController::success('Achievement updated successfully', $allAchievement);
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
