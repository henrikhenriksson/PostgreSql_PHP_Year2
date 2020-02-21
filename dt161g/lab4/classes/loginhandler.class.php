<?php

/*******************************************************************************
 * Laboration 4, Kurs: DT161G
 * File: login.php
 * Desc: Login page for laboration 2
 *
 * Henrik Henriksson
 * hehe0601
 * hehe0601@student.miun.se
 ******************************************************************************/


class LoginHandler
{
    private $responseText;
    private $validUser;
    private $validPassword;
    private $databaseUsers;
    private $linkArray;

    private $gotName;
    private $gotPassword;
    private $userArray;
    private $roleArray;

    public function __construct(string $pGotName, string $pGotPassword)
    {
        $this->responseText = [];
        $this->responseText['valid'] = false;
        $this->validUser = false;
        $this->validPassword = false;
        $this->linkArray = [
            "Hem" => "index.php"
        ];

        $this->gotName = $pGotName;
        $this->gotPassword = $pGotPassword;

        require('util.php');
        $userArray[] = dbHandler::getInstance()->getMembersFromDataBase();
        $roleArray[] = dbHandler::getInstance()->getRolesFromDatabase();
    }

    public function validateUser()
    {

        setLinkArray();
    }

    private function setLinkArray()
    {
        echo "hej";
    }


    public function sendReply()
    {
        // send the reply.
        header('Content-Type: application/json');
        echo json_encode($this->responseText);
    }
}
