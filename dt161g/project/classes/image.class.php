<?php

/*******************************************************************************
 * Projekt, Kurs: DT161G
 * File: image.class.php
 * Desc: Class Image for Projekt
 *
 * Henrik Henriksson
 * hehe0601
 * hehe0601@student.miun.se
 ******************************************************************************/


class Image
{
    private $id;
    private $imgName;
    private $categoryId;

    public function __construct(int $pId, string $pImgName, int $pCategoryId)
    {
        $this->id = $pId;
        $this->imgName = $pImgName;
        $this->categoryId = $pCategoryId;
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of img_name
     */
    public function getImgName()
    {
        return $this->imgName;
    }

    /**
     * Get the value of category_id
     */
    public function getCategory_id()
    {
        return $this->categoryId;
    }
}
