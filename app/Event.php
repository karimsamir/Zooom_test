<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
        'startdate',
        'enddate'
    ];

    public function country() {
        return $this->belongsTo('App\Country');
    }

    public function category() {
        return $this->belongsTo('App\Category');
    }

}
