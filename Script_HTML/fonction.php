<?php
function getBDD(){
$bdd = new PDO('mysql:host=localhost:3306; dbname=jo; charset= utf8', 'root', 'root');
return $bdd;

}

?>