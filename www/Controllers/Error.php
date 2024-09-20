<?php
namespace App\Controllers;

use App\Core\View;

class Error
{
    public function page404(): void
    {

        $myView = new View("Errors/404", "front");
    }
}