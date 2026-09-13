<?php require_once 'app.php';
if (user()) redirect('dashboard.php');
$erro='';
if ($_SERVER['REQUEST_METHOD']==='POST') {
    check_csrf(); $email=filter_var(post('email'),FILTER_VALIDATE_EMAIL); $senha=(string)($_POST['senha']??'');
    if (!$email || $senha==='') $erro='Informe e-mail e senha.';
    else { $s=db()->prepare('SELECT * FROM usuarios WHERE email=? AND ativo=1'); $s->execute([$email]); $u=$s->fetch();
        if ($u && password_verify($senha,$u['senha'])) { session_regenerate_id(true); $_SESSION['user']=['id'=>(int)$u['id'],'nome'=>$u['nome'],'email'=>$u['email'],'perfil'=>$u['perfil']]; redirect('dashboard.php'); } else $erro='Credenciais inválidas.';
    }
}
layout_start('Entrar');
?><div class="card login-card p-4"><div class="text-center mb-3"><i class="bi bi-wallet2 text-primary fs-1"></i><h2>Bem-vindo</h2><p class="text-muted">Organize sua vida financeira</p></div><?php if($erro):?><div class="alert alert-danger"><?=e($erro)?></div><?php endif;?><form method="post"><input type="hidden" name="csrf" value="<?=csrf()?>"><label class="form-label">E-mail</label><input class="form-control mb-3" type="email" name="email" required autofocus><label class="form-label">Senha</label><input class="form-control mb-4" type="password" name="senha" required><button class="btn btn-primary w-100">Entrar</button></form></div><?php layout_end();