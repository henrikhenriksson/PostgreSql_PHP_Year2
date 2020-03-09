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

/**
 * This class is responsible for handling login requests sent by a user.
 */
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

    /**
     * Public constructor setting initial variable values 
     * @param $pGotName, the name sent to the login.php page by the $_GET subglobal
     * @param $pGotPassword, the password sent to the login.php page by the $_GET subglobal
     */
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


    /**
     * Get the current user if the user exists in the userArray.
     * @return $key, the member object if found in the array
     * @return $null, if no member was found.
     */
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
    /**
     * Get the value of the current user
     * @return $currentUser, member class object
     */
    public function getCurrentUser()
    {
        return $this->currentUser;
    }
    /**
     * Get the value of userArray
     * @return $this->userArray
     */
    public function getUserArray()
    {
        return $this->userArray;
    }

    /**
     * Validate the password the user has entered
     * @return boolean
     */
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
    /**
     * Perform a check if the current user is an admin.
     * @return boolean
     */
    public function getisAdmin()
    {
        foreach ($this->currentUser->getRoleArray() as $key) {
            if ($key->getRole() === "admin") {
                return true;
            }
        }
        return false;
    }

    /**
     * Set the linkarray used to display links on the aside part of the application. Checks member roles and adds links accordingly.
     */
    public function setLinkArray()
    {
        // $linkArray = [];
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

    /** 
     * Set the AJAX response message depending on the validation of the user credentials.
     */
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

    /**
     * This function is responsible for sending the AJAX response.
     */
    public function sendReply()
    {
        // send the reply.
        header('Content-Type: application/json');
        echo json_encode($this->responseText);
    }
}
