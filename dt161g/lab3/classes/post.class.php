<?php

/*******************************************************************************
 * Laboration 3, Kurs: DT161G
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

    public function __construct(string $pName, string $pText, string $pIplog = null, string $pTimelog = null)
    {
        $this->name = trim($pName);
        $this->message = trim($pText);

        $pIplog ? $this->iplog = $pIplog : $this->iplog = $this->findIP();
        $pTimelog ? $this->timelog = $pTimelog : $this->timelog = date("Y-m-d H:i:s", time());
    }

    public function getPostArray()
    {
        return [
            'name' => $this->name,
            'message' => $this->message,
            'iplog' => $this->iplog,
            'timelog' => $this->timelog
        ];
    }

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
