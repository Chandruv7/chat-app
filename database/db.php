<?php
class dbconnect
{

private $_host;
private $_username;
private $_password;
private $_database; 

public function connectingdb()
{
$this->_host='localhost';
$this->_database='id13159326_gumbling';
$this->_username='id13159326_17cs05';
$this->_password='j8?Lqz$Ph!DJFKpj';


if (!isset($link)) {

$link = new mysqli($this->_host, $this->_username, $this->_password, $this->_database);

if (!$link) {
echo 'You are not connected';
exit;
}	

}	

return $link;
}

}

?>
