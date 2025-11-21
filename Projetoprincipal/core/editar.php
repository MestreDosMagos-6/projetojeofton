<?php
    include_once('conexao.php');

    $id = -1; 

    if(!empty($_GET['id']))
    {
        $id = $_GET['id'];
        $sqlSelect = "SELECT * FROM usuarios WHERE id=$id";
        $result = $conexao->query($sqlSelect);

        if($result->num_rows > 0)
        {
            while($user_data = mysqli_fetch_assoc($result))
            {
                $nome = $user_data['nome'];
                $email = $user_data['email'];
                $telefone = $user_data['telefone'];
                $sexo = $user_data['sexo'];
                $data_nasc = $user_data['data_nascimento'];
                $cidade = $user_data['cidade'];
                $estado = $user_data['estado'];
                $endereco = $user_data['endereco'];
            }
        }
        else { header('Location: sistema.php'); }
    }
    else { header('Location: sistema.php'); }

    if(isset($_POST['update']))
    {
        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $telefone = $_POST['telefone'];
        $sexo = $_POST['genero'];
        $data_nasc = $_POST['data_nascimento'];
        $cidade = $_POST['cidade'];
        $estado = $_POST['estado'];
        $endereco = $_POST['endereco'];

        $sqlUpdate = "UPDATE usuarios SET nome='$nome', email='$email', telefone='$telefone', sexo='$sexo', data_nascimento='$data_nasc', cidade='$cidade', estado='$estado', endereco='$endereco' WHERE id='$id'";
        $result = $conexao->query($sqlUpdate);
        header('Location: sistema.php'); 
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cliente</title>
    <style>
        body{ font-family: Arial, Helvetica, sans-serif; background-image: linear-gradient(to right, rgb(20,147,220), rgb(17,54,71)); }
        .box{ color: white; position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%); background-color: rgba(0, 0, 0, 0.6); padding: 15px; border-radius: 15px; width: 20%; }
        fieldset{ border: 3px solid dodgerblue; }
        legend{ border: 1px solid dodgerblue; padding: 10px; text-align: center; background-color: dodgerblue; border-radius: 8px; }
        .inputBox{ position: relative; }
        .inputUser{ background: none; border: none; border-bottom: 1px solid white; outline: none; color: white; font-size: 15px; width: 100%; letter-spacing: 2px; }
        .labelInput{ position: absolute; top: 0px; left: 0px; pointer-events: none; transition: .5s; }
        .inputUser:focus ~ .labelInput, .inputUser:valid ~ .labelInput{ top: -20px; font-size: 12px; color: dodgerblue; }
        #data_nascimento{ border: none; padding: 8px; border-radius: 10px; outline: none; font-size: 15px; }
        #update{ background-image: linear-gradient(to right, rgb(0,92, 197), rgb(90, 20, 220)); width: 100%; border: none; padding: 15px; color: white; font-size: 15px; cursor: pointer; border-radius: 10px; }
    </style>
</head>
<body>
    <a href="sistema.php" style="color: white; text-decoration: none; padding: 10px;">Voltar</a>
    <div class="box">
        <form action="editar.php" method="POST">
            <fieldset>
                <legend><b>Editar Cliente</b></legend>
                <br>
                <div class="inputBox"><input type="text" name="nome" class="inputUser" value="<?php echo $nome;?>" required><label class="labelInput">Nome</label></div><br><br>
                <div class="inputBox"><input type="text" name="email" class="inputUser" value="<?php echo $email;?>" required><label class="labelInput">Email</label></div><br><br>
                <div class="inputBox"><input type="tel" name="telefone" class="inputUser" value="<?php echo $telefone;?>" required><label class="labelInput">Telefone</label></div>
                <p>Sexo:</p>
                <input type="radio" name="genero" value="feminino" <?php echo ($sexo == 'feminino') ? 'checked' : '';?> required> Feminino
                <input type="radio" name="genero" value="masculino" <?php echo ($sexo == 'masculino') ? 'checked' : '';?> required> Masculino
                <br><br>
                <label><b>Data de Nascimento:</b></label><input type="date" name="data_nascimento" id="data_nascimento" value="<?php echo $data_nasc;?>" required><br><br>
                <div class="inputBox"><input type="text" name="cidade" class="inputUser" value="<?php echo $cidade;?>" required><label class="labelInput">Cidade</label></div><br><br>
                <div class="inputBox"><input type="text" name="estado" class="inputUser" value="<?php echo $estado;?>" required><label class="labelInput">Estado</label></div><br><br>
                <div class="inputBox"><input type="text" name="endereco" class="inputUser" value="<?php echo $endereco;?>" required><label class="labelInput">Endereço</label></div><br><br>
                <input type="hidden" name="id" value="<?php echo $id;?>">
                <input type="submit" name="update" id="update" value="Salvar Alterações">
            </fieldset>
        </form>
    </div>
</body>
</html>