<?php

/*******************************************************************************
 * Project Assignment, Kurs: DT161G
 * File: login.php
 * Desc: FileHandler class file for dt161g Project Assignment
 *
 * Henrik Henriksson
 * hehe0601
 * hehe0601@student.miun.se
 ******************************************************************************/
date_default_timezone_set('Europe/Stockholm');

/** This class is responsible for handling file operations such as saving to file and loading from file. */
class FileHandler
{
    private static $instance = null;
    private $responseText;
    private $validUpload;
    private $validFileTypes;
    private $targetDir;
    private $fileSize;
    //-------------------------------------------------------------------------
    /** Private constructor setting initial member variable values. */
    private function __construct()
    {
        // require __DIR__ . "/../config.php";
        $this->responseText = [];
        $this->validFileTypes = Config::getInstance()->getFileTypes();
        $this->targetDir = Config::getInstance()->getTargetDir();
        $this->fileSize = Config::getInstance()->getFileSize();
    }
    //-------------------------------------------------------------------------
    /**
     * Fetch the current instance of the class. If no instance is currently running the constructor is called to initiate.
     * @return self::$instance;
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new FileHandler();
        }
        return self::$instance;
    }
    //-------------------------------------------------------------------------
    /**
     * This fucntion is responsible for creating a new category folder if it does not already exists. The check is reduntand in the current implementation. But makes the class modular.
     * @param $memberName the name of the member.
     * @param $categoryName, the name of the catogory folder to create.
     */
    public function createCategoryFolder($memberName, $categoryName)
    {
        $dirToCreate = "{$this->targetDir}/{$memberName}/{$categoryName}";
        if ($this->validateTargetFolder($dirToCreate)) {
            mkdir($dirToCreate, true);
        }
    }
    /**
     * Remove category folder
     */
    public function removeCategoryFolder($memberName, $categoryName)
    {
        $dirToRemove = "{$this->targetDir}/{$memberName}/{$categoryName}";
        if (!$this->validateTargetFolder($dirToRemove)) {
            array_map('unlink', glob("$dirToRemove/*.*"));
            rmdir($dirToRemove);
        }
    }

    //-------------------------------------------------------------------------
    /**
     * This function is responsible for creating a new folder for the user, if one does not already exist.
     */
    public function createUserFolder($userName)
    {
        $dirToCreate = "{$this->targetDir}/{$userName}";
        if ($this->validateTargetFolder($dirToCreate)) {
            mkdir($dirToCreate, true);
        }
    }
    //-------------------------------------------------------------------------
    /**
     * This function is responsible for removing a user folder from the server if an admin removes the user from the database
     */
    public function deleteUserFolder($userName)
    {
        $dirToRemove = "{$this->targetDir}/{$userName}";
        $this->RecursiveRemove($dirToRemove);
    }
    //-------------------------------------------------------------------------
    /**
     * This function is responsible for recursively removing any subfolders of the user folder, as well as deleting the user folder itself.
     */
    private function RecursiveRemove($dirToRemove)
    {
        if (is_dir($dirToRemove)) {
            $objects = scandir($dirToRemove);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (filetype($dirToRemove . "/" . $object) == "dir")
                        $this->RecursiveRemove($dirToRemove . "/" . $object);
                    else unlink($dirToRemove . "/" . $object);
                }
            }
            reset($objects);
            rmdir($dirToRemove);
        }
    }
    //-------------------------------------------------------------------------
    /**
     * This function is responsible for validating a file the user is attempting to upload, and if all checks pass - upload the file to the server.
     * @param $currentUser, the current user attempting to upload an image
     * @param $category, the category the images adheres to
     * @param $FILES, the entire $_FILES suberglobal.
     */
    public function validateAndUpload($currentUser, $category, $FILES)
    {
        $this->responseText['msg'] = "test";
        $this->validUpload = false;
        if ($_FILES['file']['error'] !== 0) {
            $this->responseText['msg'] = "Something went wrong when uploading your file to the server. File Size is probably to large.";
        } else {

            $currentCategoryId = "";

            foreach ($currentUser->getCategories() as $key) {
                if ($category === $key->getCategoryName()) {
                    $currentCategoryId = $key->getId();
                }
            }

            $targetFile = "{$this->targetDir}/{$currentUser->getUserName()}/{$category}/" . basename($FILES["file"]["name"]);
            $imgExt = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

            // Check in turn for valid image type, duplicates, filesize and img extension. If all returns rue, ValidUpload is set to true.
            if (self::isNotLarge($FILES)) {
                if (self::isNotDupe($targetFile)) {
                    if (self::isImage($FILES)) {
                        if (self::isValidFileType($imgExt)) {
                            $this->validUpload = true;
                        } else {
                            $this->responseText['msg'] = "Invalid Filetype. Files should only end with gif, jpeg, jpg or png";
                        }
                    } else {
                        $this->responseText['msg'] = "The file you tried to upload is not an image. File could not be uploaded.";
                    }
                } else {
                    $this->responseText['msg'] = "This file already exists on the database. Image could not be uploaded.";
                }
            } else {
                $this->responseText['msg'] = "File Size is too large. Image could not be uploaded";
            }
            if ($this->validUpload) {
                $dateTime = "";
                // Anonymous function used to swallow warning message about unsupported file formats or if a valid file format is saved without meta data.
                set_error_handler(function ($errno, $errstr) {
                    global $dateTime;
                    $dateTime = date("Y-m-d H:i:s", 946681200);
                });
                $exif = exif_read_data($FILES["file"]["tmp_name"]);
                restore_error_handler();

                if (isset($exif['DateTime'])) {
                    // fetch the DateTime variable
                    $dateTime = $exif['DateTime'];
                } else {
                    $dateTime = date("Y-m-d H:i:s", 946681200);
                }

                // If the validUpload is true, attempt to upload the image to the server and database.

                if (move_uploaded_file($FILES["file"]["tmp_name"], $targetFile)) {
                    dbHandler::getInstance()->addNewImage(basename($FILES["file"]["name"]), $dateTime, $currentCategoryId);
                    $this->responseText['msg'] = "The file " . basename($FILES["file"]["name"]) . " has been uploaded.";
                } else {
                    $this->responseText['msg'] =  "Sorry, there was an error that was probably not your fault uploading your file.";
                }
            }
        }
    }
    //-------------------------------------------------------------------------
    /**
     * Check if the file is an image. Returns true if the file has an image size value.
     * @param $FILES, $_FILES suberglobal as an input variable.
     * @return boolean
     */
    private function isImage(array $FILES)
    {
        if (getimagesize($FILES['file']['tmp_name'])) {
            return true;
        } else {
            return false;
        }
    }
    //-------------------------------------------------------------------------
    /**
     * This function checks if the current file already exists on the server. Returns true if the file is not a dublicate
     * @param $targetFile, the path of the image.
     * @return boolean
     */
    private function isNotDupe($targetFile)
    {
        if (!file_exists($targetFile)) {
            return true;
        } else {
            return false;
        }
    }
    //-------------------------------------------------------------------------
    /**
     * Check the file size to make sure it does not exceed the max limit.
     * @param $FILES, the suberglobal $_FILES parameter
     * @return boolean
     */
    private function isNotLarge($FILES)
    {
        if ($_FILES['file']['size'] <= 2000000) {
            return true;
        } else {
            return false;
        }
    }
    //-------------------------------------------------------------------------
    /**
     * Check if the file has a valid extension
     * @return boolean
     */
    private function isValidFileType($extension)
    {
        if (in_array($extension, $this->validFileTypes)) {
            return true;
        } else {
            return false;
        }
    }
    //-------------------------------------------------------------------------
    /**
     * Check whether or not a folder already exists in the target directory. Returns true if the folder does not exist.
     * @param $targetDir, the directory to check
     * @return boolean
     */
    private function validateTargetFolder($targetDir)
    {
        if (!file_exists($targetDir)) {
            return true;
        } else {
            return false;
        }
    }
    //-------------------------------------------------------------------------
    /** 
     * This function is responsible for sending the AJAX reply.
     */
    public function sendReply()
    {
        // send the reply.
        header('Content-Type: application/json');
        echo json_encode($this->responseText);
    }
}
//---------------------------------------------------------------------------
