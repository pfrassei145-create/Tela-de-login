<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Models\Usuario;
use App\Services\LoginService;

session_start();

$usuarioLogado = $_SESSION['usuario'] ?? null;
$mensagemErro = '';

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: /');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rm = trim($_POST['rm'] ?? '');
    $senha = trim($_POST['senha'] ?? '');

    $loginService = new LoginService();
    $usuario = $loginService->autenticar($rm, $senha);

    if ($usuario instanceof Usuario) {
        $_SESSION['usuario'] = $usuario;
        $usuarioLogado = $usuario;
    } else {
        $mensagemErro = 'RM ou senha inválidos.';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login PHP</title>
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #2d2d62, #6c5ce7);
            margin: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #222;
        }
        .card {
            background: #fff;
            padding: 32px;
            border-radius: 12px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.25);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-top: 12px;
            font-weight: bold;
        }
        input {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }
        button {
            width: 100%;
            margin-top: 16px;
            padding: 12px;
            border: none;
            background: #6c5ce7;
            color: white;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
        }
        .erro {
            color: #d63031;
            text-align: center;
            margin-top: 12px;
            font-weight: bold;
        }
        .dados {
            background: #f5f5ff;
            border: 1px solid #d9d9f2;
            padding: 12px;
            border-radius: 8px;
            margin-top: 14px;
        }
        .sair {
            display: inline-block;
            margin-top: 18px;
            text-decoration: none;
            color: #6c5ce7;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="card">
        <?php if ($usuarioLogado instanceof Usuario): ?>
            <h2>Usuário autenticado</h2>
            <div class="dados">
                <p><strong>Nome:</strong> <?= htmlspecialchars($usuarioLogado->getNome()); ?></p>
                <p><strong>RM:</strong> <?= htmlspecialchars($usuarioLogado->getRm()); ?></p>
                <p><strong>Perfil:</strong> <?= htmlspecialchars($usuarioLogado->getPerfil()); ?></p>
                <p><strong>Classe:</strong> <?= htmlspecialchars(get_class($usuarioLogado)); ?></p>
                <p><strong>Hash da instância:</strong> <?= htmlspecialchars(spl_object_hash($usuarioLogado)); ?></p>
                <p><strong>Resumo:</strong> <?= htmlspecialchars($usuarioLogado->resumo()); ?></p>
                <pre><?= htmlspecialchars(print_r($usuarioLogado->dadosDaInstancia(), true)); ?></pre>
            </div>
            <a class="sair" href="?logout=1">Sair</a>
        <?php else: ?>
            <h2>Login</h2>
            <form method="POST">
                <label for="rm">RM</label>
                <input type="text" id="rm" name="rm" placeholder="Digite seu RM" required>

                <label for="senha">Senha</label>
                <input type="password" id="senha" name="senha" placeholder="Digite sua senha" required>

                <button type="submit">Entrar</button>
            </form>

            <?php if ($mensagemErro !== ''): ?>
                <p class="erro"><?= htmlspecialchars($mensagemErro); ?></p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</body>
</html>
