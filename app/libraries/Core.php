<?php

/**
 * App Core class
 * create URL and loads core controller
 * URL format: /controller/method/parameters
 */

class Core
{
    protected $currentController = "Pages";
    protected $currentMethod = "index";
    protected $params = [];

    public function __construct()
    {
        //print_r($this->getUrl());

        //Look for first controller
        $url = $this->getUrl();
        if (file_exists('../app/controllers/' . ucwords($url[0]) . '.php')) {

            //If file exist set it as current controller
            $this->currentController = ucwords($url[0]);

            //unset 0 Index
            unset($url[0]);
        }

        //Require the controller

        require_once "../app/controllers/" . $this->currentController . '.php';

        //Instantiate controller class
        $this->currentController = new $this->currentController;

        //Check for second part of URL
        if (isset($url[1])) {
            //check to see method exist in controller
            if (method_exists($this->currentController, $url[1])) {
                $this->currentMethod = $url[1];
                //Unset 1 index
                unset($url[1]);
            }
        }

        //Get parameters
        $this->params = $url ? array_values($url) : [];

        //call a callback with array parameters
        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }

    public function getUrl()
    {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
    }
}
