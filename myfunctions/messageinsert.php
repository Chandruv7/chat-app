 <?php
ob_start();
session_start(); 
include '../configure.php'; 
include '../database/db.php'; 
include '../myfunctions/idgen.php'; 
$connection=new dbconnect;
include '../session.php'; 
include '../myfunctions/fetchnamefromtable.php'; 
$username=fetchnamefromtable("17cs05_user_registration","UserID",$userid,"UserName",$connection);
$dpname=fetchnamefromtable("17cs05_user_registration","UserID",$userid,"DisplayName",$connection);
$messagename1=$_POST['messagename'];
$messageid = idgeneration('ChatMessageID','17cs05_user_chatmessage','UCM');
 $query_message= "SELECT * FROM 17cs05_user_chatmessage where CurrentlyActive='1' AND ChatMessageID='$messageid'";
$exec_message= $connection->connectingdb()->query($query_message);
$res_message= mysqli_num_rows($exec_message);
if($res_message==0){
 $insert_message_query= "INSERT INTO `17cs05_user_chatmessage`(`UserID`,`UserName`,`ChatMessageID`,`ChatMessage`,`ChatMessageTime`,`Creator`) values('$userid','$username','$messageid','$messagename1','$timenow','$userid')";
$insert_exec=$connection->connectingdb()->query($insert_message_query);
echo'<script type="text/javascript">document.getElementById("mes_ins").value="";</script>';
}
else{
  
}
?>
