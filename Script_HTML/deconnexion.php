<!DOCTYPE html>
<html lang='fr'>
  <head>
	<?php
		session_start();
		session_unset();
		session_destroy();
		header('Location: index.php');
		exit();
	?>
  </head>
  <body>
  </body>
</html>


