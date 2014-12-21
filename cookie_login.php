<?php
// This page checks to see if a user is logged in.
// If they are not logged in, they are presented with a login form.
// simply: include 'cookie_login.php';
// Nothing more is necessary.

// This page is meant to run SQL Queries as-well. (since it's cookie protected)
// For example, two variables are already set: "$real_username" and "$real_email"
// So any page that has this page "included" can use $real_username and get the user's username... Ect...

// Go ahead and set more variables by fetching more stuff from DB

if(!isset($_COOKIE['u_cookie']) && !isset($_COOKIE['p_cookie'])){
echo "<form action='login.php' method='post'>\n";
echo "Username: <input type='text' name='username'/><br>\n";
echo "Password: <input type='password' name='password'/><br>\n";
echo "<input type='hidden' name='method' value='login'/>\n";
echo "<input type='submit' value='Login'/><br>\n";
echo "</form>\n";

die();
}

$uc_safe = addslashes($_COOKIE['u_cookie']);
$pc_safe = addslashes($_COOKIE['p_cookie']);

$connect = mysqli_connect("localhost","username","password","db");
if (mysqli_connect_errno()) {
  echo "CANT CONNECT:" . mysqli_connect_error();
}

$check = mysqli_query($connect, "SELECT `u_cookie`, `p_cookie`, `username`, `email` FROM `users` WHERE `u_cookie` = '$uc_safe' AND `p_cookie` = '$pc_safe'") or die(mysqli_error($connect));
// Get the salt by username, use salt to hash the password. then check if new hashed password is == to the stored password.

while($row = mysqli_fetch_array($check)) {
  // use these variables in files that have THIS file included. no need to do mysql queries to get username ect.
  $real_username = base64_decode($row['username']);
  $real_email = $row['email'];
  $valid = "ok";
}
if (!isset($valid)){
// Invalid, old, currupt cookies
// Force user to login again.
echo "<form action='login.php' method='post'>\n";
echo "Username: <input type='text' name='username'/><br>\n";
echo "Password: <input type='password' name='password'/><br>\n";
echo "<input type='hidden' name='method' value='login'/>\n";
echo "<input type='submit' value='Login'/><br>\n";
echo "</form>\n";

die();
}

?>