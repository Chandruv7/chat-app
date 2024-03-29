<?php
function getDateTimeDiff($date){
 $now_timestamp = strtotime(date('Y-m-d h:i:s'));
 $diff_timestamp = $now_timestamp - strtotime($date);
 
 if($diff_timestamp < 60){
  return 'few seconds ago';
 }
 else if($diff_timestamp>=60 && $diff_timestamp<=120){
  return round($diff_timestamp/60).' min ago';
 }
 else if($diff_timestamp>=60 && $diff_timestamp<3600){
  return round($diff_timestamp/60).' mins ago';
 }
  else if($diff_timestamp>=3600 && $diff_timestamp<=7200){
  return round($diff_timestamp/3600).' hour ago';
 }
 else if($diff_timestamp>=3600 && $diff_timestamp<86400){
  return round($diff_timestamp/3600).' hours ago';
 }
  else if($diff_timestamp>=86400 && $diff_timestamp <=(86400*2)){
  return round($diff_timestamp/(86400)).' day ago';
 }
 else if($diff_timestamp>=86400 && $diff_timestamp<(86400*30)){
  return round($diff_timestamp/(86400)).' days ago';
 }
  else if($diff_timestamp>=(86400*30) && $diff_timestamp<(86400*60)){
  return round($diff_timestamp/(86400*30)).' month ago';
 }
 else if($diff_timestamp>=(86400*30) && $diff_timestamp<(86400*365)){
  return round($diff_timestamp/(86400*30)).' months ago';
 }
 else if($diff_timestamp>=(86400*365) && $diff_timestamp<=(86400*730)){
  return round($diff_timestamp/(86400*365)).' year ago';
 }
 else{
  return round($diff_timestamp/(86400*365)).' years ago';
 }
}
?>