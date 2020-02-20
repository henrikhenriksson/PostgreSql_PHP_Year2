<?php

/*******************************************************************************
 * Laboration 4, Kurs: DT161G
 * File: guestbook.php
 * Desc: class post for Lab 3, handles an individual post to the guestbook.
 *
 * Henrik Henriksson
 * hehe0601
 * hehe0601@student.miun.se
 ******************************************************************************/
date_default_timezone_set('Europe/Stockholm');

class Post
{
    private $name = '';
    private $message = '';
    private $iplog = '';
    private $timelog = '';

    // consructor taking 2 or 4 values. When creating a new post, the constructor will assign ip and time manually. When fetching posts from database, these will already exist and be sent as input params.
    public function __construct(string $pName, string $pText, string $pIplog = null, string $pTimelog = null)
    {
        $this->name = trim($pName);
        $this->message = trim($pText);

        // if iplog ocr timelog parameters are !null, set the values (used for  posts loaded from database), else, set them manually for new posts.
        $pIplog ? $this->iplog = $pIplog : $this->iplog = $this->findIP();
        $pTimelog ? $this->timelog = $pTimelog : $this->timelog = date("Y-m-d H:i:s", time());
    }

    // as the databasehandler uses assoc arrays, this function returns the object as an array
    public function getPostArray()
    {
        return [
            'name' => $this->name,
            'message' => $this->message,
            'iplog' => $this->iplog,
            'timelog' => $this->timelog
        ];
    }

    // getters
    public function getName()
    {
        return $this->name;
    }
    public function getMessage()
    {
        return $this->message;
    }
    public function getIP()
    {
        return $this->iplog;
    }
    public function getTime()
    {
        return $this->timelog;
    }

    // this function checks for the users ip, trying to circumvent attempts to hide IP using vpn or other tools.
    private function findIP()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip_address = $_SERVER['HTTP_CLIENT_IP'];
        }
        //whether ip is from proxy
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        //whether ip is from remote address
        else {
            $ip_address = $_SERVER['REMOTE_ADDR'];
        }
        return $ip_address;
    }
}
