<?php

namespace App\Models;

use App\Database\DB;

class People
{
    public static function all()
    {
        $sql = "SELECT 
                  id,
                  firstname,
                  lastname,
                  address
                FROM app.people";

        return DB::queryAll($sql, [], \PDO::FETCH_OBJ);
    }
}