<?php

/*******************************************************************************
 * Projekt, Kurs: DT161G
 * File: includeImageForm.php
 * Desc: inclusion file for image upload form
 *
 * Henrik Henriksson 
 * hehe0601
 * hehe0601@student.miun.se
 ******************************************************************************/
require('util.php');


if (isset($_FILES['file'])) {
    session_start();
    $filehandler = FileHandler::getInstance();

    $currentUser = $_SESSION['validLogin'];
    $category = $_POST['category'];
    $filehandler->validateAndUpload($currentUser, $category, $_FILES);
}
$filehandler->sendReply();


// $responseText = [];
// //$target_dir = __DIR__ . "/../../writeable/test/";
// $validUpload = true;

// $validFileTypes = [
//     "gif", "jpeg", "jpg", "png"
// ];

// // check for valid upload:
// if (isset($_FILES['file'])) {
//     session_start();
//     if (isset($_SESSION['validLogin'])) {
//         $currentUser = $_SESSION['validLogin'];
//         $target_dir = __DIR__ . "/../../writeable/test/{$currentUser}/{$_POST['category']}/";
//     }

//     if (file_exists($target_dir)) {
//     } else {
//         mkdir($target_dir, 0777, true);
//     }

//     $target_file = $target_dir . basename($_FILES["file"]["name"]);
//     $imgFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
//     $checkValid = getimagesize($_FILES['file']["tmp_name"]);
//     if (!$checkValid) {
//         $validUpload = false;
//         $responseText['msg'] = "The file you tried to upload is not an image. File could not be uploaded.";
//     }
//     // check if the file exists
//     if (file_exists($target_file)) {
//         $validUpload = false;
//         $responseText['msg'] = "This file already exists on the database. Image could not be uploaded.";
//     }

//     // Check for maximum filesize
//     if ($_FILES["file"]["size"] > 5000000) {
//         $validUpload = false;
//         $responseText['msg'] = "File Size is too large. Image could not be uploaded";
//     }

//     // check for a valid filetype:
//     $validFileType = false;
//     foreach ($validFileTypes as $key) {
//         if ($imgFileType == $key) {
//             $validFileType = true;
//         }
//     }
//     if (!$validFileType) {
//         $validUpload = false;
//         $responseText['msg'] = "Invalid Filetype. Files should only end with gif, jpeg, jpg or png";
//     }
// }

// // attempt to upload the file if all checks were passed.
// if ($validUpload) {
//     if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
//         $responseText['msg'] = "The file " . basename($_FILES["file"]["name"]) . " has been uploaded.";
//     } else {
//         $responseText['msg'] =  "Sorry, there was an error that was probably not your fault uploading your file.";
//     }
// }
// header('Content-Type: application/json');
// echo json_encode($responseText);
