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

 $query_request= "SELECT * FROM 17cs05_friendrequest where CurrentlyActive='1' AND RequestFrom='$friendname1' AND RequestTo='$userid'";
$exec_request= $connection->connectingdb()->query($query_request);
$res_message= mysqli_num_rows($exec_request);
if($res_message==0){
	$reqid = idgeneration('RequestID','17cs05_friendrequest','FRQ');
 $insert_request_query= "INSERT INTO `17cs05_friendrequest`(`RequestID`,`RequestFrom`,`RequestTo`,`RequestStatus`,`RequestDate`,`Creator`) values('$reqid','$friendname1','$userid','$reqname1','$timenow','$userid')";
$insert_exec=$connection->connectingdb()->query($insert_request_query);
}
else{
 $update_request_query= "UPDATE `17cs05_friendrequest` SET RequestStatus='$reqname1',Updator='$userid',UpdatedDate='$timenow' WHERE RequestFrom='$friendname1' AND RequestTo='$userid' AND CurrentlyActive='1'";
$update_exec=$connection->connectingdb()->query($update_request_query);
}
?>
<div class="col-12" id="frndreq">
<table class="table " style="height: 10px;overflow-y:scroll;">
                  <thead>                  
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Request List</th>
                      <th>Accept</th>
                      <th style="width: 40px">Reject</th>
                    </tr>
                  </thead>
                  <tbody >
                  	<?php 
                  	$frnd=0;
                  	$qry_friend = "SELECT * from 17cs05_friendrequest  where  CurrentlyActive='1' AND RequestStatus='1' AND RequestTo='$userid'";
$exec_frnd = $connection->connectingdb()->query($qry_friend);
$req_count= mysqli_num_rows($exec_frnd);

while($retfrnd = mysqli_fetch_array($exec_frnd))
{
	$frnd_fetch=$retfrnd['RequestFrom'];
$frnd_fetch_name=fetchnamefromtable("17cs05_user_registration","UserID",$frnd_fetch,"DisplayName",$connection);
$frnd++;


	?>
                    <tr>
                      <td><?php echo $frnd; ?></td>
                      <td><?php echo $frnd_fetch_name; ?></td>
                      <td>&nbsp;&nbsp;<span class="badge bg-success" style="cursor: pointer;" onclick="reqacpt('2','<?php echo $frnd_fetch; ?>');userupdate1();"><i class="fa fa-check" style="color: #fff;"></i></span></td>
                      <td>&nbsp;&nbsp;<span class="badge bg-danger" style="cursor: pointer;"  onclick="reqacpt('3','<?php echo $frnd_fetch; ?>');userupdate();"><i class="fa fa-close" style="color: #fff;"></i></span></td>
                    </tr>

                <?php } ?>
                  </tbody>

                </table>
                <?php if($req_count==0){
  echo "<center><h4>No Friend request found <i class='fa fa-frown-o'></i></h4></center>";

} ?>
            </div>
