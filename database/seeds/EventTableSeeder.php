<?php

use Illuminate\Database\Seeder;
//use Faker\Factory;
use App\Event;
use App\Country;

class EventTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $limit = 20;

        $allCountries = DB::table('country')->select('id', 'country_code')->get();
        
        $arrCountries = array();

            foreach ($allCountries as $key => $country){
                $arrCountries[$country->country_code] = $country->id;
            }
            
            
        for ($i = 0; $i < $limit; $i++) {
            
            $start_date = $faker->dateTime;
            $end_date = $faker->dateTimeBetween($start_date);
            $country_id = 1;
            
            if (array_key_exists($faker->countryCode, $arrCountries)) {
                $country_id =   $arrCountries[$faker->countryCode];
            }
            else{
                $country_id =   rand(1, 246);
            }
            
            $event = array(
                "title" => $faker->name,
                "location" => $faker->address,
                "longitude" => $faker->longitude,
                "latitude" => $faker->latitude,
                "zip" => $faker->postcode,
                "description" => $faker->text,
                "start_date" => $start_date,
                "end_date" => $end_date,
                "country_id" =>   $country_id,
                "category_id" => rand(1, 3)    
                
            );
            
//            die(var_dump($event));
            Event::create($event);
        }
    }
}
