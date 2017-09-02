<?php

class Other
{
    //Обработка HTTP_REFERER для добавления пути к header
    public static function getUri($str, $count)
    {
        if (isset($str)) {
            $str = strval($str);
        } else {
            return false;
        }
        //Обработка HTTP_REFERER
        $array = explode('/', $str);
        if (isset($array) && is_array($array)) {
            for ($i = 0; $i <= $count; $i++) {
                unset($array[$i]);
            }
            $str = implode('/', $array);
            return $str;
        } else {
            return false;
        }


    }

}