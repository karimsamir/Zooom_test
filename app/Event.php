<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;

class Event extends Model {

    protected $table = "event";
    protected $fillable = [
        'country_id',
        'category_id',
        'title',
        'location',
        'longitude',
        'latitude',
        'zip',
        'description',
        'start_date',
        'end_date'
    ];

    public function country() {
        return $this->belongsTo('App\Country');
    }

    public function category() {
        return $this->belongsTo('App\Category');
    }

    public function getStartDateAttribute() {
        return Carbon::parse($this->attributes['start_date'])->format('d-m-Y');
    }

    public function getEndDateAttribute() {
        return Carbon::parse($this->attributes['end_date'])->format('d-m-Y');
    }
 
    /**
     * update event positions using transaction
     * @param $positions array with event_id and position
     */
    public function updatePositions($positions)
    {
        // run a Db transaction to update positions
        DB::transaction(function () use ($positions){

            foreach($positions as $position){

                DB::table($this->table)
                    ->where(["id" => $position["event_id"]])
                    ->update(['position' => $position["position"]]);

            }
        });
    }

}
