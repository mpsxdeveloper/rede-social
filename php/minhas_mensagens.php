<?php

   require_once('../vars/connectvars.php');
   echo '<div id="minhas_mensagens">';   
   if(!isset($_SESSION['meu_id']) && !isset($_SESSION['meu_nome'])) {
      echo "Você precisa logar para acessar essa página!";
      echo "<br /><a href='../index.html'>Login</a>";
   }
   else {
      $meu_id = $_SESSION['meu_id'];
      $meu_nome = $_SESSION['meu_nome'];
      echo "<br />";
      echo '<span class="mensagem_span">Suas mensagens:</span>';
      echo "<br/><br />";
      $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
      $query = "SELECT mensagens.emissor_id, nome, sobrenome, mensagem, mensagens.data FROM usuarios, mensagens WHERE $meu_id = mensagens.receptor_id
               AND usuarios.id = mensagens.emissor_id";
      $data = mysqli_query($dbc, $query);
      while($row = mysqli_fetch_array($data)) {
         $horario = $row['data']; 
         $tempo = strftime("%d/%m/%Y %H:%M:%S", strtotime($horario)); 
         echo '<span class="mensagem_span">De: ' . $row['nome'] . ' ' . $row['sobrenome'] . '</span>';
         echo ' ' . $tempo; echo '<br/><br />';
         echo '<span class="mensagem_span">' . $row['mensagem'] . '</span><br />';
         echo '<hr />';
      }
   }
   echo '</div>';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" rel="stylesheet" href="../css/minhas_mensagens.css" />
    <title>Rede Social - Minhas Mensagens</title>
</head>
<body>    
</body>
</html>