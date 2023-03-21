<?php
function getBDD(){
	$bdd = new PDO('mysql:host=localhost;dbname=jo;charset=utf8','root', 'root');
	return $bdd;
}

function translate($expression){
	$url = 'https://api.mymemory.translated.net/get?q=' . urlencode($expression) . '&langpair=fr|en';
	$response = file_get_contents($url);
	$result = json_decode($response, true);
	$translation = $result['responseData']['translatedText'];
	return $translation;
}
?>