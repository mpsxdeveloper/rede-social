<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" rel="stylesheet" href="../css/minha_pesquisa.css" />
    <title>Rede Social - Pesquisa</title>
</head>

<body>
    
   <div id="minha_pesquisa">
      <form name="submit" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" > 
         <fieldset>
            <legend>Pesquisa</legend>
            <input type="text" name="pesquisa" />
            <input type="submit" name="pesquisa_perfil" value="Pesquisar" />
         </fieldset>
      </form>

<?php

   require_once '../vars/connectvars.php';   
   if(!isset($_SESSION['meu_id']) && !isset($_SESSION['meu_nome'])) {
      echo "Você precisa logar para acessar essa página!";
      echo "<br /><a href='../index.html'>Login</a>";
   }
   else {
      $meu_id = $_SESSION['meu_id'];
      $meu_nome = $_SESSION['meu_nome'];
   }
   echo "<hr />";
   if(isset($_POST['pesquisa_perfil'])) {
      $pesquisa = $_POST['pesquisa'];
      if(!empty($pesquisa)) {
         $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die("Erro ao conectar na base de dados.");
         $query = "SELECT usuarios.id, usuarios.url, usuarios.nome, usuarios.sobrenome, usuarios.email, fotos.screenshot FROM usuarios, fotos WHERE nome LIKE '$pesquisa%' AND usuarios.id <> $meu_id AND usuarios.id = fotos.usuario_id";
         $data = mysqli_query($dbc, $query);
         echo '<form>';
         echo '<table>';
         while($row = mysqli_fetch_array($data)) {
            echo '<tr style="background-color: #add8e6;">';
            echo '<td>';
            echo $row['nome'] . ' ' . $row['sobrenome'];
            echo '</td>'; 
            echo '<td style="background-color: #90EE90;">';
            echo '<a href="profile.php?perfil=' . $row['url'] . '">Ver Perfil</a>';
            echo '</td>';
            echo '<td style="background-color: #000;">';
            echo '<span><img src="' . REDESOCIAL_CAMINHO . $row['screenshot'] . '" alt="Foto do perfil" width="70" height="70" /></span>';
            echo '</td>';
            echo '</tr>';
         }
         echo '</table>';
         echo '</form>';
      }
   }
   echo "</div>";

?>

</body>

</html>