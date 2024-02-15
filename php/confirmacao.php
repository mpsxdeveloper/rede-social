<?php

   require_once '../vars/connectvars.php';
   $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die("Erro ao conectar na base de dados.");
   $codigo = mysqli_real_escape_string($dbc, trim($_GET['codigo']));
   $query = "SELECT id, codigo, aprovado FROM usuarios WHERE codigo = '$codigo'";
   $result = mysqli_query($dbc, $query);
   if(mysqli_num_rows($result) == 1) {
      $row = mysqli_fetch_array($result); 
      $id = $row['id'];
      $query2 = "UPDATE usuarios SET aprovado = 1 WHERE codigo = '$codigo'";
      if(mysqli_query($dbc, $query2)) {
         $query = "SELECT id FROM fotos WHERE usuario_id = $id";
         $result = mysqli_query($dbc, $query);
         if(!mysqli_num_rows($result) == 1) { 
            $add_foto = "INSERT INTO fotos (usuario_id) VALUES ($id)";
            mysqli_query($dbc, $add_foto);
         }
         $query_perfil = "SELECT id FROM perfis_pessoais WHERE usuario_id = $id";
         $result = mysqli_query($dbc, $query_perfil);
         if(!mysqli_num_rows($result) == 1) {
            $perfil = "INSERT INTO perfis_pessoais (usuario_id) VALUES ($id)";
            mysqli_query($dbc, $perfil);            
         }
         $query_educacao = "SELECT id FROM perfis_educacionais WHERE usuario_id = $id";
         $result = mysqli_query($dbc, $query_educacao);
         if(!mysqli_num_rows($result) == 1) {
            $perfil = "INSERT INTO perfis_educacionais (usuario_id) VALUES ($id)";
            mysqli_query($dbc, $perfil);            
         }
         echo '
            <div id="cadastro" style="width: 80%; height: 100px; margin: 0 auto; text-align: center; background: #87ceeb; font-weight: bolder;">
               <p>Você confirmou seu código de acesso na rede social!</p>
               <p>Agora você pode criar um perfil, encontrar amigos, enviar mensagens, e muito mais!</p>
               <p><a href="../index.html">Ir para a página inicial</a></p>               
            </div>';
         }
      }
      else {
         echo '    
            <div id="erro" style="width: 80%; height: 300px; margin: 0 auto; text-align: center; background: #f75d59; font-weight: bolder;">
            <h4>Código incorreto!</h4>
            <p>Possíveis causas:</p>
            <p>Se você copiou e colou o link de confirmação enviado para seu e-mail, verifique se você copiou o link corretamente.</p>
            <p>Algum símbolo ou acento não foi reconhecido pelo sistema quando você cadastrou seu nome ou sobrenome.</p>
            <p>Nossos servidores podem estar sobrecarregados. Tente de novo em alguns minutos.</p>
            <a href="../index.html">Voltar para a página inicial</a>            
         </div>';
      }
   
?>