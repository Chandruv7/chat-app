 <?php
ob_start();
session_start(); 
include '../configure.php'; 
include '../database/db.php'; 
include '../myfunctions/idgen.php'; 
$connection=new dbconnect;
include '../session.php'; 
include '../myfunctions/fetchnamefromtable.php'; 
$reqname1=$_POST['reqname'];
$friendname1=$_POST['friendname'];

 $query_request= "SELECT * FROM 17cs05_friendrequest where CurrentlyActive='1' AND RequestFrom='$userid' AND RequestTo='$friendname1'";
$exec_request= $connection->connectingdb()->query($query_request);
$res_message= mysqli_num_rows($exec_request);
if($res_message==0){
	$reqid = idgeneration('RequestID','17cs05_friendrequest','FRQ');
 $insert_request_query= "INSERT INTO `17cs05_friendrequest`(`RequestID`,`RequestFrom`,`RequestTo`,`RequestStatus`,`RequestDate`,`Creator`) values('$reqid','$userid','$friendname1','$reqname1','$timenow','$userid')";
$insert_exec=$connection->connectingdb()->query($insert_request_query);
}
else{
 $update_request_query= "UPDATE `17cs05_friendrequest` SET RequestStatus='$reqname1',Updator='$userid',UpdatedDate='$timenow' WHERE RequestFrom='$userid' AND RequestTo='$friendname1' AND CurrentlyActive='1'";
$update_exec=$connection->connectingdb()->query($update_request_query);
}
?>
