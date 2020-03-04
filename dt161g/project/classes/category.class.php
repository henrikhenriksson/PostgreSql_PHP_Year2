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

class Category
{

    private $id;
    private $categoryname;
    private $memberid;
    private $images;


    public function __construct(int $pId, string $pCategoryName, int $memberId)
    {
        $this->id = $pId;
        $this->categoryname = $pCategoryName;
        $this->memberid = $memberId;
        $this->images = [];
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of categoryname
     */
    public function getCategoryName()
    {
        return $this->categoryname;
    }

    /**
     * Get the value of memberid
     */
    public function getMemberid()
    {
        return $this->memberid;
    }

    /**
     * Get the value of images
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Set the value of images
     *
     * @return  self
     */
    public function setImages(array $images)
    {
        $this->images = $images;

        return $this;
    }
}
