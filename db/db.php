<?php
//Connect to Database
$db = mysqli_connect("localhost","root","","blog_db");

//Check Connection
if (!$db) {
    die("DB Connection Failed". mysqli_connect_error());
}