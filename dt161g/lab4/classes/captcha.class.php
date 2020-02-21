<?php

/*******************************************************************************
 * Laboration 4, Kurs: DT161G
 * File: captcha.class.php
 * Desc: Static Class Captcha, used to generate a random captcha.
 *
 * Henrik Henriksson
 * hehe0601
 * hehe0601@student.miun.se
 ******************************************************************************/


class Captcha
{
    private static $initiated = false; // used to see if there is an active instance of the class
    private static $captchaSeed; // the text to be used in the captcha.
    private static $len;

    // initializer function for static class.
    private static function init()
    {
        // as the function is static, it will only need to be constructed once.
        if (!self::$initiated) {
            self::$initiated = true;
            self::$captchaSeed = str_split('abcdefghijklmnopqrstuvwxyz'
                . 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
                . '0123456789');
            require __DIR__ . "/../util.php";
            // get the length from the config file:
            // self::$len = $config->getCaptchaLength();
            self::$len = $config->getCaptchaLength();
        }
    }

    // the main static function. Initiates self and returns a random string 
    public static function generateCaptcha()
    {

        Captcha::init(); // call the init function to set the seed once.
        $randomized = ""; // reset the variable.

        foreach (array_rand(self::$captchaSeed, self::$len) as $key) {
            $randomized .= self::$captchaSeed[$key];
        }
        return $randomized;
    }
}
