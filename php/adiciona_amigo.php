<?php

   require_once '../vars/connectvars.php';
      
   session_start();
   if(!isset($_SESSION['meu_id']) && !isset($_SESSION['meu_nome'])) {
      echo "Você precisa logar para acessar essa página!";
      echo "<br /><a href='../index.html'>Login</a>";
   }
   else {
      $meu_id = $_SESSION['meu_id'];
   }
   $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die("Erro ao conectar na base de dados.");
   $url = $_GET['perfil'];
   $query = "UPDATE amizades SET confirmado = 1 WHERE solicitado_id = $meu_id AND solicitante_id = (SELECT id FROM usuarios WHERE url = '$url')";
   if(mysqli_query($dbc, $query)) {
      echo '<script>alert("Amizade confirmada com sucesso!");</script>';  
   }
   else {
      echo '<script>Solicitação de amizade não foi confirmada!</script>';
      echo '<script>window.history.go(-1);</script>';
   }

?>

<html>   
   <head> 
      <title>Rede Social - Adiciona Amigo</title>
      <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
      <meta http-equiv="refresh" content="5; url=inicial.php"> 
   </head>
   
   <body>
      <h1>Redirecionando...</h1>
      <h1>Aguarde por favor...</h1>      
   <body>
   
</html>
