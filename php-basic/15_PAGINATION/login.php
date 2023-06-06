<?php 
session_start();
require 'functions2.php';

ini_set("display_errors","1");
ini_set("display_startup_errors","1");
error_reporting(E_ALL);

// cek cookie
// 1) basic
// if( isset($_COOKIE['login']) ) {
//     if( $_COOKIE['login'] == 'true' ) {
//         $_SESSION['login'] = true;
//     }
// }

// 2) secure
if( isset($_COOKIE['id']) && isset($_COOKIE['key']) ) {
    $id = $_COOKIE['id'];
    $key = $_COOKIE['key'];

    // ambil username berdasarkan id
    $query = "SELECT username
              FROM users
              WHERE id = $id";

    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    // cek cookie dan username
    if( $key === hash('sha256', $row['username']) ) {
        $_SESSION['login'] = true;
    }
}

if( isset($_SESSION["login"]) ) {
    header("Location: index2.php");
    exit;
}

if( isset($_POST["login"]) ) {

    $username = $_POST["username"];
    $password = $_POST["password"];

    $query = "SELECT * 
              FROM users
              WHERE username = '$username'";

    $result = mysqli_query($conn, $query);

    // cek username
    if ( mysqli_num_rows($result) === 1 ) {

        // cek password
        $row = mysqli_fetch_assoc($result);
        if( password_verify($password, $row["password"]) ) {
            // set session
            $_SESSION["login"] = true;
            
            // cek remember me
            if( isset($_POST['remember']) ) {
                // buat cookie
                // 1) basic
                // setcookie('login','true', time() + 60*5);

                // 2) secure
                setcookie('id', $row['id'], time() + 60*5);
                setcookie('key', hash('sha256', $row['username']), time() + 60*5);
            }

            header("Location: index2.php");
            exit;
        }
    }

    $error = true;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman login</title>
</head>
<body>
    <h2>Halaman login</h2>

    <?php if( isset($error) ) : ?>
        <p style="color: red; font-style:italic">username / password salah</p>
    <?php endif;?>

    <form action="" method="post">
        <ul>
            <li>
                <label for="username">Username :</label>
                <input type="text" name="username" id="username">
            </li>
            <li>
                <label for="password">Password</label>
                <input type="password" name="password" id="password">
            </li>
            <li>
                <input type="checkbox" name="remember" id="remember">
                <label for="remember">Remember me</label>
            </li>
            <li>
                <button type="submit" name="login">Sign in !</button>
            </li>
        </ul>
    </form>

</body>
</html>