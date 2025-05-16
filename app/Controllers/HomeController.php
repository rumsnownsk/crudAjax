<?php

namespace App\Controllers;


use CrudAjax\Pagination;

class HomeController
{
    public function index()
    {
        $countCities =db()->getCount('city');
        $limit = PAGINATION_SETTINGS['perPage'];

        $pagination = new Pagination($countCities);
        $cities = db()->query("select * from city limit $limit offset {$pagination->getOffset()}")->get();
        return view('home', [
            'cities' => $cities,
            'countCities' => $countCities,
            'pagination' => $pagination
        ]);
    }

}