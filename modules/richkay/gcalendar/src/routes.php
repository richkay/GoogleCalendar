<?php

Route::get('/holidays', 
  'richkay\gcalendar\controllers\HolidaysController@index');

Route::get('/listholiday', 
  'richkay\gcalendar\controllers\HolidaysController@getHoliday');