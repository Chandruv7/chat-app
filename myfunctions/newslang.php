 <?php
ob_start();
session_start(); 
include '../configure.php'; 
include '../database/db.php'; 
include '../myfunctions/idgen.php'; 
$connection=new dbconnect;
include '../session.php'; 
$newslanguage1=$_POST['newslanguage'];

$update_message_query= "UPDATE `17cs05_user_settings` SET FeedLanguage='$newslanguage1',Updator='$userid',UpdatedDate='$timenow' WHERE CurrentlyActive='1' AND UserID='$userid' ";

$insert_exec=$connection->connectingdb()->query($update_message_query);

  exit();
?>
