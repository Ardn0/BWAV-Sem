<?php
$db = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = fei-sql1.upceucebny.cz)(PORT = 1521)))(CONNECT_DATA=(SID=IDAS)))" ;
$c = oci_connect("st64126","st64126Arch",$db);

if(!$c)
{
    $err = oci_error();
}
