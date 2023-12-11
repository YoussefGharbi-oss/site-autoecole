<!DOCTYPE html>
<html>
<link rel="stylesheet" href="themes.css">
<head>
	<meta charset="utf-8"/>
</head>

<body>
	<title>Supprimer une séance</title></br></br></br>

	<?php

		$id_eleve=$_POST['eleve'];
		$id_seance=$_POST['seance'];

    include ('connexion.php');

		$detail_insc_query = mysqli_query($connect,"SELECT * FROM inscription WHERE ideleve = $id_eleve and idseance = $id_seance"); //requête pour obtenir la ligne correspondant à l'élève et la séance choisie
		$detail_insc = mysqli_fetch_array($detail_insc_query, MYSQLI_ASSOC);

		$detail_eleve_query = mysqli_query($connect,"SELECT * FROM eleves WHERE ideleve = $id_eleve"); //Requête pour avoir les infos de l'élève choisi
		$detail_eleve = mysqli_fetch_array($detail_eleve_query, MYSQLI_ASSOC);

		$detail_seance_query = mysqli_query($connect,"SELECT * FROM seance WHERE idseance = $id_seance"); //Requête pour avoir les infos de la séance choisie
		$detail_seance = mysqli_fetch_array($detail_seance_query, MYSQLI_ASSOC);

		$detail_theme_query = mysqli_query($connect,"SELECT * FROM themes WHERE idtheme = $detail_seance['Idtheme']");//Requête pour avoir le thème de la séance choisie
		$detail_theme = mysqli_fetch_array($detail_theme_query, MYSQLI_ASSOC);

		if (mysqli_num_rows($detail_insc)){
		$desinscription = mysqli_query($connect,"DELETE FROM `inscription` WHERE idseance = $id_seance and ideleve = $id_eleve"); // Si l'élève est bien inscrit à la séance on le désinscrit

		//Affichage du récapitulatif

		echo "<subtitle>Confirmation de la désinscription de $detail_eleve['prenom'] $detail_eleve['nom'] de la séance de $detail_theme['nom'] du $detail_seance['DateSeance'].</subtitle></br></br></br>";

		echo "<corps>Retour automatique vers l'accueil ... <corps>";
		echo "<META HTTP-EQUIV='refresh' CONTENT=5;URL='accueil.html'>";
		}
		else
		{
			echo "<subtitle>L'élève $detail_eleve['prenom'] $detail_eleve['nom'] n'est pas inscrit dans la séance de $detail_theme['nom'] du $detail_seance['DateSeance'].</subtitle></br></br></br>";
		}
	?>




</body>
</html>
