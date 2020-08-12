<?php

function fetchnamefromtable($table,$id,$idvalue,$fetchname,$DB_con)
{
$paycountryname="";
$querypay = "SELECT $fetchname from $table where $id='$idvalue'";
$execpay= $DB_con->connectingdb()->query($querypay);
if ($rowpay = mysqli_fetch_assoc($execpay)) {
	
$paycountryname= $rowpay[$fetchname];
}

return $paycountryname;
}
function fetchnamefromtable1($table,$id,$idvalue,$fetchname,$fetchname1,$DB_con)
{
$querypay = "SELECT $fetchname,$fetchname1 from $table where $id='$idvalue'";
$execpay = $DB_con->connectingdb()->query($querypay) or die ("Error in querypay".mysqli_error($DB_con->connectingdb()));
$rowpay = mysqli_fetch_assoc($execpay);
$paycountryname= $rowpay[$fetchname];
$paycountryname1= $rowpay[$fetchname1];
return $paycountryname." ".$paycountryname1;
}
?>