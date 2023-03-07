<?php
function getBDD(){
$bdd = new PDO('mysql:host=localhost;dbname=jo;charset=utf8','root', 'root');
return $bdd;

}

?>