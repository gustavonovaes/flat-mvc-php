<?php

namespace App\Models;

use App\Database\DB;

class People
{
    public static function all()
    {
        $sql = 'SELECT 
                  id,
                  firstname,
                  lastname,
                  address
                FROM people';

        return DB::queryAll($sql, [], \PDO::FETCH_OBJ);
    }

    public static function create(array $data)
    {
        $sql = 'INSERT INTO people (firstname, lastname, address) 
                VALUES (:firstname, :lastname, :address);';

        return DB::exec($sql, $data);
    }

    public static function get($id)
    {
        $sql = 'SELECT id, firstname, lastname, address
                FROM people
                WHERE id = :id';

        return DB::queryRow($sql, [
            'id' => $id
        ], \PDO::FETCH_OBJ);
    }

    public static function update(array $params)
    {
        $sql = 'UPDATE people SET
                  firstname = :firstname,
                  lastname = :lastname,
                  address = :address
                WHERE id = :id';

        return DB::exec($sql, $params);
    }
}