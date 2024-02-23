<?php
session_start();

if (isset($_SESSION['username']) && isset($_SESSION['email'])) {
    $user = $_SESSION['username'];
    $user_email = $_SESSION['email'];
}