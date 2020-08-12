<?php 
ob_start();
session_start(); 
include 'configure.php'; 
include 'database/db.php'; 
$connection=new dbconnect;
include 'session.php'; 
include 'myfunctions/fetchnamefromtable.php'; 
include 'myfunctions/lastseen.php'; 
$displayname=fetchnamefromtable("17cs05_user_registration","UserID",$userid,"DisplayName",$connection);

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Gumbling | Group Chat</title>
  <!-- Tell the browser to be responsive to screen width -->
   <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- SweetAlert2 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="plugins/toastr/toastr.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- iCheck -->
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- iCheck -->
<!-- SweetAlert2 -->
<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="plugins/toastr/toastr.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<style type="text/css">
  @media only screen and (max-width: 600px) {
#usrimg{
  width: 128px !important;
  height: 80px !important;
}
}
.flright{
  float: right;
}
</style>
</head>

<body class="hold-transition ">
<div class="wrapper">
  <div class="">
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <section class="col-lg-12 connectedSortable" style="padding-left: unset !important;padding-right: unset !important;">
                <!-- USERS LIST -->
                <div class="card"  style="box-shadow: none;">
                   <?php include 'header.php'; ?>
                  <!-- /.card-header -->
                  <div class="card-body p-0">
                    <ul class="users-list clearfix">
                    <?php
                    $sno=0;
                    $query_online = "SELECT * from 17cs05_user_registration  where  CurrentlyActive='1' AND UserID<>'$userid' ORDER BY Status='online' DESC";
                    $exec_online = $connection->connectingdb()->query($query_online);
                    while($retrieve = mysqli_fetch_array($exec_online))
                    {
                      $displayname_fetch=$retrieve['DisplayName'];
                      $userid_fetch=$retrieve['UserID'];
                      $status_fetch=$retrieve['Status'];
                      if($status_fetch=='offline'){
                      $updatetime_fetch=$retrieve['UpdatedDate'];
                      $updatetime_fetch=getDateTimeDiff($updatetime_fetch);
                      }
                      else{
                        $updatetime_fetch='Online';
                      }
                      
                      if($status_fetch=="online"){
                        $status_fetch="fa fa-circle text-success";
                      }
                      else{
                        $status_fetch="fa fa-circle text-danger";
                      }
                      $dp_fetch=$retrieve['DisplayPicture'];
                      if($dp_fetch==""){
                       $dp_fetch="avatar.png";
                      }
                       $query_request = "SELECT * from 17cs05_friendrequest  where  CurrentlyActive='1' AND (RequestFrom='$userid_fetch' AND RequestTo='$userid') OR (RequestTo='$userid_fetch' AND RequestFrom='$userid')";
                    $exec_req = $connection->connectingdb()->query($query_request);
                    if($req = mysqli_fetch_array($exec_req))
                    {
                     $reqstatus_fetch=$req['RequestStatus'];
                      if($reqstatus_fetch==0){
                       $reqstatus_fetch='style="display:none;"';
                        $reqstatus_fetch1='style=""';
                      }
                      elseif ($reqstatus_fetch==1) {
                       $reqstatus_fetch='style=""';
                        $reqstatus_fetch1='style="display:none;"';
                      }
                      elseif ($reqstatus_fetch==2) {
                       $reqstatus_fetch='style="display:none;"';
                        $reqstatus_fetch1='style="display:none;"';
                      }
                      elseif ($reqstatus_fetch==5) {
                       $lihide='display:none;';
                        $reqstatus_fetch="";
                     $reqstatus_fetch1="";
                      }
                      else{
                     $lihide="";
                     $reqstatus_fetch="";
                     $reqstatus_fetch1="";
                      }
                    }
                    else{
                      $reqstatus_fetch='style="display:none;"';
                     $reqstatus_fetch1='style=""';
                     $lihide="";
                    }
                     

                    $sno++;
                    ?>
                      <li style="width: 30%;cursor:pointer;margin-right: 10px;<?php echo $lihide; ?>">
                       <a href="userprofile1.php?usrid=<?php echo $userid_fetch; ?>"><img id="usrimg" src="dist/img/<?php echo $dp_fetch; ?>" alt="User Image" style="width: 108px;height: 108px;"></a>
                        <a class="users-list-name text-dark"><?php echo $displayname_fetch; ?>&nbsp;<i class="<?php echo $status_fetch; ?>"></i>&nbsp; <i <?php echo $reqstatus_fetch1; ?> class="fa fa-user-plus text-primary " id="frndreq<?php echo $sno; ?>" onclick="undoreq1('<?php echo $sno; ?>','<?php echo $userid_fetch; ?>');reqsent('<?php echo $displayname_fetch; ?>');"  data-toggle="tooltip" title="Send Friend Request"></i><i class="fa fa-check text-success " <?php echo $reqstatus_fetch ?> onclick="undoreq('<?php echo $sno; ?>','<?php echo $userid_fetch; ?>');notsent();" data-toggle="tooltip" title="Undo Friend Request" id="undoreqest<?php echo $sno; ?>"></i></a>
                        <span class="users-list-date" style="text-align: center; "><?php echo $updatetime_fetch; ?></span>
                      </li>
                    <?php } ?>
                    </ul>
                    <!-- /.users-list -->
                  </div>
                  <!-- /.card-body -->
                  <!-- /.card-footer -->
                </div>
                <!--/.card -->
          </section>
        </div>
      </div>
    </section>
  </div>
</div>
<script type="text/javascript">
function reqsent(user){

const Toast = Swal.mixin({
toast: true,
position: 'top-end',
showConfirmButton: false,
timer: 3000
});

Toast.fire({
type: 'success',
title: ' Friend Request Sent to '+user+ ' .'
})
}

function notsent(){

const Toast = Swal.mixin({
toast: true,
position: 'top-end',
showConfirmButton: false,
timer: 3000
});

Toast.fire({
type: 'warning',
title: ' Friend Request Cancelled.'
})
}

function undoreq(val,userval){
$("#frndreq"+val).show();
$("#undoreqest"+val).hide();
friendrequest(0,userval);
}
function undoreq1(val,userval){
$("#undoreqest"+val).show();
$("#frndreq"+val).hide();
friendrequest(1,userval);
}

function friendrequest(reqval,userval)
{
$.ajax({
type:"POST",
url: "myfunctions/friendrequest.php",
data:  {
reqname: reqval,
friendname: userval
},
cache: false,
success: function(response1){

}
});
}
</script>
</body>
</html>
