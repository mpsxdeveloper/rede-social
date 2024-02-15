<?php
   
   require_once('../vars/appvars.php');
   require_once('../vars/connectvars.php');
   echo '<div id="meus_amigos">';
   if(!isset($_SESSION['meu_id']) && !isset($_SESSION['meu_nome'])) {
      echo "Você precisa logar para acessar essa página!";
      echo "<br /><a href='../index.html'>Login</a>";
      exit();
   }
   else {
      $meu_id = $_SESSION['meu_id'];
      $meu_nome = $_SESSION['meu_nome'];
      $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die("Erro ao conectar na base de dados.");
      $query = "SELECT usuarios.url, usuarios.nome, usuarios.sobrenome, fotos.screenshot FROM usuarios, fotos, amizades WHERE (usuarios.id <> $meu_id AND amizades.solicitante_id = $meu_id AND usuarios.id = amizades.solicitado_id AND confirmado = 1 AND fotos.usuario_id = solicitado_id) ";
      $query2 = "SELECT usuarios.url, usuarios.nome, usuarios.sobrenome, fotos.screenshot FROM usuarios, fotos, amizades WHERE (usuarios.id <> $meu_id AND amizades.solicitante_id = usuarios.id AND $meu_id = amizades.solicitado_id AND confirmado = 1 AND fotos.usuario_id = solicitante_id) ";      
      $result = mysqli_query($dbc, $query);
      $result2 = mysqli_query($dbc, $query2);
      echo '<form>';
      echo '<table>';
      echo '<tr style="background-color: #add8e6;">';
      while($row = mysqli_fetch_array($result)) {
         echo '<td>'; 
         echo '<span><img src="' . REDESOCIAL_CAMINHO . $row['screenshot'] . '" alt="Foto do perfil" width="70" height="70" /></span><br />';
         echo '<a href="profile.php?perfil=' . $row['url'] . '">';
         echo $row['nome'] . ' ' . $row['sobrenome'];
         echo '</a>';
         echo '</td>';
      }
      while($row = mysqli_fetch_array($result2)) {
         echo '<td>'; 
         echo '<span><img src="' . REDESOCIAL_CAMINHO . $row['screenshot'] . '" alt="Foto do perfil" width="70" height="70" /></span><br />';
         echo '<a href="profile.php?perfil=' . $row['url'] . '">';
         echo $row['nome'] . ' ' . $row['sobrenome'];
         echo '</a>';
         echo '</td>';
      }
      echo '</tr>';
      echo '</table>';
      echo '</form>';
   }      
   echo '</div>';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" rel="stylesheet" href="../css/meus_amigos.css" />
    <title>Rede Social - Meus Amigos</title>
</head>
<body>    
</body>
</html>