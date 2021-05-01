<?php


class Flash
{

    public static function putMessage($name, $message){
        return $_SESSION[$name] = $message;
    }

    public static function exists($name){
        return (isset($_SESSION[$name])) ? true : false;
    }

    public static function delete($name){
        if(self::exists($name)){
            unset($_SESSION[$name]);
        }
    }

    private static function getMessage($name){
        return $_SESSION[$name];    }


    public static function showMessage($name){
        if(self::exists($name) && self::getMessage($name) !==''){
            $session = self::getMessage($name);
            self::delete($name);
            return $session;
        }

    }




}