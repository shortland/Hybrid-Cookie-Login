<?php
// Reference to method of encryption.
// http://alias.io/2010/01/store-passwords-safely-with-php-and-mysql/

$got_u_cookie = $_COOKIE['u_cookie'];
$got_p_cookie = $_COOKIE['p_cookie'];

$uc_safe = addslashes($got_u_cookie);
$pc_safe = addslashes($got_p_cookie);


$username = $_POST['username'];
$password = $_POST['password'];
$method = $_POST['method'];

$username_safe = addslashes($username);
$password_safe = addslashes($password);
$method_safe = addslashes($method);

$b64_username = base64_encode($username_safe);
$b64_password = base64_encode($password_safe);

if (!isset($_POST["method"]) && empty($_POST["method"])) {
echo "<form action='login.php' method='post'>\n";
echo "Username: <input type='text' name='username'/><br>\n";
echo "Password: <input type='password' name='password'/><br>\n";
echo "<input type='hidden' name='method' value='login'/>\n";
echo "<input type='submit' value='Login'/><br>\n";
echo "</form>\n";
die();
} elseif ($method == "login"){
function randomString($length = 24) { // String used for cookie.
    $characters = '02468AEIOUY'; // Only "Even" numbers, and Vowels used to make random string.
    $String = '';
    for ($i = 0; $i < $length; $i++) {
        $String .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $String;
}

$connect = mysqli_connect("localhost","username","password","db");
if (mysqli_connect_errno()) {
  echo "CANT CONNECT:" . mysqli_connect_error();
}

$login = mysqli_query($connect, "SELECT `username`, `password`, `salt` FROM `users` WHERE `username` = '$b64_username'");

while($row = mysqli_fetch_array($login)) {
  $salt = $row['salt'];
  $hashed = crypt($b64_password, $salt);
  $got_password = $row['password'];
  
  $valid = "ok";
}
if (!isset($valid)){
echo "Invalid Username $b64_username";
die();
}
if($hashed == $got_password){

// Logged in :D
$u_cookie = randomString();
$p_cookie = randomString();
$today_date = date('Y-m-d');
// insert login cookie to users here. 
mysqli_query($connect, "UPDATE `users` SET `u_cookie` = '$u_cookie', `p_cookie` = '$p_cookie', `cookie_set` = '$today_date' WHERE `username` = '$b64_username' AND `password` = '$hashed'");

setcookie("u_cookie", $u_cookie);
setcookie("p_cookie", $p_cookie);


echo "Logging in";
header('Location: private.php');

mysqli_close($connect);
die(); // die anyways
} else {
echo "Invalid Password.";
die();
}

} // method 


?>