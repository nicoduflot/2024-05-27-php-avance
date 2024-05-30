<?php

namespace Utils;
use PDO;
use Exception;

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

    public static function setBdd($host, $dbname, $user = 'root', $psw = ''){
        try{
            $bdd = new PDO('mysql:host='.$host.';dbname='.$dbname.';charset=UTF8', $user, $psw, array(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION));
        }
        catch(Exception $e){
            die('Erreur de connexion : '. $e->getMessage());
        };
        return $bdd;
    }

    public static function querySelect($bdd, $sql, $params = []){
        $request = $bdd->prepare($sql);
        $request->execute($params);
        return $request;
    }
    
    public static function queryInsert($bdd, $sql, $params){
        $request = $bdd->prepare($sql);
        $request->execute($params);
        $id = $bdd->lastInsertId();
        $request->closeCursor();
        return $id;
    }
}