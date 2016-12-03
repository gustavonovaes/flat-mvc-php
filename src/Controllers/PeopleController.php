<?php

namespace App\Controllers;

use App\Models\People;
use App\Validate;

class PeopleController
{
    public static function show()
    {
        $people = People::all();

        view('people', ['people' => $people]);
    }

    public static function store()
    {
        $params = filter($_REQUEST, ['firstname', 'lastname', 'address']);

        Validate::check($params, [
            'firstname' => 'min:4|max:255|string_common',
            'lastname' => 'min:4|max:255|string_common',
            'address' => 'min:4|max:255|string_common',
        ]);

        $people_id = People::create($params);

        json(['id' => $people_id], 201);
    }

    public static function update()
    {
        $params = filter($_REQUEST, ['id', 'firstname', 'lastname', 'address']);

        Validate::check($params, [
            'id' => 'numeric',
            'firstname' => 'min:4|max:255|string_common',
            'lastname' => 'min:4|max:255|string_common',
            'address' => 'min:4|max:255|string_common',
        ]);

        $people = People::get($params['id']);

        if (!$people) {
            json(['message' => 'Not found'], 404);
        }

        People::update($params);

        json(['id' => $people->id], 200);
    }

    public static function delete()
    {
        $id = (int) $_REQUEST['id'];

        $people = People::get($id);

        if (!$people) {
            json(['message' => 'Not found'], 404);
        }

        People::delete($_REQUEST['id']);

        json([], 200);
    }
}