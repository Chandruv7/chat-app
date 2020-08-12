 <?php
ob_start();
include '../configure.php'; 
include '../database/db.php'; 
include '../myfunctions/idgen.php'; 
$connection=new dbconnect;
include '../session.php'; 
include '../myfunctions/fetchnamefromtable.php'; 
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

   <?php if($res_frndscount==0){
  echo "<center style='background:#FAFAD2;border-radius:50%;'><h6>You have no friends to chat!</h6></center>";

} ?>

  <?php
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
                          $userimg_fetch="user.jpg";
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
                    <img  class="direct-chat-img" src="dist/img/<?php echo $userimg_fetch; ?>" alt="message user image">
                    <div class="direct-chat-text">
                      <?php echo $message_fetch; ?>
                  </div>
                </div>
                <?php 
                }
              }
                 ?>