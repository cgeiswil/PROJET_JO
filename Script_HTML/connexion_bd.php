<?php
function getBD(){
$bdd = new PDO('mysql:host=localhost;dbname=jo;charset=utf8','root','root');
return $bdd;
}
?>