<?php

/*******************************************************************************
 * Laboration 3, Kurs: DT161G
 * File: captcha.class.php
 * Desc: Static Class Captcha, used to generate a random captcha.
 *
 * Henrik Henriksson
 * hehe0601
 * hehe0601@student.miun.se
 ******************************************************************************/


class Captcha
{
    private static $initiated = false;
    private static $captchaSeed;

    private static function init()
    {
        // as the function is static, it will only need to be constructed once.
        if (!self::$initiated) {
            self::$initiated = true;
            self::$captchaSeed = str_split('abcdefghijklmnopqrstuvwxyz'
                . 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
                . '0123456789');
        }
    }

    public static function generateCaptcha(int $lenght)
    {
        Captcha::init(); // call the init function to set the seed once.
        $randomized = ""; // reset the variable.

        foreach (array_rand(self::$captchaSeed, $lenght) as $key) {
            $randomized .= self::$captchaSeed[$key];
        }
        return $randomized;
    }
}
