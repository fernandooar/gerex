<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex justify-content-center align-items-center vh-100 bg-light">
    <div class="container border p-4 rounded shadow">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center">Cadastro</h2>

                <?php if (isset($_SESSION['erro'])): ?>
                    <div class="alert alert-danger"><?php echo $_SESSION['erro']; unset($_SESSION['erro']); ?></div>
                <?php endif; ?>

                <?php if (isset($_SESSION['sucesso'])): ?>
                    <div class="alert alert-success"><?php echo $_SESSION['sucesso']; unset($_SESSION['sucesso']); ?></div>
                <?php endif; ?>

                <form action="/gerex/src/Controllers/CadastroController.php" method="POST">
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="nome" name="nome" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <!-- <div class="mb-3">
                        <label for="confirmar_email" class="form-label">Confirmar E-mail</label>
                        <input type="email" class="form-control" id="confirmar_email" name="confirmar_email" required>
                    </div> -->
                    <div class="mb-3">
                        <label for="senha" class="form-label">Senha</label>
                        <input type="password" class="form-control" id="senha" name="senha" required>
                    </div>
                    <!-- <div class="mb-3">
                        <label for="confirmar_senha" class="form-label">Confirmar Senha</label>
                        <input type="password" class="form-control" id="confirmar_senha" name="confirmar_senha" required>
                    </div> -->
                    <button type="submit" class="btn btn-primary ">Cadastrar</button>
                </form>
                <p class="mt-3 text-center">Já tem uma conta? <a href="LoginView.php">Faça login</a></p>
            </div>
        </div>
    </div>
</body>
</html>
