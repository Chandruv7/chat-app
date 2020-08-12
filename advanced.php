<?php 
ob_start();
session_start(); 
include 'configure.php'; 
include 'database/db.php'; 
$connection=new dbconnect;
include 'session.php'; 
include 'myfunctions/fetchnamefromtable.php'; 
$displayname=fetchnamefromtable("17cs05_user_registration","UserID",$userid,"DisplayName",$connection);

?>

<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Gumbling | Advanced</title>
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
$query_message_fetch = "SELECT * from 17cs05_user_settings  where  UserID='$userid' AND CurrentlyActive='1';";
$exec_message_fetch = $connection->connectingdb()->query($query_message_fetch);
if($retrieve_message = mysqli_fetch_array($exec_message_fetch))
{
$feed_fetch=$retrieve_message['NewsFeed'];
$lang_fetch=$retrieve_message['FeedLanguage'];
$abtcon_fetch=$retrieve_message['ShowOthers'];
}
else{
  $feed_fetch="";
  $lang_fetch="";
  $abtcon_fetch="";
}
?>
<body class="hold-transition ">
<div class="wrapper">
  <div class="">
    <section class="content">
      <div class="container-fluid">
      <div class="row">
                  <section class="col-lg-12 connectedSortable " style="padding-left: unset !important;padding-right: unset !important;">
            <div class="card direct-chat direct-chat-warning" style="box-shadow: none;">
              <?php include 'header.php';?>
              <br>
              <div class="col-lg-12" >
                <h5>Advanced Settings</h5>
               
                <form method="post">
                   <div class="col-7" style="float: left;">
        <div class="form-group">
                    <div class="custom-control custom-switch" >
                      <input type="checkbox" class="custom-control-input" onchange="settingsnewsfeed();" id="customSwitch1" name="newsfeedenable" <?php if($feed_fetch=='1'){echo "checked";} ?>>
                      <label class="custom-control-label" for="customSwitch1">Need News Feed</label>
                    </div>
                  </div>
                </div>
              </div>

                 <div class="col-lg-12" id="displaylanguage" style="<?php if($feed_fetch==1){} else{ echo "display: none"; } ?>">
                  <h5>Language</h5>
                  <div class="col-3" style="float: left;">
                  <div class="form-group">
                    <div class="custom-control custom-radio">
                          <input class="custom-control-input" type="radio" id="customRadio2" name="customRadio" onclick="newslanguage('tamil');" <?php if($lang_fetch=='tamil'){ echo "checked";} elseif ($lang_fetch=="") { echo "checked";} ?>>
                          <label for="customRadio2" class="custom-control-label">Tamil</label>
                        </div>
                        
                      </div>
                    </div>
                      <div class="col-3" style="float: left;">
                        <div class="form-group">
                        <div class="custom-control custom-radio">
                          <input class="custom-control-input" type="radio" id="customRadio3" name="customRadio" onclick="newslanguage('english');" <?php if($lang_fetch=='english'){ echo "checked";} ?>>
                          <label for="customRadio3" class="custom-control-label">English</label>
                        </div>
                      </div>
                      </div>
                      </div>
                       <div class="col-lg-12" >
                <h5>Privacy Settings</h5>
               
                <form method="post">
                   <div class="col-12" style="float: left;">
        <div class="form-group">
                    <div class="custom-control custom-switch" >
                      <input type="checkbox" onchange="settingsabtcon();" class="custom-control-input" id="customSwitch2" name="abtcontent" <?php if($abtcon_fetch=='1'){ echo "checked";} ?>>
                      <label class="custom-control-label" for="customSwitch2">Show about content to others</label>
                    </div>
                  </div>
                </div>
                </form>
              </div>
                </form>
                </div>
                </div>
              </section>
      </div>
    </div>
    </section>
  </div>
  <aside class="control-sidebar control-sidebar-dark">
  </aside>
</div>
<script type="text/javascript">
  $('#customSwitch1').change(function () {
    $("#displaylanguage").toggle();
 });

  function settingsnewsfeed()
    {

if(document.getElementById('customSwitch1').checked)
{
var newsval=1;
var newlang="tamil";
}
else
{
  var newsval=0;
}
  $.ajax({
type:"POST",
url: "myfunctions/settingsinsertnews.php",
data:  {
newsfeed: newsval,
newslang: newlang
},
cache: false,
success: function(response1){

}
});
}

  function settingsabtcon()
    {

if(document.getElementById('customSwitch2').checked)
{
var newsval=1;
}
else
{
  var newsval=0;
}
  $.ajax({
type:"POST",
url: "myfunctions/settingsabtcon.php",
data:  {
newsfeed: newsval
},
cache: false,
success: function(response1){

}
});
}

function newslanguage(lang)
{
$.ajax({
type:"POST",
url: "myfunctions/newslang.php",
data:  {
newslanguage: lang,
},
cache: false,
success: function(response2){

}
});
}
</script>
</body>
</html>
