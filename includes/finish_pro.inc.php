<?php
session_start();
require "dbconnect.inc.php";

$member_id=$_POST['member_id'];
header("Location:../final_mem_step.php?member_id=$member_id");