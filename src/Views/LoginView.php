<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Gerex</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="d-flex justify-content-center align-items-center vh-100 bg-light">
    
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card shadow p-4">
                    <h2 class="text-center mb-3">Acesse sua conta</h2>
                    
                    <!-- Exibir mensagens de erro ou sucesso
                    <?php if (isset($_GET['erro'])): ?>
                        <div class="alert alert-danger text-center">
                            <?php echo htmlspecialchars($_GET['erro']); ?>
                        </div>
                    <?php endif; ?> -->
                    <?php
                        if (isset($_GET['erro'])) {
                            switch ($_GET['erro']) {
                                case 'campos_vazios':
                                    echo '<p style="color: red;">Preencha todos os campos.</p>';
                                    break;
                                case 'credenciais_invalidas':
                                default:
                                    echo '<p style="color: red;">Email ou senha incorretos.</p>';
                                    break;
                            }
                        }
                    ?>
                    <form action="../controllers/LoginController.php" method="POST">
                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="senha" class="form-label">Senha</label>
                            <input type="password" class="form-control" id="senha" name="senha" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Entrar</button>
                    </form>

                    <div class="mt-3 text-center">
                    <a href="/gerex/index.php">Home</a> |
                        <a href="CadastroView.php">Criar conta</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
