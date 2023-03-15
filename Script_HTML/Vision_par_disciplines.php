<!DOCTYPE html>

<html>

<head>

    <meta charset="utf-8">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="./Styles/Vision_par_disciplines.css" rel="stylesheet" type = "text/css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link rel="shortcut icon" href="../Images/Anneaux/officiel.png" type="image/png">

  <style>
    html{
    background-color: #F5F5F5;
    }
    body{
     background-color: #F5F5F5;
    }
    </style>

    <title>  Vision disicpline   </title>

</head>



<body  class="d-flex flex-column">

    <object data="Barre_de_navigation.html" width="100%" height="100%">
    </object>
	
<div  class = "container" >


        <h1>  Comparons par  <span><strong>  disciplines </strong></span></h1>
        <br>
        <br>
    <table>
        <tr>
    <?php require("fonction.php");
                $bdd = getBDD();
                $disc = $bdd->query('SELECT id_discipline FROM `disciplines` WHERE nom_discipline IN ("Athletics", "Speed Skating", "Weightlifting", "Shooting","Cycling","Short Track Speed Skating","Swimming","Archery") ORDER BY FIELD(nom_discipline, "Athletics", "Speed Skating", "Weightlifting", "Shooting","Cycling","Short Track Speed Skating","Swimming","Archery"); ');
        $ligne1 = $disc -> fetch();  
        echo "<td class = 'celtop'> <a href = 'record_particulier.php?id=".$ligne1[0]."' > <button> Athl&eacute;tisme</button></a></td>";
        $ligne2 = $disc -> fetch();
       echo "<td class = 'celtop'> <a href = 'record_particulier.php?id=".$ligne2[0]."'  > <button> Patinage de vitesse</button></a></td>";
      $ligne3 = $disc -> fetch();
      echo "<td class = 'celtop'> <a href = 'record_particulier.php?id=".$ligne3[0]."'  > <button> Halt&eacute;rophilie</button></a></td>";
       $ligne14 = $disc -> fetch();
       echo "<td class = 'celtop'> <a href = 'record_particulier.php?id=".$ligne4[0]."'  > <button> Tir </button></a></td>";
        echo "</tr>";
    
       echo "<tr>";
     $ligne5 = $disc -> fetch();
       echo "<td class = 'celtop'> <a href = 'record_particulier.php?id=".$ligne5[0]."'  > <button> Cyclisme </button></a></td>";
       $ligne6 = $disc -> fetch();
        echo "<td class = 'celtop'> <a href = 'record_particulier.php?id=".$ligne6[0]."'  > <button> Short-Track</button></a></td>";
      $ligne7 = $disc -> fetch();
        echo "<td class = 'celtop'> <a href = 'record_particulier.php?id=".$ligne7[0]."'  > <button> Natation </button></a></td>";
       $ligne8 = $disc -> fetch():
      echo "<td class = 'celtop'> <a href = 'record_particulier.php?id=".$ligne8[0]."'  > <button> Tir &agrave; l&rsquo;Arc</button></a></td>";
                  
    ?>   
        </tr>
    </table>
    </div>





</body>

<footer >

    <object data="pied_de_page.html" width="100%" height="100%">
    </object>
  </footer>


</html>
