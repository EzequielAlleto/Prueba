<?php
session_start();

if (isset($_SESSION["usuario"])) {
    header("Location: Vista/Admin/Admin.html");
} else {
    header("Location: Vista/Login/Login.html");
}
?>