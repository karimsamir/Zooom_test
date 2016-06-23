<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
//import models
use App\Event;
use App\Country;
use App\Category;

class EventController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the event listing page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {

        $events = Event::all();
        // get all countries to be displayed in ddl
        $countries = Country::getAllCountries();
        // get all categories to be displayed in ddl
        $categories = Category::getAllCategories();

        return view("admin.event.index", [
            "events" => $events,
            "countries" => $countries,
            "categories" => $categories
        ]);
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

            // save new event to DB
            Event::create($request->all());

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
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response edit view
     */
    public function edit(Request $request, $id) {

        // get all countries to be displayed in ddl
        $countries = Country::getAllCountries();
        // get all categories to be displayed in ddl
        $categories = Category::getAllCategories();

        // get all events ordered by position
        $events = Event::all();

        $view_variables = array(
            "events" => $events,
            "countries" => $countries,
            "categories" => $categories);

        if ($request->ajax()) {

            return view($this->view_path . "includes.ajaxIndex", $view_variables);
        } else {

            if (count($events) > 0) {
                return view($this->view_path . "edit", $view_variables);
            } else {
                return redirect(route("createEvent"));
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

                Event::where("id", $id)->update([
                    'country_id' => $inputs["country_id"],
                    'category_id' => $inputs["category_id"],
                    'title' => $inputs["title"],
                    'location' => $inputs["location"],
                    'longitude' => $inputs["longitude"],
                    'latitude' => $inputs["latitude"],
                    'zip' => $inputs["zip"],
                    'description' => $inputs["description"],
                    'start_date' => $inputs["start_date"],
                    'end_date' => $inputs["end_date"],
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
     * Remove the event.
     * @param  int  $id
     * @return json response
     */
    public function destroy(Request $request, $id) {

        // get event event with event_id
        $event = Event::find($id)->first();

        if ($event && $request->ajax()) {

            $event->delete();

            return response(['msg' => 'Event deleted successfully', 'status' => 'success']);
        }
        return response(['msg' => 'Failed to delete event', 'status' => 'failed']);
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
