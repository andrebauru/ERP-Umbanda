<?php
declare(strict_types=1);
session_start();

const APP_NAME = 'Minha Vida Financeira';

function db(): PDO {
    static $pdo;
    if ($pdo instanceof PDO) return $pdo;
    $host = getenv('DB_HOST') ?: '127.0.0.1';
    $name = getenv('DB_NAME') ?: 'controle_gastos';
    $user = getenv('DB_USER') ?: 'root';
    $pass = getenv('DB_PASS') ?: '';
    try {
        $pdo = new PDO("mysql:host={$host};dbname={$name};charset=utf8mb4", $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
        return $pdo;
    } catch (PDOException $e) {
        http_response_code(500);
        die('<h1>Banco de dados indisponível</h1><p>Configure DB_HOST, DB_NAME, DB_USER e DB_PASS e execute criar_tabelas.sql.</p>');
    }
}
function e(mixed $v): string { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
function csrf(): string { if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32)); return $_SESSION['csrf']; }
function check_csrf(): void { if (!hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf'] ?? '')) { http_response_code(419); exit('Token de segurança inválido.'); } }
function flash(string $type, string $msg): void { $_SESSION['flash'][] = [$type, $msg]; }
function flashes(): array { $f = $_SESSION['flash'] ?? []; unset($_SESSION['flash']); return $f; }
function redirect(string $url): never { header('Location: '.$url); exit; }
function user(): ?array { return $_SESSION['user'] ?? null; }
function require_login(): void { if (!user()) redirect('login.php'); }
function require_admin(): void { require_login(); if (user()['perfil'] !== 'admin') { http_response_code(403); exit('Acesso restrito ao administrador.'); } }
function money(float|int $v): string { return 'R$ '.number_format((float)$v, 2, ',', '.'); }
function layout_start(string $title): void {
    $u=user(); $active=basename($_SERVER['PHP_SELF']);
    ?><!doctype html><html lang="pt-BR"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
    <title><?=e($title)?> · <?=APP_NAME?></title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"><link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet"><link href="estilo.css" rel="stylesheet"></head><body>
    <?php if($u): ?><nav class="navbar navbar-dark bg-primary sticky-top"><div class="container-fluid"><a class="navbar-brand fw-bold" href="dashboard.php"><i class="bi bi-wallet2"></i> <?=APP_NAME?></a><span class="text-white">Olá, <?=e($u['nome'])?> <a class="btn btn-sm btn-light ms-2" href="logout.php">Sair</a></span></div></nav><div class="container-fluid"><div class="row"><aside class="col-lg-2 sidebar p-3"><a href="dashboard.php"> <i class="bi bi-grid"></i> Dashboard</a><a href="registro_gastos.php"><i class="bi bi-plus-circle"></i> Lançamentos</a><a href="visualizar_gastos.php"><i class="bi bi-list-ul"></i> Transações</a><a href="controle_investimentos.php"><i class="bi bi-graph-up-arrow"></i> Investimentos</a><a href="relatorio_financeiro.php"><i class="bi bi-bar-chart"></i> Relatórios</a><?php if($u['perfil']==='admin'): ?><hr><a href="admin.php"><i class="bi bi-shield-lock"></i> Administração</a><a href="backup_dados.php"><i class="bi bi-database"></i> Backup</a><?php endif; ?><a href="alterar_senha.php"><i class="bi bi-key"></i> Minha senha</a></aside><main class="col-lg-10 p-4"><?php else: ?><main class="container py-5"><?php endif; ?>
    <?php foreach(flashes() as [$t,$m]): ?><div class="alert alert-<?=e($t)?> alert-dismissible fade show"><?=e($m)?><button class="btn-close" data-bs-dismiss="alert"></button></div><?php endforeach; ?><h1 class="h3 mb-4"><?=e($title)?></h1><?php
}
function layout_end(): void { ?></main><?php if(user()): ?></div></div><?php endif; ?><footer class="text-center text-muted py-4">© <?=date('Y')?> <?=APP_NAME?> · Finanças com clareza</footer><script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script></body></html><?php }
function post(string $key, string $default=''): string { return trim((string)($_POST[$key] ?? $default)); }
