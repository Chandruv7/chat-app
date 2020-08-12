<?php
ob_start();
include_once('database/db.php');
include_once('configure.php');
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
      <p class="login-box-msg">Login in to Connect with people</p>

      <form method="post" autocomplete="off">
        <div class="form-group has-feedback">
          <input type="text" class="form-control" name="mobilego" placeholder="Mobile Number">
          <span class="fa fa-phone form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <input type="password" name="passwordgo" id="showthispass" class="form-control" placeholder="*******">
          <span class="fa fa-lock form-control-feedback"></span>&nbsp;&nbsp; <span class="fa fa-eye form-control-feedback text-primary" style="cursor: pointer;" onclick="showhidepass();"></span>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="checkbox icheck">
              <label>
                <input type="checkbox"> Remember Me
              </label>
            </div>
          </div>
           <div class="col-4">
           <button type="submit" name="logingo" class="btn btn-primary btn-block btn-flat">Lets Go</button></a>
          </div>
        </div>
          <!-- /.col -->
         
      </form>

      <div class="social-auth-links text-center mb-3" style="display: none;">
        <button id="but_id" onclick="userinvalid();" style="display: none;"></button>
        <p>- OR -</p>
        <a href="#" class="btn btn-block btn-primary">
          <i class="fa fa-facebook mr-2"></i> Sign in using Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fa fa-google-plus mr-2"></i> Sign in using Google+
        </a>
      </div>
      <!-- /.social-auth-links -->
<br>
      <p class="mb-1" style="">
        Dont have an Account? <a href="register.php"> &nbsp;Sign Up </a>
      </p>
      <p class="mb-0" >
        <a href="otpverify.php" class="text-center">Forget Password?</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->
<?php
session_start();
if(isset($_SESSION['login_user']))
{
header("location:groupchat.php"); 
}

if(isset($_POST['logingo']))
{ 
$connection=new dbconnect;  
$mobileno=$_POST['mobilego'];
$password=$_POST["passwordgo"];
$passwordsha=sha1($password);
$query ="SELECT * from 17cs05_user_registration where Password='$passwordsha' AND MobileNo='$mobileno' AND CurrentlyActive='1'";
$rows= $connection->connectingdb()->query($query);
$queryrowcount= mysqli_num_rows($rows);
if($queryrowcount==1)
{
$queryres= mysqli_fetch_assoc($rows);
$useridtbl= $queryres['UserID'];
$usernametbl= $queryres['UserName'];
$emailtbl =$queryres['EmailID'];
$mobiletbl =$queryres['MobileNo'];
$passwordtbl= $queryres['Password'];
}
else{
$queryres= mysqli_fetch_assoc($rows);
$useridtbl= $queryres['UserID'];
$usernametbl= $queryres['UserName'];
$emailtbl =$queryres['EmailID'];
$mobiletbl =$queryres['MobileNo'];
$passwordtbl= $queryres['Password'];
}
if($mobileno==$mobiletbl && $passwordsha==$passwordtbl){
  date_default_timezone_set('Asia/Calcutta'); 
$timenow= date('Y-m-d h:i:s'); 
$update_query ="UPDATE `17cs05_user_registration` SET Status='online',Updator='$useridtbl',UpdatedDate='$timenow' WHERE  UserID='$useridtbl' AND CurrentlyActive='1'";
$update_execute= $connection->connectingdb()->query($update_query);
$_SESSION['login_userid']=$useridtbl;
$_SESSION['login_user']=$usernametbl;

setcookie("login_userid", "$useridtbl", time()+84600,'/');
setcookie("login_user", "$usernametbl", time()+84600,'/');
header("location:groupchat.php?msg=usercame"); 
}
else{
  echo '<script type="text/javascript">$(document).ready(function(){$("#but_id").trigger("click");});</script>';
}
}
?>
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
}
</script>
</body>
</html>
