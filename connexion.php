<?php
  $dbhost = 'tuxa.sme.utc';
  $dbuser = 'nf92a068';

  $dbpass = 'X3Xqi3KOp7Ec';

  $dbname = 'nf92a068';

  $connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');
  //la ligne suivante permet d'éviter les problèmes d'accent entre la page ouèbe et le serveur mysql
  mysqli_set_charset($connect, 'utf8'); //les données envoyées vers mysql sont encodées en UTF-8
 ?>
