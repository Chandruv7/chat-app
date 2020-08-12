 <?php
ob_start();
session_start(); 
include '../configure.php'; 
include '../database/db.php'; 
include '../myfunctions/idgen.php'; 
$connection=new dbconnect;
include '../session.php'; 
$newsfeed1=$_POST['newsfeed'];
$newslang1=$_POST['newslang'];
 $query_message= "SELECT * FROM 17cs05_user_settings where CurrentlyActive='1' AND UserID='$userid'";
$exec_message= $connection->connectingdb()->query($query_message);
$res_message= mysqli_num_rows($exec_message);
if($res_message==0){
 $insert_message_query= "INSERT INTO `17cs05_user_settings`(`NewsFeed`,`FeedLanguage`,`Creator`) values('$newsfeed1','$newslang1','$userid')";
$insert_exec=$connection->connectingdb()->query($insert_message_query);
}
else{
   $update_message_query= "UPDATE `17cs05_user_settings` SET NewsFeed='$newsfeed1',FeedLanguage='$newslang1',Updator='$userid',UpdatedDate='$timenow' WHERE CurrentlyActive='1' AND UserID='$userid' ";

$insert_exec=$connection->connectingdb()->query($update_message_query);
}
  exit();
?>
