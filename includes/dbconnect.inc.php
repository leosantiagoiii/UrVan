<?php

$server_name="localhost";
$database_username="root";
$database_password="";
$database_name="urvan_database";

$conn=mysqli_connect($server_name,$database_username,$database_password,$database_name);

if(mysqli_connect_errno($conn)){
    echo 'Failed to connect to mySQL: '.mysqli_connect_error();
}
