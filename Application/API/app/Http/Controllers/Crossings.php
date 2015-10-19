<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Crossings extends BaseController
{
    public function getAllCrossings()
    {
        return json_encode( [], JSON_FORCE_OBJECT );
    }
}
