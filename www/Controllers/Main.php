<?php
namespace App\Controllers;
use App\Core\View;

class Main
{
    public function home(): void
    {
       $myView = new View("Main/home", "front");
    }


    public function artist(): void
    {
        $myView = new View("Main/artist", "front");
    }

    
    public function events(): void
    {
        $myView = new View("Main/events", "front");
    }

    public function articles(): void
    {
        $myView = new View("Main/articles", "front");
    }
}