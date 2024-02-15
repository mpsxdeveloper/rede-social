<?php

   require_once('../vars/appvars.php');
   require_once '../vars/connectvars.php';

   session_start();
   
   if(isset($_SESSION['meu_id']) && isset($_SESSION['meu_nome']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
      if(!isset($_POST['pessoal']) && !isset($_POST['atualiza_foto']) && !isset($_POST['pesquisa_perfil']) 
         && !isset($_POST['envia_msg']) && !isset($_POST['adiciona_amigo']) && !isset($_POST['educacional']) 
         && !isset($_POST['email_convite']) && !isset($_POST['atualiza_senha'])) {
         $_SESSION = array();
         session_destroy();
         header('Location: ../index.html');
      }
   }
   if(isset($_SESSION['meu_id']) && isset($_SESSION['meu_nome'])) {
      $meu_id = $_SESSION['meu_id'];
      $meu_nome = $_SESSION['meu_nome'];
      $meu_sobrenome = $_SESSION['meu_sobrenome'];
      $minha_foto = $_SESSION['minha_foto'];
   }
   else if($_SERVER['REQUEST_METHOD'] == 'POST') {
      if(isset($_POST['email_login']) && isset($_POST['senha_login']) ) {
         $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die("Erro ao conectar na base de dados.");
         $email = mysqli_real_escape_string($dbc, trim($_POST['email_login']));
         $senha = mysqli_real_escape_string($dbc, trim($_POST['senha_login']));
         $query = "SELECT id, email, senha, nome, sobrenome, aprovado FROM usuarios WHERE email = '$email' AND senha = SHA('$senha')";
         $result = mysqli_query($dbc, $query);
         if(mysqli_num_rows($result) == 1) { 
            $row = mysqli_fetch_array($result);
            if(isset($_SESSION['meu_id']) && $_SESSION['meu_id'] != $row['id']) {
               exit();
            }
            if($row['aprovado'] == 0) {
               echo '             
                  <div id="erro" style="width: 80%; height: 120px; margin: 0 auto; text-align: center; background: #f75d59; font-weight: bolder;">
                     <h4>Usuário ainda não confirmou seu código de acesso!</h4>
                     <p>Você precisa acessar seu email ' . $email . ' para confirmar seu cadastro.</p>
                     <a href="../index.html">Ir para a página inicial</a>                     
                  </div>';
               mysqli_close($dbc);
               exit();
            }
            else {
               $meu_id = $_SESSION['meu_id'] = $row['id'];
               $meu_nome = $_SESSION['meu_nome'] = $row['nome'];
               $meu_sobrenome = $_SESSION['meu_sobrenome'] = $row['sobrenome'];
               $query = "SELECT screenshot, usuario_id FROM fotos WHERE usuario_id = $meu_id";
               $data = mysqli_query($dbc, $query);
               while($row = mysqli_fetch_array($data)) {
                  $minha_foto = $_SESSION['minha_foto'] = $row['screenshot'];
               }
               mysqli_close($dbc);
            }
         }
      }
      else {
         echo '             
            <div id="erro" style="width: 80%; height: 120px; margin: 0 auto; text-align: center; background: #f75d59; font-weight: bolder;">
               <h4>Usuário e senha inexistentes!</h4>
               <p>Você precisa estar cadastrado para acessar essa página.</p>
               <a href="../html/cadastro.html">Ir para a página de cadastro</a>                      
            </div>';
         mysqli_close($dbc);   
         exit();  
      }
   }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" rel="stylesheet" href="../css/topo.css" />
    <title>Document</title>
</head>
<body>
   <div id="topo">
      <img src="../imagens/logotipo_pequeno.png" alt="logotipo pequeno" />
      <div class="nome"><?php echo $meu_nome . " " . $meu_sobrenome; ?>
      <img class="minha_foto" width="40" height="40" src="<?php echo $minha_foto; ?>" />
   </div>
</body>
</html>