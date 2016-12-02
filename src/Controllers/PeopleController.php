<?php

namespace App\Controllers;

use App\Models\People;

class PeopleController
{
    public static function show()
    {
        $people = People::all();

        view('people', ['people' => $people]);
    }

    public static function store()
    {
        $people_id = People::create($_REQUEST);

        json(['id' => $people_id], 201);
    }

    public static function update()
    {
        $people = People::get($_REQUEST['id']);

        if (!$people) {
            json(['message' => 'Not found'], 404);
        }

        $params = filter($_REQUEST, ['id', 'firstname', 'lastname', 'address']);

        People::update($params);

        json(['id' => $people->id], 200);
    }

    public static function delete()
    {
        $people = People::get($_REQUEST['id']);

        if (!$people) {
            json(['message' => 'Not found'], 404);
        }

        People::delete($_REQUEST['id']);

        json([], 200);
    }
}