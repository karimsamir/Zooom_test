<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */

Route::group(['middleware' => ['web']], function() {

    // frontend controller
    Route::resource('/', 'EventController', [
        "except" => ["edit", "show"],
        'names' =>
        [
            'index' => 'indexEvent',
            'create' => 'createEvent',
            'store' => 'storeEvent',
            'update' => 'updateEvent',
            'destroy' => 'deleteEvent'
        ]
            ]
    );
    
    Route::auth();

    Route::group(['middleware' => 'auth'], function () {
        
        Route::group(['namespace' => 'Admin'], function() {
            // Controllers Within The "App\Http\Controllers\Admin" Namespace

            Route::group(['prefix' => 'admin'], function () {

                Route::resource('event', 'EventController', [
                    "except" => ["edit", "show"],
                    'names' =>
                    [
                        'index' => 'adminIndexEvent',
                        'create' => 'adminCreateEvent',
                        'store' => 'adminStoreEvent',
                        'update' => 'adminUpdateEvent',
                        'destroy' => 'adminDeleteEvent'
                    ]
                        ]
                );

                Route::post('event/changeposition', [
                    "uses" => "EventController@changePosition",
                    "as" => "adminChangeEventPosition"
                ]);



            });
        });
    });
});
