<?php
if(isset($_FILES['customFile']['tmp_name'])) {
$sourcePath = $_FILES['customFile']['tmp_name'];
$targetPath = "dist/img/".$_FILES['customFile']['name'];
move_uploaded_file($sourcePath,$targetPath);
echo $_FILES['customFile']['name'];
}

?>