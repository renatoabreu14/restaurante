<?php


namespace controller;


class Conexao{

    private static $instance;

    /**
     * Conexao constructor.
     * @param $teste
     */
    private function __construct(){

    }

    public static function getInstance(){
        if (self::$instance == null){
            self::$instance = new \PDO("mysql:host=localhost;dbname=pw2_2020",
                "phpmyadmin", "123456");
            self::$instance->setAttribute(\PDO::ATTR_ERRMODE,
                \PDO::ERRMODE_EXCEPTION);
        }
        return self::$instance;
    }


}
