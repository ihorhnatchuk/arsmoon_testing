<?php 
namespace App\Controllers;

class HomeController
{
    public function __invoke()
    {
       require_once dirname(dirname( __DIR__)) .'/resources/views/home.php';
    }
}