<!DOCTYPE html>
<html>
<link rel="stylesheet" href="themes.css">
<head>
	<meta charset="utf-8"/>
</head>

<body>
	<titres>Visualiser le calendrier d'un élève</titres></br></br>
	<?php
		include ('connexion.php');
		$table_eleves = mysqli_query($connect,"SELECT * FROM eleves ORDER by nom");	 // Requête pour sélectionner tous les élèves
    if (!$table_eleves) {
      echo "Impossible d'afficher la liste de tous les élèves. Requête invalide. <br>". mysqli_error($connect);
    }

		echo "<table>";

		//Formulaire pour sélectionner un élève

		echo "<FORM METHOD='POST' ACTION='visualiser_calendrier_eleve.php'>";
		echo "<tr><td><subtitles>Choix de l'élève :</subtitles></td><td><select name='eleve' BORDER='1'>";

		while ($eleve = mysqli_fetch_array($table_eleves, MYSQLI_ASSOC))
		{
			echo "<option value=".$eleve['ideleve'].">".$eleve['nom']." ".$eleve['prenom']."</option>";
      echo "<br>";
		}

		echo "<tr><td><br><INPUT type='submit' value='Valider'></td></tr>";

		echo "</FORM>";

		echo "</table>";

		mysqli_close($connect);
	?>


</body>
</html>
