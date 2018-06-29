<?php


namespace App\Components\Helpers;

/**
 * Class DbHelper
 * @package App\Helpers
 */
class DbHelper
{
    /**
     * @param array $inValues
     * @return array
     */
    public static function getBindValues(array $inValues)
    {
        return array_combine(
            array_map(function ($key) {
                return ':var_' . $key;
            }, array_keys($inValues)),
            array_values($inValues)
        );
    }

    /**
     * @param array $preparedInValues
     * @return array
     */
    public static function getBindKeys(array $preparedInValues)
    {
        return implode(', ', array_keys($preparedInValues));

    }
}