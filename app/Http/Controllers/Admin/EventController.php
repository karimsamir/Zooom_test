<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {

        $events = Event::all();
        // get all countries to be displayed in ddl
        $countries = Country::getAllCountries();
        // get all categories to be displayed in ddl
        $categories = Category::getAllCategories();

//        die(var_dump($arrEvents->toArray()));

        return view("admin.event.index", [
            "events" => $events,
            "countries" => $countries,
            "categories" => $categories
        ]);
    }

}
