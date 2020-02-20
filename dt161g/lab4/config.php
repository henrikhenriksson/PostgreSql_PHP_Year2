<?PHP

/*******************************************************************************
 * Laboration 4, Kurs: DT161G
 * File: config.php
 * Desc: Config file for Laboration 4
 *
 * Henrik Henriksson
 * hehe0601
 * hehe0601@student.miun.se
 ******************************************************************************/

// settings can be changed here:
$confSettings = [
    'host' => "studentpsql.miun.se",
    'port' => "5432",
    'dbName' => "hehe0601",
    'user' => "hehe0601",
    'pass' => "b0cZeRKbe",
    'debug' => true,
    'captchaLength' => "5"
];
// This array holds the links to be displayed when a member has logged in
$member_link_array = [
    "Gästbok" => "guestbook.php",
    "Meddlemssida" => "members.php"
];
// This array holds the links to be displayed when a admin has logged in
$admin_link_array = [
    "Adminsida" => "admin.php"
];
