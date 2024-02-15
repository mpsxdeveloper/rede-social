<?php

   require_once('../vars/connectvars.php');
   echo '<div id="minhas_configuracoes">';
   if(!isset($_SESSION['meu_id']) && !isset($_SESSION['meu_nome'])) {
      echo "Você precisa logar para acessar essa página!";
      echo "<br /><a href='index.html'>Login</a>";
   }
   else {
      $meu_id = $_SESSION['meu_id'];
      $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
      if(isset($_POST['atualiza_senha'])) {
         $senha_atual = $_POST['senha_atual'];
         $nova_senha = $_POST['nova_senha'];
         $confirma_nova_senha = $_POST['confirma_nova_senha'];
         if(!empty($senha_atual) && !empty($nova_senha) && !empty($confirma_nova_senha)) {
            $regex = '/^\w{5,30}$/';
            if(!preg_match($regex, $nova_senha)) {
               echo '<script>alert("A sua nova senha deve conter no mínimo 5 e no máximo 30 caracteres!");</script>';
            }
            else if($confirma_nova_senha != $nova_senha) {
               echo '<script>alert("Você não confirmou corretamente sua nova senha!");</script>'; 
            }
            else {
               $query = "SELECT senha FROM usuarios WHERE senha = SHA('$senha_atual') AND id = $meu_id";
               $result = mysqli_query($dbc, $query);
               if(mysqli_num_rows($result) == 1) {
                  $query_update = "UPDATE usuarios SET senha = SHA('$nova_senha') WHERE id = $meu_id";   
                  if(mysqli_query($dbc, $query_update)) {
                     echo '<script>alert("Nova senha atualizada com sucesso!");</script>';             
                  }
                  else {
                     echo '<script>alert("Infelizmente, sua nova senha não foi atualizada com sucesso!");</script>';                    
                  }
               }
               else {
                  echo '<script>alert("Sua senha atual está incorreta!");</script>';
               }
            }
         }
         else {
            echo '<script>alert("Você precisa preencher todos os campos!");</script>';     
         }
      }       
   }
   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" rel="stylesheet" href="../css/minhas_configuracoes.css" />
    <title>Rede Social - Minhas Configurações</title>
</head>
<body>
   <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">   
      <fieldset>
         <legend>Alterar Minha Senha:</legend>
         <table>
            <tr>
               <th>Digite sua senha atual:</th>
               <td><input type="password" id="senha_atual" name="senha_atual" maxlength="30" size="35" /></td>
            </tr>
            <tr>
               <th>Escolha sua nova senha:</th>
               <td><input type="password" id="nova_senha" name="nova_senha" maxlength="30" size="35" /></td>
            </tr>
            <tr>
               <th>Confirme sua nova senha:</th>
               <td><input type="password" id="confirma_nova_senha" name="confirma_nova_senha" maxlength="30" size="35" /></td>
            </tr>
            <tr>
               <td></td>
               <td><input type="submit" value="Atualizar Senha" name="atualiza_senha" /></td>
            </tr>
         </table>
      </fieldset>
   </form>
</div>    
</body>
</html>