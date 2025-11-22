<?php
    session_start();
    include_once('conexao.php');

    // Proteção de Sessão
    if((!isset($_SESSION['logged_in']) == true) and (!isset($_SESSION['username']) == true)){
        unset($_SESSION['logged_in']);
        unset($_SESSION['username']);
        header('Location: tela-de-login.html');
    }
    $logado = $_SESSION['username'];

    // --- LÓGICA DA PESQUISA (FINAL) ---
    if(!empty($_GET['search']))
    {
        $data = $_GET['search'];
        // Procura no ID, no Nome ou no Email
        $sql = "SELECT * FROM usuarios WHERE id LIKE '%$data%' or nome LIKE '%$data%' or email LIKE '%$data%' ORDER BY id DESC";
    }
    else
    {
        // Se não tiver pesquisa, traz tudo
        $sql = "SELECT * FROM usuarios ORDER BY id DESC";
    }
    
    $result = $conexao->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Controle</title>
    <style>
        body{
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-image: linear-gradient(to right, rgb(20,147,220), rgb(17,54,71));
            color: white;
            margin: 0;
        }
        
        /* Navbar */
        .navbar{
            background-color: rgba(0,0,0,0.5);
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0px 4px 10px rgba(0,0,0,0.3);
        }
        .brand { font-size: 1.5rem; font-weight: bold; }
        
        /* Barra de Pesquisa */
        .box-search{
            display: flex;
            justify-content: center;
            gap: 10px;
            margin: 30px 0;
        }
        #pesquisar{
            padding: 10px;
            border-radius: 5px;
            border: none;
            width: 300px;
            outline: none;
        }
        
        /* Tabela Estilizada */
        .table-bg{
            background-color: rgba(0,0,0,0.6);
            border-radius: 15px;
            padding: 20px;
            margin: 20px auto;
            width: 90%;
            box-shadow: 0px 0px 20px rgba(0,0,0,0.5);
            overflow-x: auto; 
        }
        table{
            width: 100%;
            border-collapse: collapse;
            min-width: 600px;
        }
        th, td{
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        th{
            background-color: rgba(255,255,255,0.05);
            color: dodgerblue;
            font-weight: 600;
        }
        tr:hover{
            background-color: rgba(255,255,255,0.05); 
            transition: 0.3s;
        }

        /* Botões */
        .btn{
            padding: 8px 15px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            border: none;
            transition: 0.3s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }
        .btn-primary{ background-color: dodgerblue; color: white; }
        .btn-primary:hover{ background-color: #006bb3; }
        
        .btn-danger{ background-color: crimson; color: white; }
        .btn-danger:hover{ background-color: #a30029; }
        
        .btn-success{ 
            background-color: mediumseagreen; 
            color: white; 
            font-weight: bold; 
            padding: 12px 25px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.2);
        }
        .btn-success:hover{ background-color: #2e8b57; transform: translateY(-2px);}

        .btn-edit { background-color: #ffc107; color: #333; }
        
        /* Ícones */
        .icon { font-style: normal; }
    </style>
</head>
<body>

    <div class="navbar">
        <div class="brand">🚀 Sistema Kernel</div>
        <div>
            <span style="margin-right: 15px;">Olá, <b><?php echo $logado; ?></b></span>
            <a href="tela-de-login.html" class="btn btn-danger">Sair</a>
        </div>
    </div>

    <br>
    
    <div style="text-align: center;">
        <h1>Gestão de Clientes</h1>
        <a href="formulario.php" class="btn btn-success"><i class="icon">➕</i> Novo Cliente</a>
    </div>

    <div class="box-search">
        <input type="search" class="form-control" placeholder="Pesquisar por Nome, Email ou ID" id="pesquisar">
        <button onclick="searchData()" class="btn btn-primary">
            <i class="icon">🔍</i> Pesquisar
        </button>
    </div>
    
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
                    <th style="text-align: center;">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if ($result->num_rows > 0) {
                        while($user_data = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>".$user_data['id']."</td>";
                            echo "<td>".$user_data['nome']."</td>";
                            echo "<td>".$user_data['email']."</td>";
                            echo "<td>".$user_data['telefone']."</td>";
                            echo "<td>".$user_data['sexo']."</td>";
                            echo "<td>".$user_data['cidade']."</td>";
                            echo "<td style='text-align: center;'>
                                <a class='btn btn-edit' href='editar.php?id=$user_data[id]' title='Editar'>✏️</a>
                                <a class='btn btn-danger' href='excluir.php?id=$user_data[id]' title='Excluir' onclick='return confirm(\"Tem certeza que deseja excluir?\")'>🗑️</a>
                            </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7' style='text-align:center;'>Nenhum resultado encontrado.</td></tr>";
                    }
                ?>
            </tbody>
        </table>
    </div>

    <script>
        var search = document.getElementById('pesquisar');

        search.addEventListener("keydown", function(event) {
            if (event.key === "Enter") {
                searchData();
            }
        });

        function searchData()
        {
            window.location = 'sistema.php?search=' + search.value;
        }
    </script>
</body>
</html>