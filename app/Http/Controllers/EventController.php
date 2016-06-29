<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
//import models
use App\Event;
use App\Country;
use App\Category;
use Carbon\Carbon;
//use Agent;
use Jenssegers\Agent\Agent;

class EventController extends Controller {

    /**
     * Show the event listing page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {

        $categories = Category::orderBy('id', "ASC")->get();

        $event = new Event();

        foreach ($categories as $key => $category) {

            $categories[$key]["events"] = $event->getAllEventsByCategory($category->id);
        }

        $agent = new Agent();

        $viewVariables = array(
            "categories" => $categories,
            "isMobile" => $agent->isMobile(),
            "staticMarkers" => "",
            "staticMarkersCounter" => 0
        );

//        if($agent->isTablet()){
//            die("mobile detected");
//        }
//        elseif($agent->isMobile()){
//            die("tab detected");
//        }

        return view("event.index", $viewVariables);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request) {

        $validator = $this->validateRules($request);
        if ($validator->fails()) {

            if ($request->ajax()) {
                return array(
                    'status' => "fail",
                    'msg' => $validator->getMessageBag()->toArray()
                );
            } else {
                return redirect(route('createEvent'))
                                ->withErrors($validator)
                                ->withInput();
            }
        } else {

            $inputs = $request->all();

            $inputs["start_date"] = Carbon::createFromFormat('d-m-Y', $inputs["start_date"])->format('Y-m-d');
            $inputs["end_date"] = Carbon::createFromFormat('d-m-Y', $inputs["end_date"])->format('Y-m-d');

            $last_event_position = Event::all()->max('position');
//            die(var_dump($last_event_position));
            $inputs["position"] = $last_event_position + 1;
            // save new event to DB
            Event::create($inputs);

            if ($request->ajax()) {

                return array(
                    'status' => "success",
                    'msg' => "Event added successfully"
                );
            } else {
                return redirect(route('showEvent', $id))->with([
                            "success" => "Event added successfully!!"
                ]);
            }
        }
    }

    /**
     * Update the event event and redirect to event list page
     *
     * @param Request $request
     * @param  int  $id
     * @return  response if ajax it returns json, otherwise it redirects to show
     */
    public function update(Request $request, $id) {

        $validator = $this->validateRules($request);
        $inputs = $request->all();

        if ($request->ajax()) {
            if ($validator->fails()) {

                $arr_result = array(
                    'status' => "fail",
                    'msg' => $validator->getMessageBag()->toArray()
                );
            } else {

                $start_date = Carbon::createFromFormat('d-m-Y', $inputs["start_date"])->format('Y-m-d');
                $end_date = Carbon::createFromFormat('d-m-Y', $inputs["end_date"])->format('Y-m-d');

                Event::where("id", $id)->update([
                    'country_id' => $inputs["country_id"],
                    'category_id' => $inputs["category_id"],
                    'title' => $inputs["title"],
                    'location' => $inputs["location"],
                    'longitude' => $inputs["longitude"],
                    'latitude' => $inputs["latitude"],
                    'zip' => $inputs["zip"],
                    'description' => $inputs["description"],
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                ]);

                $arr_result = array(
                    'status' => "success",
                    'msg' => "Event updated successfully"
                );
            }

            return response()->json($arr_result);
        } else {
            return redirect(route("showEvent", $inputs->id));
        }
    }

    /**
     * Remove event.
     * @param  int  $id
     * @return json response
     */
    public function destroy(Request $request, $id) {

        // get event event with event_id
        $event = Event::find($id);

        if ($event && $request->ajax()) {

            $event->delete();

            return response(['msg' => 'Event deleted successfully', 'status' => 'success']);
        }
        return response(['msg' => 'Failed to delete event', 'status' => 'failed']);
    }

    /**
     * update event positions
     * @param Request $request
     */
    public function changePosition(Request $request) {

        if ($request->ajax()) {
            $Event = new Event();
            $Event->updatePositions($request->all()["positions"]);
        } else {
            abort(404);
        }
    }

    /**
     * Check for validation errors
     * @param $request
     * @return validator
     */
    private function validateRules($request) {

        $rules = array(
            "country_id" => "required",
            "category_id" => "required",
            "title" => "required|max:150",
            "location" => "required|max:255",
            "start_date" => "required",
            "end_date" => "required"
        );

        $messages = array(
            'country_id.required' => 'Please select country!',
            'category_id.required' => 'Please select category!',
            'title.required' => 'Please enter title!',
            'location.required' => 'Please enter event location!',
            'start_date.required' => 'Please enter event start date!',
            'end_date.required' => 'Please enter event end date!',
        );

        return Validator::make($request->all(), $rules, $messages);
    }

}
