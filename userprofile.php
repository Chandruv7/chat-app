<?php 
ob_start();
session_start(); 
include 'configure.php'; 
include 'database/db.php'; 
$connection=new dbconnect;
include 'session.php'; 
include 'myfunctions/fetchnamefromtable.php'; 
$displayname=fetchnamefromtable("17cs05_user_registration","UserID",$userid,"DisplayName",$connection);
 $query_request= "SELECT * FROM 17cs05_friendrequest where CurrentlyActive='1' AND RequestStatus='1' AND (RequestTo='$userid' OR RequestFrom='$userid') ";
$exec_request= $connection->connectingdb()->query($query_request);
 $res_req= mysqli_num_rows($exec_request);

 $query_request1= "SELECT * FROM 17cs05_friendrequest where CurrentlyActive='1' AND RequestStatus='2' AND (RequestTo='$userid' OR RequestFrom='$userid') ";
$exec_request1= $connection->connectingdb()->query($query_request1);
 $res_req1= mysqli_num_rows($exec_request1);

 $query_request2= "SELECT * FROM 17cs05_friendrequest where CurrentlyActive='1' AND RequestStatus='5' AND (RequestTo='$userid' OR RequestFrom='$userid') ";
$exec_request2= $connection->connectingdb()->query($query_request2);
 $res_req2= mysqli_num_rows($exec_request2);

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Gumbling V1.0 | User Profile</title>
<!-- Tell the browser to be responsive to screen width -->
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Font Awesome -->
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
<link rel="stylesheet" href="plugins/iCheck/square/blue.css">
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

<script type="text/javascript">
function userupdate(){
toastr.error('Oops! Something went wrong.')
}
function userupdate1(){
toastr.success('Profile Updated Successfully!')
}

</script>

</head>
<?php 

if(isset($_GET['msg']) && $_GET['msg']=="userupdate"){
echo '<script type="text/javascript">$(document).ready(function(){$("#but_id2").trigger("click");});</script>';
echo '<script type="text/javascript">setTimeout(function() {location.replace("userprofile.php");}, 2000);</script>';
}

if (isset($_POST["updateprofile"]))
{
extract($_POST);


if($_FILES["dpimage"]["name"]!="")
{
$file=$_FILES["dpimage"]["tmp_name"];
$image_name=$_FILES["dpimage"]["name"];
$file_ext1 = strtolower(pathinfo($image_name,PATHINFO_EXTENSION));
$location='dist/img/'.$image_name;
move_uploaded_file($file,$location); 
}
else{
$image_name=$oldimage;
}
$query_update= "SELECT * FROM 17cs05_user_registration where CurrentlyActive='1' AND UserID='$userid'";
$exec_update= $connection->connectingdb()->query($query_update);
$res_update= mysqli_num_rows($exec_update);
if($res_update==1){
$update_query= "UPDATE `17cs05_user_registration` SET `DisplayName`='$displayname',`MobileNo`='$mobileno',`EmailID`='$emailid',`AboutMessage`='$abtmsg',`DisplayPicture`='$image_name',`Updator`='$userid',`UpdatedDate`='$timenow' WHERE UserID='$userid'";
$update_exec=$connection->connectingdb()->query($update_query);
header("Location:userprofile.php?msg=userupdate");
}
else{
echo '<script type="text/javascript">$(document).ready(function(){$("#but_id1").trigger("click");});</script>';
}
}
?>
<body class="hold-transition ">
<div class="wrapper">
<div class="">
<?php
$query_online = "SELECT * from 17cs05_user_registration  where  CurrentlyActive='1' AND UserID='$userid'";
$exec_online = $connection->connectingdb()->query($query_online);
if($retrieve = mysqli_fetch_array($exec_online))
{
$displayname_fetch=$retrieve['DisplayName'];
$displayimg_fetch=$retrieve['DisplayPicture'];
if($displayimg_fetch==""){
$displayimg_fetch='avatar.png';
}
$status_fetch=$retrieve['Status'];
$abtmsg_fetch=$retrieve['AboutMessage'];
$mob_fetch=$retrieve['MobileNo'];
$email_fetch=$retrieve['EmailID'];
}
?>
<section class="content">
<div class="container-fluid">
<div class="row">
<section class="col-lg-12 connectedSortable " style="padding-left: unset !important;padding-right: unset !important;">
<div class="card direct-chat direct-chat-warning" style="height: 720px;box-shadow: unset;">
<?php include 'header.php'; ?>
<div class="card-body">
<div class="card card-widget widget-user" style="box-shadow: unset;">
<!-- Add the bg color to the header using any of the bg-* classes -->
<div class="widget-user-header text-white"
style="background: url('dist/img/photo1.png') center center;">
<h3 class="widget-user-username text-right"></h3>
<h5 class="widget-user-desc text-right"></h5>
</div>
<div class="widget-user-image" >
<img class="img-circle" src="dist/img/<?php echo $displayimg_fetch; ?>" alt="User Avatar" style="height: 100px;width: 100px;">
</div>
<div class="card-footer">
<div class="row">
<button id="but_id1" onclick="userupdate();" style="display: none;"></button>
<button id="but_id2" onclick="userupdate1();" style="display: none;"></button>
<!-- /.col -->
<div class="col-sm-4 ">
<div class="description-block">
<h5 class="description-header"><?php echo $displayname_fetch; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-edit text-success" style="cursor: pointer;" data-toggle="modal" data-target="#modal-default"></i></h5>
<span class=""><?php echo $abtmsg_fetch; ?></span>
</div>
<!-- /.description-block -->
</div>
<!-- /.col -->
<div class="col-sm-4">
<div class="description-block">
<h5 class="description-header">Mobile No&nbsp;&nbsp;&nbsp;&nbsp;</h5>
<span class=""><?php echo $mob_fetch; ?>&nbsp;&nbsp;&nbsp;&nbsp;</span>
</div>
<!-- /.description-block -->
</div>
<div class="col-sm-4">
<div class="description-block">
<h5 class="description-header">Email Id &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h5>
<span class=""><?php echo $email_fetch; ?></span>
</div>
<!-- /.description-block -->
</div>
<!-- /.col -->
</div><br>
<div class="row">
          
          <!-- /.col -->
          <div class="col-md-3 col-sm-6 col-12" style="cursor: pointer;" onclick='window.location.assign("requestlist.php")'>
            <div class="info-box">
              <span class="info-box-icon bg-success"><i class="fa fa-flag"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Friend Requests</span>
                <span class="info-box-number"><?php echo $res_req; ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-md-3 col-sm-6 col-12" style="cursor: pointer;" onclick='window.location.assign("friendslist.php")'>
            <div class="info-box">
              <span class="info-box-icon bg-warning"><i class="fa fa-star" style="color: #fff;"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Friends</span>
                <span class="info-box-number"><?php echo $res_req1; ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-md-3 col-sm-6 col-12" style="cursor: pointer;" onclick='window.location.assign("blocklist.php")'>
            <div class="info-box">
              <span class="info-box-icon bg-danger"><i class="fa fa-ban"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Blocked</span>
                <span class="info-box-number"><?php echo $res_req2; ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
<!-- /.row -->
</div>

</div>
</div>
</div>
</section>
</div>
</div>
</section>
</div>
</div>


<div class="modal fade" id="modal-default">
<div class="modal-dialog">
<form method="post" autocomplete="off" enctype="multipart/form-data">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title">Edit User Details</h4>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body">

<div class="row">
<div class="col-md-6 ">
<div class="form-group has-feedback">
<label>Display Name</label>
<input type="text" class="form-control" maxlength="6" name="displayname" placeholder="Display Name (Maximum of 6 characters)" value="<?php echo $displayname_fetch; ?>" required>

</div>
</div>
</div>

<div class="row">
<div class="col-md-6 col-6">
<div class="form-group has-feedback">
<label>Mobile Number</label>
<input type="text" class="form-control" minlength="10" name="mobileno" placeholder="Mobile Number" required="" value="<?php echo $mob_fetch; ?>">

</div>
</div>
<div class="col-md-6 col-6">
<div class="form-group has-feedback">
<label>Email Id</label>
<input type="email" class="form-control" name="emailid" placeholder="Email Address" value="<?php echo $email_fetch; ?>">

</div>
</div>
</div>
<div class="row">
<div class="col-md-6">
<div class="form-group has-feedback">
<label>About Content</label>
<textarea class="form-control" name="abtmsg" placeholder="About Message"><?php echo $abtmsg_fetch ?></textarea>
</div>
</div>
<div class="col-md-6">
<!--  <div class="form-group has-feedback">
<label>Display Picture</label>
<input type="file" name="dpimg">
</div> -->
<div class="form-group">
<label for="customFile">Display Picture</label> 

<div class="custom-file">
<input type="file" class="custom-file-input" id="customFile" name="dpimage">
<input type="hidden" id="filehide" name="oldimage" value="<?php echo $displayimg_fetch; ?>">
<label class="custom-file-label" for="customFile">Choose file</label>
</div>
</div>
</div>
</div>


</div>
<div class="modal-footer justify-content-between">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
<button type="submit" name="updateprofile" class="btn btn-warning">Save changes</button>
</div>
</div>
</form>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!--       <script type="text/javascript">
$(document).ready(function () {
$("#customFile").on('change',(function() {

var imageval=$("#customFile").val();
$.ajax({
url: "uploaddp.php",
type: "POST",
data: new FormData() ,
contentType: false,
cache: false,
processData:false,
success: function(data)
{
alert(data);
$("#filehide").val(data);
},
error: function() 
{
}           
});
}));
});
</script> -->
</body>
</html>
