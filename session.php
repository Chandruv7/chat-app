<?php
if(isset($_SESSION['login_user']))
{
$name=$_SESSION['login_user'];
$userid=$_SESSION['login_userid'];
$_COOKIE['login_user']=$name;
$_COOKIE['login_userid']=$userid;
}
elseif(isset($_COOKIE['login_user']))
{
$name=$_COOKIE['login_user'];
$userid=$_COOKIE['login_userid'];
$_SESSION['login_user']=$name;
$_SESSION['login_userid']=$userid;
}
else{
header("location:index.php"); 
}	
date_default_timezone_set('Asia/Calcutta'); 
 $timenow= date('Y-m-d H:i:s');	
?>

<script type="text/javascript">
	 $(window).bind("beforeunload", function () {
                alert();

            })
</script>