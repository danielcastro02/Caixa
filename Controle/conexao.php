<?php

class conexao
{

    private static $con;

    public static function getConexao(): PDO
    {
        if (is_null(self::$con)) {
            try {
                self::$con = new PDO('mysql:host=localhost;dbname=caixa', 'caixa', 'Class.7ufo', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            } catch (Exception $e) {
                self::$con = new PDO('mysql:host=localhost;dbname=caixa', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            }
        }
        return self::$con;
    }

    public static function getTransactConnetion(): PDO
    {
        try {
            return new PDO('mysql:host=localhost;dbname=caixa', 'caixa', 'Class.7ufo', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        } catch (Exception $e) {
            return new PDO('mysql:host=localhost;dbname=caixa', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        }
    }

}

