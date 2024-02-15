<?php

   require_once '../vars/appvars.php';
   require_once '../vars/connectvars.php';   
   echo '<div id="profiles">';   
   if(!isset($_SESSION['meu_id']) && !isset($_SESSION['meu_nome'])) {
      echo "Você precisa logar para acessar essa página!";
      echo "<br /><a href='../index.html'>Login</a>";
      exit();
   }
   else if(!isset($_POST['adiciona_amigo'])) {      
      $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die("Erro ao conectar na base de dados.");      
      $url = $_GET['perfil'];
      $query = "SELECT usuarios.id, usuarios.url, usuarios.nome, usuarios.sobrenome, usuarios.nascimento, usuarios.email, 
         perfis_pessoais.religiao, perfis_pessoais.relacionamento, perfis_pessoais.interesse, perfis_pessoais.cidade, perfis_pessoais.morando, perfis_pessoais.citacao, 
         perfis_pessoais.sobre, perfis_pessoais.livro, perfis_pessoais.filme, perfis_pessoais.serie, perfis_pessoais.musica, perfis_pessoais.cantor,
         perfis_pessoais.esporte, perfis_pessoais.time, perfis_pessoais.personalidade, perfis_pessoais.assunto, perfis_pessoais.presente, 
         perfis_educacionais.escolaridade, perfis_educacionais.cursando, perfis_educacionais.medio, perfis_educacionais.superior, perfis_educacionais.habilidades, 
         fotos.screenshot, fotos.usuario_id FROM usuarios, perfis_pessoais, perfis_educacionais, fotos WHERE usuarios.url = '$url' 
         AND usuarios.id <> $meu_id AND usuarios.id = fotos.usuario_id AND perfis_pessoais.usuario_id = usuarios.id AND perfis_educacionais.usuario_id = usuarios.id";
      $data = mysqli_query($dbc, $query);
      $row = mysqli_fetch_array($data);
      $amigo_id = $row['id'];
      $amigo_citacao = $row['citacao'];
      $amigo_nome = $row['nome'];
      $amigo_sobrenome = $row['sobrenome'];
      $amigo_nascimento = $row['nascimento'];
      $amigo_email = $row['email'];
      $amigo_religiao = $row['religiao'];
      $amigo_relacionamento = $row['relacionamento'];
      $amigo_interesse = $row['interesse'];
      $amigo_cidade = $row['cidade'];
      $amigo_morando = $row['morando'];
      $amigo_sobre = $row['sobre'];
      $amigo_livro = $row['livro'];
      $amigo_filme = $row['filme'];
      $amigo_serie = $row['serie'];
      $amigo_musica = $row['musica'];
      $amigo_cantor = $row['cantor'];
      $amigo_esporte = $row['esporte'];
      $amigo_time = $row['time'];
      $amigo_personalidade = $row['personalidade'];
      $amigo_assunto = $row['assunto'];
      $amigo_presente = $row['presente'];
      $amigo_escolaridade = $row['escolaridade'];
      $amigo_cursando = $row['cursando'];
      $amigo_medio = $row['medio'];
      $amigo_superior = $row['superior'];
      $amigo_habilidades = $row['habilidades'];
      echo 'Citação: ' . $amigo_citacao . '<br />';
      echo 'Nome: ' . $amigo_nome . ' ' . $amigo_sobrenome . '<br />';
      $dia = substr($amigo_nascimento, 8, 2);
      $mes = substr($amigo_nascimento, 5, 2);
      echo 'Aniversário: ' . $dia . '/' . $mes . '<br />';
      echo 'E-mail: ' . $amigo_email . '<br />';
      echo 'Religião: ' . $amigo_religiao . '<br />';
      echo '&#10084;' . ' Relacionamento: ' . $amigo_relacionamento . '<br />';
      echo 'Interesse: ' . $amigo_interesse . '<br />';
      echo 'Nasceu em: ' .$amigo_cidade . '<br />';
      echo 'Morando em: ' . $amigo_morando . '<br />';
      echo 'Sobre: ' . $amigo_sobre . '<br />';
      echo 'Livro: ' . $amigo_livro . '<br />';
      echo 'Filme: ' . $amigo_filme . '<br />';
      echo 'Série de TV: ' . $amigo_serie . '<br />';
      echo 'Música: ' . $amigo_musica . '<br />';
      echo 'Cantor(a): ' . $amigo_cantor . '<br />';
      echo 'Esporte: ' . $amigo_esporte . '<br />';
      echo 'Time: ' . $amigo_time . '<br />';
      echo 'Personalidade: ' . $amigo_personalidade . '<br />';
      echo 'Assunto: ' . $amigo_assunto . '<br />';
      echo 'Escolaridade: ' . $amigo_escolaridade . '<br />';
      echo 'Cursando: ' . $amigo_cursando . '<br />';
      echo 'Ensino Médio: ' . $amigo_medio . '<br />';
      echo 'Ensino Superior: ' . $amigo_superior . '<br />';
      echo 'Habilidades: ' . $amigo_habilidades . '<br />';
      echo 'Gostaria de ganhar de presente: ' . $amigo_presente . '<br />';
      $query = "SELECT screenshot FROM fotos WHERE usuario_id = $amigo_id";
      $data = mysqli_query($dbc, $query);
      $row = mysqli_fetch_array($data);
      $foto_nome = $row['screenshot'];
      echo '<span><img src="' . REDESOCIAL_CAMINHO . $foto_nome . '" alt="Foto do perfil:" /></span>';
   
      if(isset($_POST['envia_msg']) && !empty($_POST['mensagem'])) {
         $mensagem = $_POST['mensagem'];
         $emissor_id = $meu_id;
         $receptor_id = $_POST['amigo_id'];
         $query = "INSERT INTO mensagens (mensagem, emissor_id, receptor_id, data) VALUES ('$mensagem', $emissor_id, $receptor_id, NOW())"; 
         if(mysqli_query($dbc, $query)) {
            echo "<br />Mensagem enviada com sucesso!";
            echo '<script>window.history.go(-1);</script>';            
         }
         else {
            echo "<br />Não foi possível enviar a mensagem!";
         }
      }
      else if(isset($_POST['adiciona_amigo'])) {
         $solicitante_id = $meu_id;
         $solicitado_id = $_POST['amigo_id'];
         $query1 = "SELECT id FROM amizades WHERE solicitante_id = $solicitante_id AND solicitado_id = $solicitado_id AND confirmado = 0";
         $result1 = mysqli_query($dbc, $query1);
         if(mysqli_num_rows($result1) == 1) {
            echo '<script>alert("Você já solicitou amizade dessa pessoa!");</script>'; 
            echo '<script>window.history.go(-1);</script>';
         }
         $query2 = "SELECT id FROM amizades WHERE solicitante_id = $solicitado_id AND solicitado_id = $meu_id AND confirmado = 0";
         $result2 = mysqli_query($dbc, $query2);
         if(mysqli_num_rows($result2) == 1) { 
            $query = "UPDATE amizades SET confirmado = 1 WHERE solicitado_id = $meu_id AND solicitante_id = $solicitado_id";
            if(mysqli_query($dbc, $query)) {
               echo "<br />Amigo adicionado com sucesso!";
               echo '<script>window.history.go(-1);</script>';
            }
         }
         $query3 = "SELECT id FROM amizades WHERE solicitante_id = $solicitante_id AND solicitado_id = $solicitado_id AND confirmado = 1";
         $result3 = mysqli_query($dbc, $query3);
         if(mysqli_num_rows($result3) == 1) {
            echo '<script>alert("A solicitação de amizade já foi aceita!");</script>';
            echo '<script>window.history.go(-1);</script>';
         }
         $query4 = "SELECT id FROM amizades WHERE solicitante_id = $solicitado_id AND solicitado_id = $meu_id AND confirmado = 1";
         $result4 = mysqli_query($dbc, $query4);
         if(mysqli_num_rows($result4) == 1) {
            echo '<script>alert("A solicitação de amizade já foi aceita!");</script>';
            echo '<script>window.history.go(-1);</script>';
            exit();
         }
         $query5 = "SELECT id FROM amizades WHERE solicitante_id = $solicitante_id AND solicitado_id = $solicitado_id";
         $result5 = mysqli_query($dbc, $query5);
         if(!mysqli_num_rows($result5) == 1) {
            $query_adiciona_amigo = "INSERT INTO amizades (solicitante_id, solicitado_id) VALUES ($solicitante_id, $solicitado_id)";
            if(mysqli_query($dbc, $query_adiciona_amigo)) {
               echo '<script>alert("Solicitação de amizade enviada com sucesso!");</script>';  
               echo '<script>window.history.go(-1);</script>';
            }
         }
         else {
            echo '<script>alert("Não foi possível enviar a solicitação de amizade!");</script>'; 
            echo '<script>window.history.go(-1);</script>';
         }
      }
   }   
      
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" rel="stylesheet" href="../css/profiles.css" />
    <title>Rede Social - Perfis</title>
</head>
<body>
      <form name="form_mensagem" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
         <hr />Enviar uma mensagem para <?php echo $amigo_nome . ' ' . $amigo_sobrenome; ?>:<br />
         <input type="text" id="mensagem" name="mensagem" maxlength="100" size="100" /><br />
         <input type="submit" id="envia_msg" name="envia_msg" value="Enviar Mensagem" /><br /><hr />
         <input type="submit" id="adiciona_amigo" name="adiciona_amigo" value="<?php echo 'Adicionar ' . $amigo_nome . ' '. $amigo_sobrenome; ?>" /><br />
         <input type="hidden" id="amigo_id" name="amigo_id" value="<?php echo $amigo_id; ?>" />
      </form>   
      <?php echo '</div>'; ?>
</body>
</html>