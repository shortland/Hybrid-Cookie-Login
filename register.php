<?php
// REGISTER PAGE
// Reference to method of encryption.
// http://alias.io/2010/01/store-passwords-safely-with-php-and-mysql/

$username = $_POST['username'];
$password1 = $_POST['password1'];
$password2 = $_POST['password2'];
$email = $_POST['email'];
$method = $_POST['method'];

$username_safe = addslashes($username);
$password1_safe = addslashes($password1);
$password2_safe = addslashes($password2);
$email_safe = addslashes($email);
$method_safe = addslashes($method);

$b64_username = base64_encode($username_safe);
$b64_password1 = base64_encode($password1_safe);
$b64_password2 = base64_encode($password2_safe);


if (!isset($_POST["method"]) && empty($_POST["method"])) {
echo "<form action='' method='post'>\n";
echo "Username: <input type='text' name='username'/><br>\n";
echo "Password: <input type='password' name='password1'/><br>\n";
echo "Repeat Password: <input type='password' name='password2'/><br>\n";
echo "Email: <input type='text' name='email'/><br>\n";
echo "<input type='hidden' name='method' value='register'/>\n";
echo "<input type='submit' value='Register'/><br>\n";
echo "</form>\n";
die();
} elseif ($method == "register"){
function randomString($length = 24) { // String used for cookie.
    $characters = '02468AEIOUY'; // Only "Even" numbers, and Vowels used to make random string. just cus...
    $String = '';
    for ($i = 0; $i < $length; $i++) {
        $String .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $String;
}

if($password1_safe !== $password2_safe){
echo "Passwords do not match";
die();
}

$connect = mysqli_connect("localhost","username","password","db");
if (mysqli_connect_errno()) {
  echo "CANT CONNECT:" . mysqli_connect_error();
}

// check if username exists
$check_exists = mysqli_query($connect, "SELECT `username` FROM `users` WHERE `username` = '$b64_username'");
// Get the salt by username, use salt to hash the password. then check if new hashed password is == to the stored password.

while($row = mysqli_fetch_array($check_exists)) {
$it_exists = "yes"; 
} if ($it_exists == "yes"){
echo "Username already exists.";
die();
}
$username_length = strlen($username_safe);
if ($username_length <= '4'){
echo "Please choose a username with more than 5 characters." . $username_safe . " (" . $username_length . ")";
die();
} // else we are good to go :D

$leg = 10;
$salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');
$salt = sprintf("$2a$%02d$", $leg) . $salt;
$password_hashed = crypt($b64_password1, $salt);

$register_user = mysqli_query($connect, "INSERT INTO users (username, password, salt, email, real_user) VALUES ('$b64_username', '$password_hashed', '$salt', '$email_safe', '$username_safe')") or die(mysqli_error($connect));


// Get the salt by username, use salt to hash the password. then check if new hashed password is == to the stored password.
echo "Registered Successfully, You can now login.";
// location to login.php
die();
} // method 


?>