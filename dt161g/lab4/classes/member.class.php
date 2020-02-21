<?php

/*******************************************************************************
 * Laboration 4, Kurs: DT161G
 * File: member.class.php
 * Desc: Class Member for laboration 4
 *
 * Henrik Henriksson
 * hehe0601
 * hehe0601@student.miun.se
 ******************************************************************************/


class Member
{
    private $id;
    private $userName;
    private $password;
    private $roles;


    public function __construct(int $pId, string $pUserName, string $pPassword)
    {
        $this->id = $pId;
        $this->userName = $pUserName;
        $this->password = $pPassword;
        $this->roles = [];
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * Get the value of userName
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * Get the value of password
     */
    public function getPassword()
    {
        return $this->password;
    }
    public function getMemberAsArray()
    {
        return [
            'id' => $this->id,
            'username' => $this->userName,
            'password' => $this->password
        ];
    }

    public function getRoleArray()
    {
        return $this->roles;
    }

    /**
     * Set the value of role
     *
     * @return  self
     */
    public function addRole(array $roles)
    {
        $this->roles = $roles;

        return $this;
    }
}
