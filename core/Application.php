<?php

namespace CrudAjax;

use CrudAjax\DataBase;
//use CrudAjax\Pa;

class Application
{
    protected string $uri;

    public Request $request;
    public Response $response;

    public Router $router;
    public View $view;
    public DataBase $db;

    public static Application $app;

    public function __construct()
    {
        self::$app=$this;

        $this->uri = $_SERVER['REQUEST_URI'];

        $this->request = new Request($this->uri);
        $this->response = new Response();
        $this->view = new View(LAYOUT);

        $this->router = new Router($this->request, $this->response);
        $this->db = new Database();

    }

    public function run(): void
    {
        echo $this->router->dispatch();
    }

}