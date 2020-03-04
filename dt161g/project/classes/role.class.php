<?php

/*******************************************************************************
 * Projekt, Kurs: DT161G
 * File: role.class.php
 * Desc: Class Role for laboration 4
 *
 * Henrik Henriksson
 * hehe0601
 * hehe0601@student.miun.se
 ******************************************************************************/


class Role
{
    private $id;
    private $role;
    private $roleText;

    public function __construct(int $pId, string $pRole, string $pRoleText)
    {
        $this->id = $pId;
        $this->role = $pRole;
        $this->roleText = $pRoleText;
    }

    /**
     * Get the value of role
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Get the value of roleText
     */
    public function getRoleText()
    {
        return $this->roleText;
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }
}
