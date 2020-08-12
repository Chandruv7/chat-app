<?php
ob_start();
include 'database/db.php'; 
include 'myfunctions/idgen.php'; 
$connection=new dbconnect;
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Gumbling V1.0 | Registration</title>
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
    function passwordvalid(){
toastr.error('Password may be mismatching')
}
    function mobilevalid(){
toastr.error('Mobile Number already Registered !')
}

</script>
<style type="text/css">
  img[src="https://cdn.000webhost.com/000webhost/logo/footer-powered-by-000webhost-white2.png"]{
    display: none;
  }
</style>
</head>
<?php 
if (isset($_POST["register"]))
{
extract($_POST);
if($password==$retyped_password)
{
$userid = idgeneration('UserID','17cs05_user_registration','USR');
$password1=sha1($password);
$retyped_password1=sha1($retyped_password);
$query_register= "SELECT * FROM 17cs05_user_registration where CurrentlyActive='1' AND MobileNo='$mobileno'";
$exec_register= $connection->connectingdb()->query($query_register);
$res_register= mysqli_num_rows($exec_register);
if($res_register==0){
$insert_register_query= "INSERT INTO `17cs05_user_registration`(`DisplayName`, `UserID`,`UserName`,`Password`,`ConfirmPassword`,`MobileNo`,`EmailID`,`Creator`) values('$displayname','$userid','$username','$password1','$retyped_password1','$mobileno','$emailid','$userid')";
$insert_exec=$connection->connectingdb()->query($insert_register_query);

$insert_settings_query= "INSERT INTO `17cs05_user_settings`(`UserID`,`Creator`) values('$userid','$userid')";
$insert_settings_exec=$connection->connectingdb()->query($insert_settings_query);
header("Location:index.php");
}
else{
  echo '<script type="text/javascript">$(document).ready(function(){$("#but_id1").trigger("click");});</script>';
}
}
else{
  echo '<script type="text/javascript">$(document).ready(function(){$("#but_id").trigger("click");});</script>';

}

}
 ?>
<body class="hold-transition register-page" style="height:unset !important;">
    <div class="register-logo" style=""><br>
      <img src="dist/img/gum_logo.png" style="width: 60px;height: 60px;">
    <a href="" ><b>GumblingAPP</b> V1.0</a>
  </div>
<div class="register-box" style="margin-top: 0px !important;">
<button id="but_id" onclick="passwordvalid();" style="display: none;"></button>
<button id="but_id1" onclick="mobilevalid();" style="display: none;"></button>

  <div class="card" style="width: 350px;">
    <div class="card-body register-card-body">
      <p class="login-box-msg">Register and Join Now</p>
      <input type="hidden" name="" class="toastsDefaultDanger">
      <form method="post" autocomplete="off">
        <div class="row">
        <div class="col-md-6">
        <div class="form-group has-feedback">
          <input type="text" class="form-control" maxlength="6" name="displayname" placeholder="Display Name (Maximum of 6 characters)">
          <span class="fa fa-user-circle-o form-control-feedback"></span>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group has-feedback">
          <input type="text" class="form-control" name="username" placeholder="User name">
          <span class="fa fa-user form-control-feedback"></span>
        </div>
      </div>
    </div>

    <div class="row">
        <div class="col-md-6">
        <div class="form-group has-feedback">
          <input type="text" class="form-control" name="mobileno" placeholder="Mobile Number">
          <span class="fa fa-phone form-control-feedback"></span>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group has-feedback">
          <input type="email" class="form-control" name="emailid" placeholder="Email Address">
          <span class="fa fa-envelope form-control-feedback"></span>
        </div>
      </div>
    </div>

        <div class="row">
        <div class="col-md-6">
        <div class="form-group has-feedback">
          <input type="password" class="form-control"  id="newpasswordid" name="password" placeholder="Password">
          <span class="fa fa-lock form-control-feedback"></span>&nbsp;&nbsp; <a class="text-primary" onclick="showhidepass();"><span class="fa fa-eye form-control-feedback"></span></a>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group has-feedback">
         <input type="password" class="form-control" id="confirmpasswordid" name="retyped_password" placeholder="Retype password">
          <span id='message' class="fa fa-lock form-control-feedback"></span>&nbsp;&nbsp; <a class="text-primary" onclick="showhidepass1();"><span class="fa fa-eye form-control-feedback"></span></a>
          
        </div>
      </div>

    </div>

        <div class="row">
          <div class="col-12">
            <div class="checkbox icheck">
              <p>
                Already Have an account ?<a href="index.php" >&nbsp;&nbsp;Login</a>
              </p>
            </div>
          </div>
        </div><br>
          <!-- /.col -->
           <div class="row">

          <div class="col-4"></div>
          <div class="col-4">
            <button type="submit" name="register" class="btn btn-warning btn-block btn-flat">Register</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <div class="social-auth-links text-center" style="display: none;">
        <p>- OR -</p>
        <a href="#" class="btn btn-block btn-warning">
          <i class="fa fa-facebook mr-2"></i>
          Sign up using Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fa fa-google-plus mr-2"></i>
          Sign up using Google+
        </a>
      </div>

      <a href="login.html" class="text-center" style="display: none;">I already have a membership</a>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->


<!-- Bootstrap 4 -->

<script>
$('#newpasswordid, #confirmpasswordid').on('keyup', function() {
  var pass1=$('#newpasswordid').val();
  var pass2=$('#confirmpasswordid').val();
  if(pass1!="" && pass2!=""){
if ($('#newpasswordid').val() == $('#confirmpasswordid').val()) {
$('#message').html(' Matching').css('color', 'green');
} else
{
$('#message').html(' Not Matching').css('color', 'red');
}
}
});
</script>
<script type="text/javascript">
function showhidepass1() {
var confirmpass = document.getElementById("confirmpasswordid");
if (confirmpass.type === "password" ) {
confirmpass.type = "text";
} else {
confirmpass.type = "password";
}

}

function showhidepass() {
var showpass = document.getElementById("newpasswordid");
if (showpass.type === "password" ) {
showpass.type = "text";
} else {
showpass.type = "password";
}
}
      </script>
</body>
</html>
