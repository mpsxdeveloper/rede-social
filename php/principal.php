<?php

   require_once '../vars/connectvars.php';
   require_once '../vars/appvars.php';
   echo '<html>';
   echo '<head>';
   echo '<title></title>';
   echo '<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">';
   echo '<link type="text/css" rel="stylesheet" href="../css/principal.css" />';
   echo '</head>';
   echo '<body>';   
   if(!isset($_SESSION['meu_id']) && !isset($_SESSION['meu_nome'])) {
      echo '
         <div id="erro" style="width: 80%; height: 120px; margin: 0 auto; text-align: center; background: #f75d59; font-weight: bolder;">
            <h4>Acesso Negado!</h4>
            <p>Você precisa estar logado para acessar essa página.</p>
            <p>Verifique se você digitou corretamente seu e-mail e senha na página inicial.</p>
            <a href="../index.html">Voltar para a página inicial</a>            
         </div>';
      exit();  
   }
   else {
      $meu_id = $_SESSION['meu_id'];
      $meu_nome = $_SESSION['meu_nome'];
   }   
   if(isset($_POST['email_convite'])) {
      $url = 'http://localhost/html/cadastro.html';
      $para = $_POST['email_convite'];
      $regex = '/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|.(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/';
      if(!preg_match($regex, $para)) {
         echo '<script>alert("Formato de email incorreto!");</script>';
      }
      else {
         $assunto = 'Convite de ' . $meu_nome;
         $mensagem = '
            <html>
               <head>
                  <title>Convite</title>
                  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
               </head>
               <body>
                  <div id="cadastro" style="width: 80%; height: 120px; margin: 0 auto; text-align: center; background: #87ceeb; font-weight: bolder;">
                     <h4>Olá '. $para .',</h4>
                     <p>Eu, '. $meu_nome .', estou te convidando para fazer parte da nossa rede social.</p>
                     <p>Para se cadastrar, você só precisa de alguns minutos.</p>
                     <p>Acesse o endereço abaixo para em pouco tempo encontrar amigos e enviar mensagens:</p>
                     <a href="'.$url.'">'.$url.'</a>                     
                  </div>
               </body>
            </html>';
         $headers  = 'MIME-Version: 1.0' . "\r\n";
         $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
         $headers .= 'To: '.$para.' <'.$para.'>' . "\r\n";
         $headers .= 'From: Rede Social <Rede Social>' . "\r\n";
         mail($para, $assunto, $mensagem, $headers);
         echo '<script>alert("Convite enviado com sucesso!");</script>';
      }
   }
   
?>
   
   <div id="principal"><br />   
      <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
         <span class="convite_span">Envie um e-mail convidando um amigo para a rede social!</span><br /><br />
         <input type="text" id="email_convite" name="email_convite" size="45" maxlength="40" />
         <input type="submit" value="Convidar" name="convidar" />
      </form>
   
   <?php
      
      echo '<br />';
      echo '<span class="amizades_span">Solicitações de amizades</span><br />';
      $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die("Erro ao conectar na base de dados.");
      $query = "SELECT solicitante_id, solicitado_id, usuarios.nome, usuarios.sobrenome, usuarios.email, usuarios.url, usuarios.id, fotos.screenshot, fotos.usuario_id FROM usuarios, amizades, fotos WHERE solicitado_id = $meu_id AND confirmado = 0 AND solicitante_id = usuarios.id AND fotos.usuario_id = usuarios.id";
      $data = mysqli_query($dbc, $query);
      while($row = mysqli_fetch_array($data)) {
         echo $row['nome'] . ' ' . $row['sobrenome'] . ' ';
         echo '<span><img src="' . REDESOCIAL_CAMINHO . $row['screenshot'] . '" alt="Foto do usuário" width="70" height="70" /></span>' . ' ';
         echo '<a href="adiciona_amigo.php?perfil=' . $row['url'] . '">Aceitar Amizade</a>';
         echo '<br />';
      }   
      echo '<hr />';      
      echo '</div>';
      echo '</body>';
      echo '</html>';
   
   ?>