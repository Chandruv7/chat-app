<?php
ob_start();
$userid=$_SESSION['login_userid'];
$query_online = "SELECT count(Sno) as countuser from 17cs05_user_registration  where  CurrentlyActive='1' AND UserID<>'$userid' AND Status='online'";
$exec_online = $connection->connectingdb()->query($query_online);
if($retrieve = mysqli_fetch_array($exec_online))
{
  $countvalue=$retrieve['countuser'];
}
?>
<?php
$directoryURI = $_SERVER['REQUEST_URI'];
$path = parse_url($directoryURI, PHP_URL_PATH);
$components = explode('/', $path);
$first_part = $components[1];
?>

<div class="card-header">
              <a href="index.php" style="color: #333;">  <h3 class="card-title" ><img src="dist/img/gum_logo.png" style="width: 30px;height: 30px;cursor: pointer;">Group Chat</a></h3>

                <div class="card-tools">
                  <span data-toggle="tooltip" class="badge badge-success"><?php echo $countvalue; ?></span>
                  <a href="onlineusers.php"><button type="button" class="btn btn-tool"  data-toggle="tooltip" title="Users">
                    <i class="fa fa-users" style="<?php if ($first_part=="onlineusers.php") {echo "color:#333;"; } else  {}?>"></i>
                  </button></a>
                  
                  <a href="groupchat.php"><button type="button" class="btn btn-tool" data-toggle="tooltip" title="Chat Area">
                    <i class="fa fa-comments" style="<?php if ($first_part=="groupchat.php") {echo "color:#333;"; } else  {}?>"></i>
                  </button></a>
                  <button style="display: none;" type="button" class="btn btn-tool" data-toggle="tooltip" title="Contacts" data-widget="chat-pane-toggle">
                    <i class="fas fa-comments"></i></button>
                    <?php $news_fetch=fetchnamefromtable("17cs05_user_settings","UserID",$userid,"NewsFeed",$connection); ?>
                  <button  style="<?php  if($news_fetch=='1'){} else{ echo 'display: none;';} ?>" type="button" onclick="window.location=('newsfeed.php');" class="btn btn-tool" data-toggle="tooltip" title="News Feed" data-widget="chat-pane-toggle">
                    <i class="fa fa-newspaper-o"  style="<?php if ($first_part=="newsfeed.php") {echo "color:#333;"; } else  {}?>"></i>
                  </button>
                  <div class="btn-group">
                    <button type="button" class="btn btn-tool" data-toggle="dropdown" aria-expanded="true" data-toggle="tooltip" title="Logout">
                      <i class="fa fa-sign-out"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right " role="menu">
                      <a href="logout.php" class="dropdown-item">Logout</a>
                    </div>
                  </div>
                  <div class="btn-group">
                    <button type="button" class="btn btn-tool" data-toggle="dropdown" aria-expanded="true" data-toggle="tooltip" title="Logout">
                      <i class="fa fa-gear"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right " >
                      <a href="userprofile.php" class="dropdown-item">User Profile</a>
                      <a href="advanced.php" class="dropdown-item">Advanced</a>
                      
                     
                    </div>
                  </div>
                </div>
              </div>
