<?php
    session_start();
    include_once('conexao.php');

    // Proteção: Se não estiver logado, chuta de volta pro login
    if((!isset($_SESSION['logged_in']) == true) and (!isset($_SESSION['username']) == true)){
        unset($_SESSION['logged_in']);
        unset($_SESSION['username']);
        header('Location: tela-de-login.html');
    }
    $logado = $_SESSION['username'];

    // BUSCA (READ): Pega todos os usuários do banco (SEM FILTRO DE PESQUISA AINDA)
    $sql = "SELECT * FROM usuarios ORDER BY id DESC";
    $result = $conexao->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema - Lista de Clientes</title>
    <style>
        body{
            font-family: Arial, Helvetica, sans-serif;
            background-image: linear-gradient(to right, rgb(20,147,220), rgb(17,54,71));
            color: white;
            text-align: center;
        }
        .table-bg{
            background-color: rgba(0,0,0,0.6);
            border-radius: 15px 15px 0 0;
            padding: 20px;
            margin: 20px auto;
            width: 90%;
        }
        table{
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td{
            padding: 12px;
            border-bottom: 1px solid rgba(255,255,255,0.3);
            text-align: left;
        }
        th{
            background-color: rgba(255,255,255,0.1);
            color: dodgerblue;
        }
        .btn{
            padding: 8px 15px;
            text-decoration: none;
            color: white;
            border-radius: 5px;
            font-size: 14px;
            margin: 2px;
            display: inline-block;
        }
        .btn-primary{ background-color: dodgerblue; border: 1px solid dodgerblue; }
        .btn-danger{ background-color: crimson; border: 1px solid crimson; }
        .btn-success{ background-color: mediumseagreen; border: 1px solid mediumseagreen; font-weight: bold; padding: 10px 20px;}
        
        .navbar{
            background-color: rgba(0,0,0,0.5);
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <span>Bem vindo, <b><?php echo $logado; ?></b></span>
        <div class="d-flex">
            <a href="tela-de-login.html" class="btn btn-danger">Sair</a>
        </div>
    </div>

    <br>
    <h1>Clientes Cadastrados</h1>
    <br>
    <a href="formulario.php" class="btn btn-success">+ Adicionar Novo Cliente</a>
    
    <div class="table-bg">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Telefone</th>
                    <th>Sexo</th>
                    <th>Cidade</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    // LOOP para mostrar cada usuário
                    while($user_data = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>".$user_data['id']."</td>";
                        echo "<td>".$user_data['nome']."</td>";
                        echo "<td>".$user_data['email']."</td>";
                        echo "<td>".$user_data['telefone']."</td>";
                        echo "<td>".$user_data['sexo']."</td>";
                        echo "<td>".$user_data['cidade']."</td>";
                        echo "<td>
                            <a class='btn btn-primary' href='editar.php?id=$user_data[id]'>✏️ Editar</a>
                            <a class='btn btn-danger' href='excluir.php?id=$user_data[id]' onclick='return confirm(\"Tem certeza que deseja excluir?\")'>🗑️ Excluir</a>
                        </td>";
                        echo "</tr>";
                    }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>