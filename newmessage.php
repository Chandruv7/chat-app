<?php 
ob_start();
session_start(); 
include 'configure.php'; 
include 'database/db.php'; 
include 'myfunctions/idgen.php'; 
$connection=new dbconnect;
include 'session.php'; 
include 'myfunctions/fetchnamefromtable.php'; 
$username=fetchnamefromtable("17cs05_user_registration","UserID",$userid,"UserName",$connection);

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
  <link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="plugins/toastr/toastr.min.css">
  <!-- Font Awesome -->
 
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/iCheck/flat/blue.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="plugins/morris/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="plugins/jvectormap/jquery-jvectormap-1.2.2.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker-bs3.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

</head>
  <?php 

if (isset($_POST["sendmessage"]))
{
extract($_POST);
$messageid = idgeneration('ChatMessageID','17cs05_user_chatmessage','UCM');
 $query_message= "SELECT * FROM 17cs05_user_chatmessage where CurrentlyActive='1' AND ChatMessageID='$messageid'";
$exec_message= $connection->connectingdb()->query($query_message);
$res_message= mysqli_num_rows($exec_message);
if($res_message==0){
 $insert_message_query= "INSERT INTO `17cs05_user_chatmessage`(`UserID`,`UserName`,`ChatMessageID`,`ChatMessage`,`ChatMessageTime`,`Creator`) values('$userid','$username','$messageid','$messagename','$timenow','$userid')";
$insert_exec=$connection->connectingdb()->query($insert_message_query);
header("Location:groupchat.php");
}
else{
  echo '<script type="text/javascript">$(document).ready(function(){$("#but_id1").trigger("click");});</script>';
}
}
 ?>
<body class="hold-transition ">

                  <?php
                    $query_message_fetch = "SELECT * from 17cs05_user_chatmessage  where  CurrentlyActive='1' ORDER BY ChatMessageTime ASC";
                    $exec_message_fetch = $connection->connectingdb()->query($query_message_fetch);
                    while($retrieve_message = mysqli_fetch_array($exec_message_fetch))
                    {
                      $messageid_fetch=$retrieve_message['ChatMessageID'];
                      $message_fetch=$retrieve_message['ChatMessage'];
                      $messagetime_fetch=$retrieve_message['ChatMessageTime'];
                      $messagetime_fetch = date("d M h:i p", strtotime($messagetime_fetch));
                      $userid_fetch=$retrieve_message['UserID'];
                      $displayname=fetchnamefromtable("17cs05_user_registration","UserID",$userid_fetch,"DisplayName",$connection);
                      $userimg_fetch=fetchnamefromtable("17cs05_user_registration","UserID",$userid_fetch,"DisplayPicture",$connection);
                    
                      ?>

                  <div class="direct-chat-msg <?php if($userid_fetch==$userid){echo 'right';} ?>">
                    <div class="direct-chat-info clearfix"> 
                      <span class="direct-chat-name float-left"><?php echo $displayname; ?></span>
                      <span class="direct-chat-timestamp float-right"><?php echo $messagetime_fetch; ?></span>
                    </div>
                    <img class="direct-chat-img" src="dist/img/user1-128x128.jpg" alt="message user image">
                    <div class="direct-chat-text">
                      <?php echo $message_fetch; ?>
                  </div>
                </div>
                <?php 
                }
                 ?>
                
<button id="but_idnew" onclick="messagevalid();" style="display: none;"></button>
<button id="but_id1" onclick="usersuccess('<?php echo ucfirst($displayname); ?>');" style="display: none;"></button>
                </div>
             
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- SweetAlert2 -->
<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="plugins/toastr/toastr.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Morris.js charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="plugins/morris/morris.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/knob/jquery.knob.js"></script>
<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>

<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>

<script type="text/javascript">

function Scrolldown() {
     window.scroll(500,1500); 
}
window.onload = Scrolldown;
</script>
</body>
</html>
