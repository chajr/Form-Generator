<?php
class Validator_Password{
    static $passwordToCheck = 'somePassword';
    static function check ($pass)
    {
        if (md5($pass) === md5(self::$passwordToCheck)) {
            return TRUE;
        }
        return FALSE;
    }
}