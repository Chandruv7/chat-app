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
$dpname=fetchnamefromtable("17cs05_user_registration","UserID",$userid,"DisplayName",$connection);

$frnds=array();
$frnds1=array();
 $query_frnd= "SELECT * FROM 17cs05_friendrequest where CurrentlyActive='1' AND RequestStatus='2' AND (RequestTo='$userid' OR RequestFrom='$userid') ";
$exec_frnd_fetch = $connection->connectingdb()->query($query_frnd);
$res_frndscount= mysqli_num_rows($exec_frnd_fetch);
while($retrieve_message = mysqli_fetch_array($exec_frnd_fetch))
{
$frnds[]=$retrieve_message['RequestFrom'];
$frnds1[]=$retrieve_message['RequestTo'];
}

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
<div class="wrapper">
  <div class="">
    <section class="content">
      <div class="container-fluid">
        <div class="row">
<button id="but_idnew" style="display: none" onclick="usersuccess('<?php echo $dpname ?>');"></button>
<button id="but_id1" style="display: none" onclick="messagevalid();"></button>
          <section class="col-lg-12 connectedSortable " style="padding-left: unset !important;padding-right: unset !important;">
            <div class="card direct-chat direct-chat-warning" style="height: 700px;">
              <?php include 'header.php'; 
                  if(isset($_GET['msg']) && $_GET['msg']=="usercame"){
  echo '<script type="text/javascript">$(document).ready(function(){$("#but_idnew").trigger("click");});</script>';
  echo '<script type="text/javascript">setTimeout(function() {location.replace("groupchat.php");}, 2000);</script>';
}?>

              <div class="card-body">
                <div class="direct-chat-messages" style="height: 570px;background-image: url('dist/img/boxed-bg.jpg');" id="your_div">
                  <?php if($res_frndscount==0){
  echo "<center style='background:#FAFAD2;border-radius:50%;'><h6>You have no friends to chat!</h6></center>";

} ?>
                  <?php
                 $frndschat= implode(",",$frnds);
                 
                    $query_message_fetch1 = "SELECT * FROM 17cs05_friendrequest  WHERE RequestStatus='2' AND (`RequestFrom`='$userid' OR `RequestTo`='$userid')";
                    $exec_message_fetch1 = $connection->connectingdb()->query($query_message_fetch1);
                    if($retrieve_message1 = mysqli_fetch_assoc($exec_message_fetch1))
                    {
                    $UpdatedDate=$retrieve_message1['UpdatedDate'];
                    $query_message_fetch = "SELECT * FROM 17cs05_user_chatmessage  WHERE CurrentlyActive='1' AND `ChatMessageTime`>'$UpdatedDate' ORDER BY ChatMessageTime ASC";
                    $exec_message_fetch = $connection->connectingdb()->query($query_message_fetch);
                    while($retrieve_message = mysqli_fetch_assoc($exec_message_fetch))
                    {
                        
                    
                        $userid_fetch=$retrieve_message['UserID'];
                        if (in_array($userid_fetch,$frnds) || $userid_fetch==$userid || in_array($userid_fetch,$frnds1))
                        {
                        $messageid_fetch=$retrieve_message['ChatMessageID'];
                        $message_fetch=$retrieve_message['ChatMessage'];
                        $messagetime_fetch=$retrieve_message['ChatMessageTime'];
                        $messagetime_fetch = date("d M h:i a", strtotime($messagetime_fetch));

                        $displayname=fetchnamefromtable("17cs05_user_registration","UserID",$userid_fetch,"DisplayName",$connection);
                        $userimg_fetch=fetchnamefromtable("17cs05_user_registration","UserID",$userid_fetch,"DisplayPicture",$connection);
                        if($userimg_fetch==""){
                          $userimg_fetch="avatar.png";
                        }
                        }
                        else
                        {
                        continue;
                        }

                      ?>

                  <div class="direct-chat-msg <?php if($userid_fetch==$userid){echo 'right';} ?>">
                    <div class="direct-chat-info clearfix"> 
                      <span class="direct-chat-name float-left"><?php echo $displayname; ?></span>
                      <span class="direct-chat-timestamp float-right"><?php echo $messagetime_fetch; ?></span>
                    </div>
                    <img class="direct-chat-img" src="dist/img/<?php echo $userimg_fetch; ?>" alt="message user image">
                    <div class="direct-chat-text">
                      <?php echo $message_fetch; ?>
                  </div>
                </div>
                <?php 
                }
              }
                 ?>

                </div>
                
              </div>
              <div class="card-footer">
                
                <form method="POST" autocomplete="off" id="cform">
                  <div class="input-group" >
                    <input type="text" name="messagename" id="mes_ins" placeholder="Type Message ..." class="form-control" required="">
                    <span class="input-group-append">
                      <button id="sendsms" type="button" name="sendmessage" onclick="newmessageinsert();" class="btn btn-warning">Send</button>
                    </span>
                  </div>
                </form>
              </div>
            </div>
          </section>
        </div>
      </div>
    </section>
   
  </div>

<script type="text/javascript">
function newmessage()
    {

    /* var audio = new Audio('definite.mp3');
audio.play();*/
  $.ajax({
url: "myfunctions/newmessageload.php",
cache: false,
success: function(response){
 $('#your_div').html(response);

}
});
}
window.setInterval(function(){
 newmessage();
}, 5000);


function newmessageinsert()
    {
var mes=document.getElementById("mes_ins").value;
if(mes!=""){
  $.ajax({

type:"POST",
url: "myfunctions/messageinsert.php",
data:  {
messagename: $("#mes_ins").val()
},
cache: false,
success: function(response1){
document.getElementById("cform").reset();
}
});
}
else{
  messageempty();
}
}




function messagevalid(){
toastr.error('Oops! Message Not Sent')
}
function messageempty(){
toastr.error('Empty message cannot be sent')
}
    function usersuccess(displayname){
toastr.success('Welcome, ' +displayname+' !')
}
function Scrolldown() {
     var objDiv = document.getElementById("your_div");
objDiv.scrollTop = objDiv.scrollHeight;
}
window.onload = Scrolldown;


var wage = document.getElementById("mes_ins");
wage.addEventListener("keydown", function (e) {
    if (e.keyCode === 13) {  //checks whether the pressed key is "Enter"
        newmessageinsert();
    }
});
</script>
</body>
</html>
