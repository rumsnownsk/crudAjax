<?php

namespace App\Controllers;

use App\Models\City;
use CrudAjax\Pagination;
use JetBrains\PhpStorm\NoReturn;

class AjaxController extends BaseController
{

    public function __construct()
    {
//        $data = json_decode(file_get_contents('php://input'), true); dd($data);
//        echo json_encode([
//            'answer' => 'success',
//            'up' => 'public function updateCity',
//            'POST' => $data
//        ]);
    }
    public function index()
    {
        $data = request()->getData();

        if($data['page']){

            $countCities =db()->getCount('city');
            $limit = PAGINATION_SETTINGS['perPage'];

            $pagination = new Pagination($countCities);

            $page = (int)$data['page'] ?? 1;
            $pagination->setCurrentPage($page);

            $cities = db()->query("select * from city limit $limit offset {$pagination->getOffset()}")->get();

            echo json_encode([
                'countCities' => $countCities,
                'pagination' => $pagination->getHtml(),
                'table'=>$this->renderTable($cities)
            ]);
        }
        die;
    }

    public function addCity()
    {

        if (isset($_POST['addCity'])) {
            $city = new City();
            $city->loadData();
            if ($city->validate()) {

                db()->query("insert into city (`name`,`population`) values (?, ?)", [
                    $city->attributes['name'],
                    $city->attributes['population']
                ]);

                echo json_encode([
                    'answer' => 'success',
                    'message'=>'data is saved successfully!!!'
                ]);

            } else {
                echo json_encode([
                    'answer'=>'error',
                    'errors' => $city->listErrors()
                ]);
            };
            die;
        }
    }

    public function getCity(): void
    {
        $data = $_GET;

        if (isset($data['action']) && $data['action'] == 'getCity') {
            $id = isset($data['id']) ? (int)$data['id'] : 0;
            $city = db()->query("select * from city where `id` = ?", [$id])->getOne();
            if ($city) {
                echo json_encode([
                    'answer' => 'success',
                    'city' => $city
                ]);
            } else {
                echo json_encode([
                    'answer' => 'error'
                ]);
            }
            die;
        }

        if (isset($_POST['editCity'])) {
            $city = new City();
            $city->loadData();
            if ($city->validate()) {
                db()->query("UPDATE city
                                    SET `name` = ?, `population` = ?
                                    WHERE `id` = ?", [
                    $city->attributes['name'],
                    $city->attributes['population']
                ]);

                echo json_encode([
                    'answer' => 'success',
                    'city' => $city
                ]);
            } else {
                echo json_encode([
                    'answer'=>'error',
                    'errors' => $city->listErrors()
                ]);
            };
            die;
        }
    }


    public function updateCity(): void
    {
        $data = json_decode(file_get_contents('php://input'), true);
        echo json_encode([
            'answer' => 'success',
            'message' => 'ответ с сервера, из метода updateCity',
            'POST' => $_POST
        ]);

            die;
    }

    public function deleteCity(): void
    {
        $data = request()->getData();

        if (isset($data['action']) && $data['action'] == 'deleteCity') {
            $id = isset($data['id']) ? (int)$data['id'] : 0;
            $res = db()->query("delete from city where `id` = ?", [$data['id']]);
            if ($res) {
                echo json_encode([
                    'answer' => 'success',
                ]);
            } else {
                echo json_encode([
                    'answer' => 'error',
                ]);
            }
            die();
        }
    }


}

