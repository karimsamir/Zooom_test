To use the project

1)Make sure you have composer installed https://getcomposer.org/

2)Clone it or download it

3)Go to source project using command line

4)run $ composer install

5)run $ php artisan migrate:refresh (to create the database)

6)update database by countries and categories using sql in database/sql folder

7) to fill event table with fake data you can run this

$ php artisan db:seed --class=EventTableSeeder

Using the BE

1) go to /register to register

2) then go to /login to login

3) you should see all events 

FE

1) home page will show the map with events