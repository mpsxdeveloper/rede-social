<?php
   
   require_once('../vars/appvars.php');
   require_once '../vars/connectvars.php';   
   $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die("Erro ao conectar na base de dados.");
   $email = mysqli_real_escape_string($dbc, trim($_POST['email_cad']));
   $senha = mysqli_real_escape_string($dbc, trim($_POST['senha_cad'])); 
   $nome = mysqli_real_escape_string($dbc, trim($_POST['nome_cad']));
   $sobrenome = mysqli_real_escape_string($dbc, trim($_POST['sobrenome_cad']));
   $nascimento = $_POST['ano'].'/'.$_POST['mes'].'/'.$_POST['dia'];
   $rand1 = time() * rand(1, 1000);
   $rand2 = time() * rand(1, 1000);
   $rand3 = time() * rand(1, 1000);
   $rand4 = time() * rand(1, 1000);
   $rand5 = time() * rand(1, 1000);
   $url = $nome . '.' . $sobrenome . '.' . $rand1 . $rand2 . $rand3 . $rand4 . $rand5;
   $cod1 = time() * rand(1, 1000);
   $cod2 = time() * rand(1, 1000);
   $cod3 = time() * rand(1, 1000);
   $cod4 = time() * rand(1, 1000);
   $codigo = $nome . '.' . $sobrenome . '.' . $cod1 . $cod2 . $cod3 . $cod4;       
   $query = "INSERT INTO usuarios (email, senha, nome, sobrenome, nascimento, url, codigo) 
             VALUES ('$email', SHA('$senha'), '$nome', '$sobrenome', '$nascimento', '$url', '$codigo')";
   if(mysqli_query($dbc, $query)) {
      $codigo_usuario = "http://localhost:8080/php/confirmacao.php?codigo=$codigo";
      $para  = $email;
      $assunto = 'Seu código de cadastro na rede social';
      $mensagem = '
         <html>
            <head>
               <title>Seja bem vindo a Rede Social</title>
               <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
            </head>
            <body>            
               <div id="cadastro" style="width: 80%; height: 120px; margin: 0 auto; text-align: center; background: #87ceeb; font-weight: bolder;">
                  <h4>Olá '. $nome . ' ' . $sobrenome . ',</h4>                  
                  <a href="'.$codigo_usuario.'">'.$codigo_usuario.'</a>                  
               </div>
            </body>
         </html>';
      $headers  = 'MIME-Version: 1.0' . "\r\n";
      $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
      $headers .= 'To: '.$nome.' <'.$email.'>' . "\r\n";
      $headers .= 'From: Rede Social <Rede Social>' . "\r\n";
      mail($para, $assunto, $mensagem, $headers);
      echo '            
         <div id="cadastro" style="width: 80%; height: 120px; margin: 0 auto; text-align: center; background: #87ceeb; font-weight: bolder;">
            <h4>Olá '. $nome . ' ' . $sobrenome . ',</h4>
            <p>Seu cadastro na rede social foi efetuado com sucesso!</p>
            <p>Acesse seu email '. $email .' para concluir o processo sua inscrição na rede social.</p>
            <p><a href="../index.html">Ir para a página inicial</a></p>            
         </div>';   
   }
   else {
      echo '
         <div id="erro" style="width: 80%; height: 120px; margin: 0 auto; text-align: center; background: #f75d59; font-weight: bolder;">
            <h4>Erro ao tentar cadastrar perfil</h4>
            <p>Possíveis causas:</p>
            <p>O e-mail já se encontra cadastrado na rede social.</p>
            <p>Nossos servidores estão sobrecarregados. Tente de novo em alguns minutos.</p>
            <a href="../html/cadastro.html">Voltar para a página de cadastro</a>            
         </div>';
   }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/javascript" src="../javascript/cadastro.js"></script>
    <link type="text/css" rel="stylesheet" href="../css/cadastro.css" />
    <title>Rede Social - Cadastro</title>
</head>
<body>
</body>
</html>