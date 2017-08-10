<?php
/**
 * Created by PhpStorm.
 * User: DarkRadish
 * Date: 25/07/2017
 * Time: 15:46
 */

namespace Services;


class csrf
{
    public function getCsrf()
    {
        $csrf = false;

       // $token=$this->app->user()->getToken();
       // var_dump($_SESSION['token'],$_POST['token']);die();

        if (isset($_SESSION['token']) AND isset($_POST['token']) AND !empty($_SESSION['token']) AND !empty($_POST['token'])) {



            if ($_SESSION['token'] == $_POST['token']) {

                $csrf = true;

            }
        }

        return $csrf;
    }

}