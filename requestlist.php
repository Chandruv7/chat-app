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
<title>Gumbling V1.0 | User Profile</title>
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
function userupdate(){
toastr.error('Request Rejected !')
}
function userupdate1(){
toastr.success('Request Accepted !')
}

</script>
<style type="text/css">
	.table td, .table th {
    padding: .75rem;
    vertical-align: top;
    border-top: unset;
}
@media only screen and (max-width: 600px) {
img[src="https://cdn.000webhost.com/000webhost/logo/footer-powered-by-000webhost-white2.png"]{
    display:none !important;
}
}

</style>
</head>
<body class="hold-transition ">
<div class="wrapper">
<div class="">
<section class="content">
<div class="container-fluid">
<div class="row">
<section class="col-lg-12 connectedSortable " style="padding-left: unset !important;padding-right: unset !important;">
<div class="card direct-chat direct-chat-warning" style="height: 690px;box-shadow: unset;">
<?php include 'header.php'; ?>
<div class="card-body">
<div class="card card-widget widget-user">
<!-- Add the bg color to the header using any of the bg-* classes -->
<!-- /.col -->
<div class="row">

<div class="col-12">
<div class="col-12">
<div class="col-12" id="frndreq">
<table class="table " style="height: 10px;overflow-y:scroll;">
                  <thead>                  
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Request List</th>
                      <th>Accept</th>
                      <th style="width: 40px">Reject</th>
                    </tr>
                  </thead>
                  <tbody >
                  	<?php 
                  	$frnd=0;
                  	$qry_friend = "SELECT * from 17cs05_friendrequest  where  CurrentlyActive='1' AND RequestStatus='1' AND RequestTo='$userid'";
$exec_frnd = $connection->connectingdb()->query($qry_friend);
$req_count= mysqli_num_rows($exec_frnd);

while($retfrnd = mysqli_fetch_array($exec_frnd))
{
	$frnd_fetch=$retfrnd['RequestFrom'];
$frnd_fetch_name=fetchnamefromtable("17cs05_user_registration","UserID",$frnd_fetch,"DisplayName",$connection);
$frnd++;


	?>
                    <tr>
                      <td><?php echo $frnd; ?></td>
                      <td><?php echo $frnd_fetch_name; ?></td>
                      <td>&nbsp;&nbsp;<span class="badge bg-success" style="cursor: pointer;" onclick="reqacpt('2','<?php echo $frnd_fetch; ?>');userupdate1();"><i class="fa fa-check" style="color: #fff;"></i></span></td>
                      <td>&nbsp;&nbsp;<span class="badge bg-danger" style="cursor: pointer;"  onclick="reqacpt('3','<?php echo $frnd_fetch; ?>');userupdate();"><i class="fa fa-close" style="color: #fff;"></i></span></td>
                    </tr>

                <?php } ?>
                  </tbody>

                </table>
                <?php if($req_count==0){
  echo "<center><h4>No Friend request found <i class='fa fa-frown-o'></i></h4></center>";

} ?>
            </div>
            </div>
            </div>
            </div>


</div>
</div>
</div>
</section>
</div>
</div>
</section>
</div>
</div>

<script type="text/javascript">
  
  function reqacpt(reqval,userval)
{
$.ajax({
type:"POST",
url: "myfunctions/requestaccept.php",
data:  {
reqname: reqval,
friendname: userval
},
cache: false,
success: function(response1){
$("#frndreq").html(response1);
}
});
}
</script>
<!--       <script type="text/javascript">
$(document).ready(function () {
$("#customFile").on('change',(function() {

var imageval=$("#customFile").val();
$.ajax({
url: "uploaddp.php",
type: "POST",
data: new FormData() ,
contentType: false,
cache: false,
processData:false,
success: function(data)
{
alert(data);
$("#filehide").val(data);
},
error: function() 
{
}           
});
}));
});
</script> -->
</body>
</html>
