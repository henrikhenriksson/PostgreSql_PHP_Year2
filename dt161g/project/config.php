<?PHP

/*******************************************************************************
 * Project Assignment, Kurs: DT161G
 * File: config.php
 * Desc: Config file for dt161g Project Assignment
 *
 * Henrik Henriksson
 * hehe0601
 * hehe0601@student.miun.se
 ******************************************************************************/

// settings can be changed here:
$confSettings = [
    //'host' => "studentpsql.miun.se",
    'host' => "127.0.0.1",
    'port' => "5432",
    'dbName' => "hehe0601",
    'user' => "hehe0601",
    'pass' => "b0cZeRKbe",
    'debug' => true,
    'targetdir' => __DIR__ . "\\..\\..\\writeable",
    'validFileTypes' => [
        "gif", "jpeg", "jpg", "png"
    ],
    'memberLinkArray' => [
        "Medlemssida" => "userpage.php"
    ],
    'adminLinkArray' => [
        "AdminSida" => "admin.php"
    ]
];
// This array holds the links to be displayed when a member has logged in
$member_link_array = [
    "Meddlemssida" => "userpage.php"
];
// This array holds the links to be displayed when a admin has logged in
$admin_link_array = [
    "Adminsida" => "admin.php"
];
