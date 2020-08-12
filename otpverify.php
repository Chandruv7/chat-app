<?php
ob_start();
include_once('database/db.php');
include_once('configure.php');
$connection=new dbconnect;
$timenow= date('Y-m-d h:i:s');
include ("myfunctions/fetchnamefromtable.php");
 ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Gumbling V1.0 | OTP Verification</title>
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
<?php 
 if(isset($_GET['msg']) && $_GET['msg']=="failed"){
  echo '<script type="text/javascript">$(document).ready(function(){$("#but_idnew").trigger("click");});</script>';
  echo '<script type="text/javascript">setTimeout(function() {location.replace("otpverify.php");}, 4000);</script>';
}

 if(isset($_GET['otp']) && $_GET['otp']=="failed"){
  echo '<script type="text/javascript">$(document).ready(function(){$("#but_idnew1").trigger("click");});</script>';
  echo '<script type="text/javascript">setTimeout(function() {location.replace("otpverify.php");}, 4000);</script>';
}

 if(isset($_POST['pass_up'])){
extract($_POST);

 $query_message= "SELECT * FROM 17cs05_otpverify where UserID='$useridup' AND CurrentlyActive='1' AND OTPNumber='$otpnum'";
$exec_message= $connection->connectingdb()->query($query_message);
$res_message= mysqli_num_rows($exec_message);
if($res_message==1){

$update_query ="UPDATE `17cs05_otpverify` SET OTPStatus='0',Updator='$useridup',UpdatedDate='$timenow' WHERE UserID='$useridup' AND CurrentlyActive='1' AND OTPNumber='$otpnum' ORDER BY Sno DESC";
$update_execute= $connection->connectingdb()->query($update_query);
header("Location:passwordreset.php?id=".$useridup);
}
else{
header("Location:otpverify.php?otp=failed");
}
}



 ?>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
     <img src="dist/img/gum_logo.png" style="width: 60px;height: 60px;">
    <a ><b>GumblingApp</b> V1.0</a>
  </div>
  <!-- /.login-logo -->
<button id="but_idnew" style="display: none" onclick="emailvalid();"></button>
<button id="but_idnew1" style="display: none" onclick="otpvalid();"></button>
   <div class="card" <?php if(isset($_GET['emailid'])) { echo "style='display: none;'";} ?>>
    <div class="card-body login-card-body">
      <p class="login-box-msg">OTP Verification</p>

      <form method="post" autocomplete="off" action="mail/index.php">
        <div class="form-group has-feedback">
          <input type="text" class="form-control" name="username" placeholder="Username">
        </div>
        <div class="form-group has-feedback">
          <input type="email" class="form-control" name="emailidname" placeholder="EmailID">
        </div>
      
        <div class="row">
          <div class="col-4">
            
           <button type="submit" name="sendotp" class="btn btn-primary btn-block btn-flat">SEND OTP</button>
          </div>
          <div class="col-8">
           
          </div>
           
        </div>
          <!-- /.col -->
         
      </form>
    </div>
    <!-- /.login-card-body -->
  </div>
<?php 
if(isset($_GET['emailid'])){
$emailto=$_GET['emailid'];
$useridnew=fetchnamefromtable("17cs05_user_registration","EmailID",$emailto,"UserID",$connection);
$emailto1=substr($emailto, 0, 3);
$emailto2=substr($emailto,7);
}
else{
  $useridnew="";
}
 ?>

  <div class="card" <?php if(isset($_GET['emailid'])) { echo "style='display: block;'";} else{ echo "style='display: none;'";}?>>
    <div class="card-body login-card-body">
      <p class="login-box-msg">A OTP has been sent to <?php echo $emailto1."****".$emailto2; ?>,<br> Please enter the OTP in the below field to Verify.</p>

      <form method="post" autocomplete="off">
        <div class="form-group has-feedback">
          <input type="text" class="form-control" name="otpnum" placeholder="4 digit Number">
          <input type="hidden" class="form-control" name="useridup" value="<?php echo $useridnew; ?>" placeholder="4 digit Number">
        </div>
      
        <div class="row">
          <div class="col-4">
            
           <button type="submit" name="pass_up" class="btn btn-primary btn-block btn-flat">Verfiy</button>
          </div>
          <div class="col-8">
           
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

function emailvalid(){
toastr.error('Username or EmailID is not found in the database.')
}

function otpvalid(){
toastr.error('Something Went Wrong! Try again.')
}
</script>
</body>
</html>
