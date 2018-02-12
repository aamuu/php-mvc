<?php

/**
 * Base Controller
 * Loads models and views
 */
class Controller
{
    //Load Model
    public function model($model)
    {
        require_once '../app/models' . $model . '.php';

        //Instantiate model
        return new $model();
    }

    //Load View
    public function view($view, $data = [])
    {
        //check for the view file
        if (file_exists('../app/views/' . $view . '.php')) {
            require_once '../app/views/' . $view . '.php';
        } else {
            //View does not exist
            die('view does not exist');
        }
    }
}