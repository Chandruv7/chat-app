<?php
session_start();
include("configure.php");
include("database/db.php");
include("session.php");
$connection=new dbconnect;
date_default_timezone_set('Asia/Calcutta'); 
$timenow= date('Y-m-d h:i:s');
$update_query ="UPDATE `17cs05_user_registration` SET Status='offline',Updator='$userid',UpdatedDate='$timenow' WHERE UserID='$userid' AND CurrentlyActive='1'";
$update_execute= $connection->connectingdb()->query($update_query);
if(session_destroy() AND setcookie("login_user", "name", time() - 360,'/'))
{
header("location:index.php"); 
}
?>