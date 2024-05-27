<?php

namespace Utils;

class Tools{
    static $pi = 3.1415926535898;
    /**
     * @param float rayon
     * @return float
     *  */    
    public static function circo($rayon) : float {
        return 2 * self::$pi * $rayon;
    }

    /**
     * @param any data
     */
    public static function prePrint($data){
        echo '<pre>'.var_dump($data).'</pre>';
    }

    /**
     * @param string page
     */
    public static function classActive($page){
        if(basename ($_SERVER['PHP_SELF']) === $page){
            echo 'active';
        }
    }
}