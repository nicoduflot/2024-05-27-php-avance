<?php

namespace Utils;

class Tools{
    static $pi = 3.1415926535898;

    public static function circo($rayon) : float {
        return 2 * self::$pi * $rayon;
    }

    public static function prePrint($data){
        echo '<pre>'.var_dump($data).'</pre>';
    }
}