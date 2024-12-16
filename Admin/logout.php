<?php
session_start();
include_once "../includes/connect.php";
include_once "../includes/functions.php";

if (!isset($_SESSION["admin_id"])) {
    redirectToLogin();
} else {
    session_unset();
    session_destroy();
    redirectToLogin();
}
