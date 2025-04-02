<?php
require_once __DIR__ . '/../../helpers/Sessao.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerex - Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body.dark-mode { background-color: #121212; color: white; }
        .dark-mode .card { background-color: #1e1e1e; color: white; }
    </style>
</head>
<body>
    <nav class="navbar navbar-dark bg-dark p-3">
        <span class="navbar-brand">Gerex</span>
        <button id="modoNoturno" class="btn btn-outline-light">Modo Noturno</button>
    </nav>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-4">
                <div class="card p-3">
                    <h5>Bem-vindo, <span id="usuarioNome">Fernando</span></h5>
                    <p><strong>Email:</strong> fernando@email.com</p>
                </div>
            </div>
            <div class="col-md-8">
                <div class="row text-center">
                    <div class="col-md-6">
                        <div class="card p-3">
                            <h6>Total de Credenciais</h6>
                            <h3 id="totalCredenciais">12</h3>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card p-3">
                            <h6>Última Modificação</h6>
                            <h3 id="ultimaModificacao">2024-03-30</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-4">
            <button class="btn btn-primary mb-3">Adicionar Credencial</button>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Serviço</th>
                        <th>Email</th>
                        <th>Senha</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>GitHub</td>
                        <td>user@github.com</td>
                        <td><span class="senha">********</span></td>
                        <td>
                            <button class="btn btn-sm btn-info mostrarSenha">👁</button>
                            <button class="btn btn-sm btn-warning copiarSenha">📋</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $("#modoNoturno").click(function() {
                $("body").toggleClass("dark-mode");
            });
        });
    </script>
</body>
</html>
