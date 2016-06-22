<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Country extends Model {

    protected $table = "country";

    public static function getAllCountries() {
        $allCountries = DB::table('country')->select('id', 'country_code')->get();

        $arrCountries = array();

        foreach ($allCountries as $key => $country) {
            $arrCountries[$country->id] = $country->country_code;
        }
        
        return $arrCountries;
    }

}
