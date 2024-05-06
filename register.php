<?php
include 'config.php';


$register = "INSERT INTO `user` (`no_hp`, `email`, `password`, `username`) VALUES ('$_POST[no_hp]', '$_POST[email]', '$_POST[password]', '$_POST[username]');";
//inisialisasi session
session_start();
$error = '';
$validate = '';
//mengecek apakah form registrasi di submit atau tidak

if (mysqli_query($conn, $register)) {
    $_SESSION['username'] = $username;
    header('Location: index.html');
} else {
    echo "<script>alert('Pastikan Email dan Password anda benar')</script>";
};
