<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Category extends Model {

    protected $table = "category";

    public function event() {
        return $this->hasMany('App\Event');
    }

    public static function getAllCategories() {
        $allCategories = DB::table('category')->select('id', 'category_name')->get();

        $categories = array();

        foreach ($allCategories as $key => $category) {
            $categories[$category->id] = $category->category_name;
        }

        return $categories;
    }

}
