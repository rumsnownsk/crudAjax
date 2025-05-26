<?php

namespace App\Controllers;

class BaseController
{
    public function renderTable($cities): string
    {
        return view()->renderPartial('incs/table-content', [
            'cities' => $cities,
        ]);
    }

}