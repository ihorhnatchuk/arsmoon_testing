<?php 
namespace App\Controllers;

use Core\Controller\Controller;

class HomeController extends Controller
{
    public function __invoke(array $params = [])
    {
       return $this->view->render('home', [
           'title' => 'Home'
       ]);
    }
}