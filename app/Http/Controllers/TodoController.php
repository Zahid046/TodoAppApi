<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TodoController extends Controller
{
    public function index()
    {
        try {
            $allTodo = Todo::all();
            return BaseController::success('All todo list', $allTodo);
        } catch (Exception $e) {
            return BaseController::error('Something went wrong.');
        }
    }

    public function totalCompleted()
    {
        try {
            $totalCompleted = Todo::where('is_completed', 1)->count();
            return BaseController::success('Total completed todo', $totalCompleted);
        } catch (Exception $e) {
            return BaseController::error('Something went wrong.');
        }
    }

    public function totalIncomplete()
    {
        try {
            $totalIncomplete = Todo::where('is_completed', 0)->count();
            return BaseController::success('Total incomplete todo', $totalIncomplete);
        } catch (Exception $e) {
            return BaseController::error('Something went wrong.');
        }
    }

    public function create(Request $request)
    {
        try {

            $validator =  Validator::make($request->all(), [
                'title' => 'required',
                'start_date' => 'required|date',
                'end_date' => 'required|date',
                'start_time' => 'required',
                'end_time' => 'required',
            ]);
            if ($validator->fails()) return BaseController::error($validator->errors()->first(), $validator->errors());

            $todo = new Todo();
            $todo->title = $request->title;
            $todo->note = isset($request->note) ? $request->note : null;
            $todo->start_date =  Carbon::parse($request->start_date)->format('Y-m-d');
            $todo->end_date =  Carbon::parse($request->end_date)->format('Y-m-d');
            $todo->start_time =  Carbon::parse($request->start_time)->format('H:i');
            $todo->end_time =  Carbon::parse($request->end_time)->format('H:i');

            $todo->save();
            $allTodo = Todo::all();
            return BaseController::success('New todo added', $allTodo);
        } catch (Exception $e) {
            return $e;
            return BaseController::error('Something went wrong.');
        }
    }

    public function update(Request $request)
    {
        try {

            $validator =  Validator::make($request->all(), [
                'id' => 'required|integer'
            ]);
            if ($validator->fails()) return BaseController::error($validator->errors()->first(), $validator->errors());

            $todo = Todo::where('id', $request->id)->first();
            if (!$todo) return BaseController::error('Todo not found');

            $todo->title =  isset($request->title) ? $request->title : $todo->title;
            $todo->note = isset($request->note) ? $request->note : $todo->note;
            $todo->start_date =  isset($request->start_date) ? Carbon::parse($request->start_date)->format('Y-m-d') : $todo->start_date;
            $todo->end_date =  isset($request->end_date) ? Carbon::parse($request->end_date)->format('Y-m-d') : $todo->end_date;
            $todo->start_time =  isset($request->start_time) ? Carbon::parse($request->start_time)->format('H:i') : $todo->start_time;
            $todo->end_time =  isset($request->end_time) ? Carbon::parse($request->end_time)->format('H:i') : $todo->end_time;

            $todo->save();
            $allTodo = Todo::all();
            return BaseController::success('Updated successfully', $allTodo);
        } catch (Exception $e) {
            return BaseController::error('Something went wrong.');
        }
    }

    public function delete(Request $request)
    {
        try {

            $validator =  Validator::make($request->all(), [
                'id' => 'required|integer'
            ]);
            if ($validator->fails()) return BaseController::error($validator->errors()->first(), $validator->errors());

            $todo = Todo::find($request->id);
            if (!$todo) return BaseController::error('Todo not found');

            $todo->delete();
            $allTodo = Todo::all();
            return BaseController::success('Deleted successfully', $allTodo);
        } catch (Exception $e) {

            return BaseController::error('Something went wrong.');
        }
    }

    public function toggle(Request $request)
    {
        try {

            $validator =  Validator::make($request->all(), [
                'id' => 'required|integer'
            ]);
            if ($validator->fails()) return BaseController::error($validator->errors()->first(), $validator->errors());

            $todo = Todo::find($request->id);
            if (!$todo) return BaseController::error('Todo not found');

            $todo->is_completed = $todo->is_completed ? 0 : 1;
            $todo->save();
            return $todo->is_completed ? BaseController::success('Todo marked as complete', $todo) : BaseController::success('Todo marked as incomplete', $todo);
        } catch (Exception $e) {
            return BaseController::error('Something went wrong.');
        }
    }

    public function show(Request $request)
    {
        try {

            $validator =  Validator::make($request->all(), [
                'id' => 'required|integer'
            ]);
            if ($validator->fails()) return BaseController::error($validator->errors()->first(), $validator->errors());

            $todo = Todo::find($request->id);
            if (!$todo) return BaseController::error('Todo not found');

            return BaseController::success('Todo details', $todo);
        } catch (Exception $e) {
            return BaseController::error('Something went wrong.');
        }
    }
}
