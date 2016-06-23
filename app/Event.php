<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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
        return Carbon::parse($this->attributes['start_date'])->format('Y-m-d');
    }

    public function getEndDateAttribute() {
        return Carbon::parse($this->attributes['end_date'])->format('Y-m-d');
    }

}
