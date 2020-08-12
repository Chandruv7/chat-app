<?php
ob_start();
include ("../database/db.php");
include ("../myfunctions/fetchnamefromtable.php");
include ("../myfunctions/idgen.php");
require("class.phpmailer.php");
$timenow=date("Y-m-d H:i:s");
$connection=new dbconnect;
if(isset($_POST['sendotp'])){

$emailidname=$_POST['emailidname'];
$username=$_POST['username'];

$userid=fetchnamefromtable("17cs05_user_registration","EmailID",$emailidname,"UserID",$connection);
$userid1=fetchnamefromtable("17cs05_user_registration","UserName",$username,"UserID",$connection);
if($userid != $userid1){
header("Location:../otpverify.php?msg=failed");
}
else{
$otpnum=rand(1000,9999);
 $insert_otp_query= "INSERT INTO `17cs05_otpverify`(`UserID`,`UserName`,`OTPNumber`,`Creator`) values('$userid','$username','$otpnum','$userid')";
$insert_execute= $connection->connectingdb()->query($insert_otp_query);

$mail = new PHPMailer();
$mail->IsSMTP();
$mail->SMTPDebug = 1;
$mail->Host = "smtp.gmail.com";
$mail->SMTPAuth = true;
$mail->SMTPSecure = "tls";
$mail->Port = 587;
$mail->Username = "gumbling7@gmail.com";
$mail->Password = "gumbling7account7";
$mail->From = "gumbling7@gmail.com";
$mail->FromName = "GUMBLING APP";
$mail->AddAddress($emailidname);
$mail->IsHTML(true);
$mail->Body = "Use this four digit number ".$otpnum." to reset your password";
$mail->Subject = "Password Reset";
$mail->Send();

header("Location:../otpverify.php?emailid=".$emailidname);
}
}
?>