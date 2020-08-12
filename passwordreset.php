<?php
ob_start();
include_once('database/db.php');
include_once('configure.php');
$timenow= date('Y-m-d h:i:s');
$connection=new dbconnect;
if (isset($_POST["uppass"]))
{
extract($_POST);
if($password==$confirmpass)
{
$useridnew=$_GET['id'];
$password1=sha1($password);
$retyped_password1=sha1($confirmpass);
$query_user= "SELECT * FROM 17cs05_user_registration where CurrentlyActive='1' AND UserID='$useridnew'";
$exec_user= $connection->connectingdb()->query($query_user);
$res_user= mysqli_num_rows($exec_user);
if($res_user==1){
  $update_query ="UPDATE `17cs05_user_registration` SET Password='$password1',ConfirmPassword='$retyped_password1',Updator='$useridnew',UpdatedDate='$timenow' WHERE UserID='$useridnew' AND CurrentlyActive='1'";
  $update_execute= $connection->connectingdb()->query($update_query);
 header("location:index.php");
}
else{
}
}
else{
    echo '<script type="text/javascript">$(document).ready(function(){$("#but_id").trigger("click");});</script>';
}
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Gumbling V1.0 | Log in</title>
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

</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
     <img src="dist/img/gum_logo.png" style="width: 60px;height: 60px;">
    <a ><b>GumblingApp</b> V1.0</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Configure Password</p>

      <form method="post" autocomplete="off">
        <div class="form-group has-feedback">
          <input type="password" class="form-control" id="showthispass1" name="password" placeholder="New Password">
        </div>
        <div class="form-group has-feedback">
          <input type="password" name="confirmpass" id="showthispass" class="form-control" placeholder="Retype Password">
          <span class="fa fa-lock form-control-feedback"></span>&nbsp;&nbsp; <span class="fa fa-eye form-control-feedback text-primary" style="cursor: pointer;" onclick="showhidepass();"></span>
        </div>
        <div class="row">
          <button id="but_id" onclick="passwordvalid();" style="display: none;"></button>
           <div class="col-4">
           <button type="submit" name="uppass" class="btn btn-primary btn-block btn-flat">Update</button></a>
          </div>
        </div>
          <!-- /.col -->
         
      </form>

    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass   : 'iradio_square-blue',
      increaseArea : '20%' // optional
    })
  })
</script>
  <script type="text/javascript">
    function userinvalid(){
toastr.error('Oops , Username or Password is invalid')
}
function showhidepass() {
var showpass = document.getElementById("showthispass");
if (showpass.type === "password" ) {
showpass.type = "text";
} else {
showpass.type = "password";
}

var showpass1 = document.getElementById("showthispass1");
if (showpass1.type === "password" ) {
showpass1.type = "text";
} else {
showpass1.type = "password";
}

}
function passwordvalid(){
toastr.error('Password may be mismatching')
}

</script>
</body>
</html>
