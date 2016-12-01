<?php

namespace App\Controllers;

use App\Models\People;

class PeopleController {

    public static function show() {

        $people = People::all();

        view('people', ['people' => $people]);
    }
}