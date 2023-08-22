<?php

namespace GrowBitTech\Framework;

class DTO
{
    public static function forArray(array $array)
    {
        $class = get_called_class();
        $object = new $class();
        foreach ($array as $key => $value) {
            $object->$key = $value;
        }

        return $object;
    }
}
