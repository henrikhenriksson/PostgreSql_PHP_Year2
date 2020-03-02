<?php

/*******************************************************************************
 * Project, Kurs: DT161G
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

    private $linkArray;
    private $validUser;
    private $validPassword;
    private $gotName;
    private $gotPassword;
    private $userArray;
    private $currentUser;

    public function __construct(string $pGotName, string $pGotPassword)
    {
        $this->validUser = false;
        $this->validPassword = false;
        $this->responseText = [];
        $this->responseText['valid'] = false;
        $this->linkArray = [
            "Hem" => "index.php"
        ];

        $this->gotName = $pGotName;
        $this->gotPassword = $pGotPassword;

        $this->userArray = dbHandler::getInstance()->getMembersFromDataBase();
        $this->currentUser = $this->getUser();
    }



    private function getUser()
    {
        foreach ($this->userArray as $key) {
            if ($this->gotName === $key->getUserName()) {
                $this->validUser = true;
                return $key;
            }
        }
        return null;
    }

    public function validatePassword()
    {
        if ($this->currentUser != null) {
            if ($this->currentUser->getPassword() === $this->gotPassword) {
                $this->validPassword = true;
                return true;
            } else {
                $this->validPassword = false;
                return false;
            }
        } else {
            return false;
        }
    }

    public function getisAdmin()
    {
        foreach ($this->currentUser->getRoleArray() as $key) {
            if ($key->getRole() === "admin") {
                return true;
            }
        }
        return false;
    }

    public function setLinkArray()
    {
        foreach ($this->currentUser->getRoleArray() as $key) {
            if ($key->getRole() === "member") {
                $this->linkArray = array_merge($this->linkArray, config::getInstance()->getMemberLinks());
            }
            if ($key->getRole() === "admin") {
                $this->linkArray = array_merge($this->linkArray, config::getInstance()->getAdminLinks());
            }
        }
        return $this->linkArray;
    }

    public function setResponseText()
    {
        if ($this->validUser && $this->validPassword) {
            $this->responseText['msg'] = "Welcome valid user {$this->gotName}.";
            $this->responseText['links'] = $this->linkArray;
            $this->responseText['valid'] = true;
        } else if (!$this->validUser) {
            $this->responseText['msg'] = "Your are not an authorized user!";
        } else if ($this->validUser && !$this->validPassword) {
            $this->responseText['msg'] = "Incorrect Password!";
        }
        return $this->responseText;
    }


    public function sendReply()
    {
        // send the reply.
        header('Content-Type: application/json');
        echo json_encode($this->responseText);
    }

    /**
     * Get the value of userArray
     */
    public function getUserArray()
    {
        return $this->userArray;
    }
}
