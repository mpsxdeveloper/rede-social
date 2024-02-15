<?php
 
   require_once('../vars/appvars.php');
   require_once('../vars/connectvars.php');

   if(!isset($_SESSION['meu_id']) && !isset($_SESSION['meu_nome'])) {
      echo "Você precisa logar para acessar essa página!";
      echo "<br /><a href='../index.html'>Login</a>";
      exit();
   }
   else {
      $meu_id = $_SESSION['meu_id'];
      $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die("Erro ao conectar na base de dados.");
   }
  
?>    
    
<?php

   $query = "SELECT screenshot, usuario_id FROM fotos WHERE usuario_id = $meu_id";
   $data = mysqli_query($dbc, $query);
   while($row = mysqli_fetch_array($data)) {
      $foto_nome = $row['screenshot'];
   }   
   if(isset($_POST['atualiza_foto'])) {
      $foto_nome = $_FILES['foto']['name'];
      $foto_tipo = $_FILES['foto']['type'];
      $foto_tamanho = $_FILES['foto']['size']; 
      if(!empty($foto_nome)) {
         if((($foto_tipo == 'image/jpeg') || ($foto_tipo == 'image/png')) && ($foto_tamanho > 0) && ($foto_tamanho <= REDESOCIAL_MAXIMO_TAMANHO)) {
            if($_FILES['foto']['error'] == 0) {
               $foto_nome = 'foto' . $meu_id;    
               $target = REDESOCIAL_CAMINHO . $foto_nome;
               if(move_uploaded_file($_FILES['foto']['tmp_name'], $target)) {
                  $query = "SELECT usuario_id FROM fotos WHERE usuario_id = $meu_id";
                  $result = mysqli_query($dbc, $query);
                  if(mysqli_num_rows($result) == 1) {
                     $query = "UPDATE fotos SET screenshot = '$foto_nome' WHERE usuario_id = $meu_id";   
                     mysqli_query($dbc, $query);          
                  }
                  else {
                     $query = "INSERT INTO fotos (screenshot, usuario_id) VALUES ('$foto_nome', $meu_id)";
                     mysqli_query($dbc, $query);
                  }
               }
               else {
                  echo '<p class="error">Desculpe, ocorreu um erro ao enviar sua foto.</p>';
               }
            }
            else {
               echo '<p class="error">A foto deve estar no formato JPEG ou PNG e o tamanho não pode exceder ' . (REDESOCIAL_MAXIMO_TAMANHO / 1024) . ' KB.</p>';
            }            
            @unlink($_FILES['foto']['tmp_name']);
         }
         else {
            echo '<p class="error">Erro ao tentar salvar foto.</p>';
         }
      }
   }

?>

<?php    

   $query_select = "SELECT relacionamento, interesse, religiao, cidade, morando, citacao, sobre, livro, filme, serie, musica, cantor, esporte, time, personalidade, assunto, presente, escolaridade, cursando, medio, superior, habilidades 
                  FROM perfis_pessoais, perfis_educacionais 
                  WHERE perfis_pessoais.usuario_id = $meu_id AND perfis_educacionais.usuario_id = $meu_id";
   $result_select = mysqli_query($dbc, $query_select);
   $row = mysqli_fetch_array($result_select);
   $relacionamento = $row['relacionamento'];
   $interesse = $row['interesse'];
   $religiao = $row['religiao'];
   $cidade = $row['cidade'];
   $morando = $row['morando'];
   $citacao = $row['citacao'];
   $sobre = $row['sobre'];
   $livro = $row['livro'];
   $filme = $row['filme'];
   $serie = $row['serie'];
   $musica = $row['musica'];
   $cantor = $row['cantor'];
   $esporte = $row['esporte'];
   $time = $row['time'];
   $personalidade = $row['personalidade'];
   $assunto = $row['assunto'];
   $presente = $row['presente'];
   $escolaridade = $row['escolaridade'];
   $cursando = $row['cursando'];
   $medio = $row['medio'];
   $superior = $row['superior'];
   $habilidades = $row['habilidades'];
   
   if(isset($_POST['pessoal'])) {
      $relacionamento = mysqli_real_escape_string($dbc, trim($_POST['relacionamento']));
      $interesse = mysqli_real_escape_string($dbc, trim($_POST['interesse']));
      $religiao = mysqli_real_escape_string($dbc, trim($_POST['religiao']));
      $cidade = mysqli_real_escape_string($dbc, trim($_POST['cidade']));
      $morando = mysqli_real_escape_string($dbc, trim($_POST['morando']));
      $citacao = mysqli_real_escape_string($dbc, trim($_POST['citacao']));
      $sobre = mysqli_real_escape_string($dbc, trim($_POST['sobre']));
      $livro = mysqli_real_escape_string($dbc, trim($_POST['livro']));
      $filme = mysqli_real_escape_string($dbc, trim($_POST['filme']));
      $serie = mysqli_real_escape_string($dbc, trim($_POST['serie']));
      $musica = mysqli_real_escape_string($dbc, trim($_POST['musica']));
      $cantor = mysqli_real_escape_string($dbc, trim($_POST['cantor']));
      $esporte = mysqli_real_escape_string($dbc, trim($_POST['esporte']));
      $time = mysqli_real_escape_string($dbc, trim($_POST['time']));
      $personalidade = mysqli_real_escape_string($dbc, trim($_POST['personalidade']));
      $assunto = mysqli_real_escape_string($dbc, trim($_POST['assunto']));
      $presente = mysqli_real_escape_string($dbc, trim($_POST['presente']));
      $query_update = "UPDATE perfis_pessoais SET relacionamento = '$relacionamento', interesse = '$interesse', religiao = '$religiao', cidade = '$cidade', morando = '$morando', citacao = '$citacao', sobre = '$sobre', livro = '$livro', filme = '$filme', serie = '$serie', musica = '$musica', cantor = '$cantor', esporte = '$esporte', time = '$time', personalidade = '$personalidade', assunto = '$assunto', presente = '$presente' WHERE usuario_id = $meu_id";
      mysqli_query($dbc, $query_update);
   }  
  
   if(isset($_POST['educacional'])) {
      $escolaridade = mysqli_real_escape_string($dbc, trim($_POST['escolaridade']));
      $cursando = mysqli_real_escape_string($dbc, trim($_POST['cursando']));
      $medio = mysqli_real_escape_string($dbc, trim($_POST['medio']));
      $superior = mysqli_real_escape_string($dbc, trim($_POST['superior']));
      $habilidades = mysqli_real_escape_string($dbc, trim($_POST['habilidades']));
      $query_update = "UPDATE perfis_educacionais SET escolaridade = '$escolaridade', cursando = '$cursando', medio = '$medio', superior = '$superior', habilidades = '$habilidades' WHERE usuario_id = $meu_id";   
      mysqli_query($dbc, $query_update); 
   }
  
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link type="text/css" rel="stylesheet" href="../css/meu_perfil.css" />
   <title>Rede Social - Meu Perfil</title>
</head>

<body>

   <div id="meu_perfil">    
      <form enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
         <fieldset>
            <legend>Escolha sua foto para o perfil</legend>
            <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo REDESOCIAL_MAXIMO_TAMANHO; ?>" />
            <label for="foto">Foto:</label>
            <input type="file" id="foto" name="foto" />
            <input type="submit" value="Atualizar Foto" name="atualiza_foto" />
            <?php echo '<span><img src="' . REDESOCIAL_CAMINHO . $foto_nome . '" alt="Foto do perfil" width="100" height="100" /></span>'; ?>
            <br /><br />
            <span class="foto_aviso">A foto deve ter no máximo 640 KB de tamanho e ser do tipo .PNG ou .JPEG</span>
         </fieldset>
      </form>

      <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
         <fieldset>
            <legend>Pessoal</legend>    
            <table>
               <tr>
                  <th>Relacionamento:</th>
                  <td>
                     <select id="relacionamento" name="relacionamento">
                        <option value="<?php echo $relacionamento; ?>"><?php echo $relacionamento; ?></option>
                        <option value="Solteiro(a)">Solteiro(a)</option>
                        <option value="Enrolado(a)">Enrolado(a)</option> 
                        <option value="Namorando">Namorando</option>
                        <option value="Noivo(a)">Noivo(a)</option>
                        <option value="Casado(a)">Casado(a)</option>
                        <option value="Divorciado(a)">Divorciado(a)</option>
                        <option value="Viúvo(a)">Viúvo(a)</option>
                     </select>
                  </td>  
               </tr>
               <tr>
                  <th>Interesse em:</th>
                  <td>
                     <select id="interesse" name="interesse">
                        <option value="<?php echo $interesse; ?>"><?php echo $interesse; ?></option> 
                        <option value="Amizades">Amizades</option>
                        <option value="Namoro">Namoro</option>
                        <option value="Contatos Profissionais">Contatos Profissionais</option>
                        <option value="Nada">Nada</option>
                        <option value="Outros Interesses">Outros Interesses</option>
                     </select>
                  </td>
               </tr>
               <tr>
                  <th>Religião:</th>
                  <td>
                     <select id="religiao" name="religiao">
                        <option value="<?php echo $religiao; ?>"><?php echo $religiao; ?></option>
                        <option value="Agnosticismo">Agnosticismo</option>
                        <option value="Adventismo">Adventismo</option> 
                        <option value="Ateísmo">Ateísmo</option>
                        <option value="Budismo">Budismo</option>
                        <option value="Catolicismo">Catolicismo</option>
                        <option value="Espiritismo">Espiritismo</option>
                        <option value="Islamismo">Islamismo</option>
                        <option value="Judaísmo">Judaísmo</option>
                        <option value="Mormonismo">Mormonismo</option>
                        <option value="Protestantismo">Protestantismo</option>
                        <option value="Testemunha de Jeová">Testemunha de Jeová</option>
                        <option value="Outra Religião">Outra Religião</option>
                     </select>
                  </td>
               </tr>
               <tr>
                  <th>Cidade natal:</th>
                  <td><input type="text" id="cidade" name="cidade" maxlength="30" size="40" value="<?php echo $cidade; ?>" /></td>
               </tr>
               <tr>
                  <th>Morando em:</th>
                  <td><input type="text" id="morando" name="morando" maxlength="30" size="40" value="<?php echo $morando; ?>" /></td>
               </tr>
               <tr>
                  <th>Minha citação favorita:</th>
                  <td><textarea id="citacao" name="citacao" rows="4" cols="46"><?php echo $citacao; ?></textarea></td>
               </tr>
               <tr>
                  <th>Escreva um pouco sobre você:</th>
                  <td><textarea id="sobre" name="sobre" rows="6" cols="50"><?php echo $sobre; ?></textarea></td>
               </tr>
               <tr>
                  <th>Gostaria de ganhar de presente:</th>
                  <td><input type="text" id="presente" name="presente" maxlength="35" size="40" value="<?php echo $presente; ?>" /></td>
               </tr>
               <tr>
                  <th>Livro:</th>
                  <td><input type="text" id="livro" name="livro" maxlength="30" size="40" value="<?php echo $livro; ?>" /></td>
               </tr>
               <tr>
                  <th>Filme:</th>
                  <td><input type="text" id="filme" name="filme" maxlength="30" size="40" value="<?php echo $filme; ?>" /></td>
               </tr>
               <tr>
                  <th>Série de TV:</th>
                  <td><input type="text" id="serie" name="serie" maxlength="30" size="40" value="<?php echo $serie; ?>" /></td>
               </tr>
               <tr>
                  <th>Música:</th>
                  <td><input type="text" id="musica" name="musica" maxlength="30" size="40" value="<?php echo $musica; ?>" /></td>
               </tr>
               <tr>
                  <th>Cantor(a):</th>
                  <td><input type="text" id="cantor" name="cantor" maxlength="35" size="45" value="<?php echo $cantor; ?>" /></td>
               </tr>
               <tr>
               <th>Esporte:</th>
                  <td><input type="text" id="esporte" name="esporte" maxlength="30" size="40" value="<?php echo $esporte; ?>" /></td>
                  </tr>
               <tr>
                  <th>Time de futebol:</th>
                  <td><input type="text" id="time" name="time" maxlength="30" size="40" value="<?php echo $time; ?>" /></td>
               </tr>
               <tr>
                  <th>Uma personalidade que admira:</th>
                  <td><input type="text" id="personalidade" name="personalidade" maxlength="40" size="50" value="<?php echo $personalidade; ?>" /></td>
               </tr>
               <tr>
                  <th>Assuntos que me interessam:</th>
                  <td><input type="text" id="assunto" name="assunto" maxlength="40" size="50" value="<?php echo $assunto; ?>" /></td>
               </tr>
               <tr>
                  <td></td>
                  <td><input type="submit" value="Atualizar Perfil" name="pessoal" /></td>
               </tr>
            </table>
         </fieldset>
      </form>
   
      <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">   
         <fieldset>
            <legend>Educação</legend>
            <table>
            <tr>
               <th>Escolaridade:</th>
               <td>
                  <select id="escolaridade" name="escolaridade">
                     <option value="<?echo $escolaridade; ?>"><?echo $escolaridade; ?></option> 
                     <option value="Ensino Fundamental - Em andamento">Ensino Fundamental - Em andamento</option>
                     <option value="Ensino Fundamental - Concluído">Ensino Fundamental - Concluído</option>
                     <option value="Ensino Médio - Em andamento">Ensino Médio - Em andamento</option>
                     <option value="Ensino Médio - Concluído">Ensino Médio - Concluído</option>
                     <option value="Ensino Superior - Em andamento">Ensino Superior - Em andamento</option>
                     <option value="Ensino Superior - Concluído">Ensino Superior - Concluído</option>
                     <option value="Especialização - Em andamento">Especialização - Em andamento</option>
                     <option value="Especialização - Concluído">Especialização - Concluído</option>
                     <option value="Mestrado - Em andamento">Mestrado - Em andamento</option>
                     <option value="Mestrado - Concluído">Mestrado - Concluído</option>
                     <option value="Doutorado - Em andamento">Doutorado - Em andamento</option>
                     <option value="Doutorado - Concluído">Doutorado - Concluído</option>
                  </select>
               </td>
            </tr>
            <tr>
               <th>Cursando atualmente:</th>
               <td><input type="text" id="cursando" name="cursando" maxlength="45" size="55" value="<?php echo $cursando; ?>" /></td>
            </tr>
            <tr>
            <th>Escola de Ensino Médio:</th>
               <td><input type="text" id="medio" name="medio" maxlength="35" size="45" value="<?php echo $medio; ?>" /></td>
            </tr>
            <tr>
               <th>Escola de Ensino Superior:</th>
               <td><input type="text" id="superior" name="superior" maxlength="80" size="45" value="<?php echo $superior; ?>" /></td>
            </tr>
            <tr>
               <th>Minhas habilidades:</th>
               <td><input type="text" id="habilidades" name="habilidades" maxlength="45" size="55" value="<?php echo $habilidades; ?>" /></td>
            </tr>
            <tr>
               <td></td>
               <td><input type="submit" value="Atualizar Perfil" name="educacional" /></td>
            </tr>
         </table>
      </fieldset>
   </form>
</div>

</body>

</html>