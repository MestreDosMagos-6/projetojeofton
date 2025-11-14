<?php

try {
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8", $dbUsername, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}

$id = $_GET['id'] ?? null;

if ($id) {
    $sql = "SELECT * FROM usuarios WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$usuario) {
        die("Usuário não encontrado.");
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $endereco = $_POST['endereco'];
    
    try {
        $sql = "UPDATE usuarios SET nome = ?, email = ?, telefone = ?, endereco = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nome, $email, $telefone, $endereco, $id]);
        
        $success = "Usuário atualizado com sucesso!";
        
        $sql = "SELECT * FROM usuarios WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        $error = "Erro ao atualizar usuário: " . $e->getMessage();
    }
}
?>

<div class="form-container">
    <h2>Editar Usuário</h2>
    
    <?php if (isset($success)): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>
    
    <?php if (isset($error)): ?>
        <div class="alert alert-error"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <?php if ($usuario): ?>
        <form method="POST">
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($usuario['nome']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($usuario['email']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="telefone">Telefone:</label>
                <input type="text" id="telefone" name="telefone" value="<?php echo htmlspecialchars($usuario['telefone']); ?>">
            </div>
            
            <div class="form-group">
                <label for="endereco">Endereço:</label>
                <textarea id="endereco" name="endereco"><?php echo htmlspecialchars($usuario['endereco']); ?></textarea>
            </div>
            
            <button type="submit" class="btn btn-primary">Atualizar</button>
            <a href="formulario.php" class="btn">Voltar</a>
        </form>
    <?php else: ?>
        <p>Usuário não encontrado.</p>
    <?php endif; ?>
</div>