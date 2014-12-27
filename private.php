<?php
// Example of "login" protected page.

$uc_safe = addslashes($_COOKIE['u_cookie']);
$pc_safe = addslashes($_COOKIE['p_cookie']);
include 'cookie_login.php';
if (!isset($uc_safe) && isset(!$pc_safe)){
die();
}
// All code bellow is shown only to members,
// Insert your members only content bellow.
// Some example code bellow.

echo "Logged in, Private registered user content only here."; // just a message saying that we are really logged in (through cookies)
echo "<br>";
echo $real_username;
echo "<br>";
echo $real_email;
echo "<br>";
echo "Username and email are displayed above, they have been selected from 'cookielogin.php' use 'cookielogin.php' to select more variables ect. and simply only use the variables you need in each 'private.php' page.";
