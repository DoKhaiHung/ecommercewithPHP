<?php
require "api/start.php";
if (isset($_SESSION['id'])) unset($_SESSION['id']);
if (isset($_COOKIE['token'])) {
    unset($_COOKIE['token']); 
    setcookie('token','', time()-2000); 
}
if(isset($_SESSION['cart'])) {
    unset($_SESSION['cart']);
   // setcookie('quantity','', time()-2000,'/'); 
}
if(isset($_SESSION)) {
    unset($_SESSION);
   // setcookie('quantity','', time()-2000,'/'); 
}
header("Location: ./");
?>