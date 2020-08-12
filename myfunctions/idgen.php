<?php

//include("../../database/db.php");
function idgeneration($id1,$table,$str)
{
$id=$id1;
$query11 = "select $id from $table order by $id desc limit 0, 1";
$DB_con= new dbconnect();
$exec11 = $DB_con->connectingdb()->query($query11);
$rowcount1 = mysqli_num_rows($exec11);
if ($rowcount1 == 0)
{
$retid = $str.'00000001';
}
else
{
$res11 = mysqli_fetch_array($exec11);
$res1companycode = $res11[$id];
$retid = random_id($res1companycode,"$str");
}
return $retid;
}

function random_id($id,$str)
{
	$pocode1 = substr($id, 4, 8);
	$pocode1 = intval($pocode1);
	$pocode1 = $pocode1 + 1;
	$maxanum = $pocode1;
	if (strlen($maxanum) == 1)
	{
		$maxanum1 = '0000000'.$maxanum;
	}
	else if (strlen($maxanum) == 2)
	{
		$maxanum1 = '000000'.$maxanum;
	}
	else if (strlen($maxanum) == 3)
	{
		$maxanum1 = '00000'.$maxanum;
	}
	else if (strlen($maxanum) == 4)
	{
		$maxanum1 = '0000'.$maxanum;
	}
	else if (strlen($maxanum) == 5)
	{
		$maxanum1 = '000'.$maxanum;
	}
	else if (strlen($maxanum) == 6)
	{
		$maxanum1 = '00'.$maxanum;
	}
	else if (strlen($maxanum) == 7)
	{
		$maxanum1 = '0'.$maxanum;
	}
	else if (strlen($maxanum) == 8)
	{
		$maxanum1 = $maxanum;
	}
	
	$pocode1 = $str.$maxanum1;

	return $pocode1;
	}



	function rand_string($length,$str) 
{
	$strandomid="";
	$chars = "012346715561061557890422436264628012201826142189342342344308049095001550979247933096581305189366768324557908725604353";  
	$size = strlen( $chars );
	for( $i = 0; $i < $length; $i++ ) 
	{
	$strandomid.= $chars[rand( 0, $size - 1 ) ];
	}
	return $str.$strandomid;
}

?>