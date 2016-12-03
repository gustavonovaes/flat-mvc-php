<?php

namespace App;

use App\Exceptions\ValidationException;

class Validate
{

    public static function check(array $input, array $data)
    {
        foreach ($data as $input_key => $rule_str) {

            $rules = explode('|', $rule_str);

            self::checkRules($rules, trim($input[$input_key]));
        }

        return true;
    }

    private static function checkRules($rules, $value)
    {
        foreach ($rules as $rule_param) {

            list($rule, $param) = explode(':', $rule_param . ':');

            if (!method_exists(self::class, $rule)) {
                throw new \RuntimeException('Invalid rule');
            }

            if (!self::$rule($value, $param)) {
                throw new ValidationException("'{$value}' not is a valid '{$rule_param}'");
            }
        }
    }

    private static function numeric($value)
    {
        return is_numeric($value);
    }

    private static function max($value, $max)
    {
        return mb_strlen($value) <= $max;
    }

    private static function min($value, $min)
    {
        return mb_strlen($value) >= $min;
    }

    private static function string_common($value)
    {
        return self::regex($value, '#^[\p{L}0-9 _,.\'-]+$#iu');
    }

    private static function regex($value, $regex)
    {
        return (bool)preg_match($regex, $value);
    }
}