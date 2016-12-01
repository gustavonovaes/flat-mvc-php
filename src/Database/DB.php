<?php

namespace App\Database;

class DB
{
    /** @var \PDO */
    private static $pdo;

    private function __construct()
    {
        //
    }

    final public static function __callStatic($name, $arguments)
    {
        return call_user_func_array([
            self::getInstance(),
            $name,
        ], $arguments);
    }

    public static function getInstance()
    {
        if (!self::$pdo) {
            throw new \RuntimeException('PDO was not defined. Use the method setPDO before call getInstance');
        }

        return self::$pdo;
    }

    static function setPDO(\PDO $pdo)
    {
        self::$pdo = $pdo;
    }

    public static function queryOne($sql, $params = [])
    {
        $row = self::queryRow($sql, $params);
        return current($row);
    }

    public static function queryRow($sql, $params = [], $fetch_style = \PDO::FETCH_ASSOC)
    {
        return self::prepare($sql, $params)
            ->fetch($fetch_style);
    }

    public static function queryColumn($sql, $params = [], $column_number = 0)
    {
        $stmt = self::prepare($sql, $params);

        $data = [];

        while ($column = $stmt->fetchColumn($column_number)) {
            $data[] = $column;
        }

        return $data;
    }

    public static function queryAll($sql, $params = [], $fetch_style = \PDO::FETCH_ASSOC)
    {
        return self::prepare($sql, $params)
            ->fetchAll($fetch_style);
    }

    /**
     * @param $sql
     * @param array $params
     * @return \PDOStatement
     */
    private static function prepare($sql, $params = [])
    {
        $pdo = self::getInstance();

        $stmt = $pdo->prepare($sql);

        foreach ($params as $key => $value) {
            $stmt->bindParam($key, $value);
        }

        $stmt->execute();

        return $stmt;
    }

    private function __clone()
    {
        //
    }
}