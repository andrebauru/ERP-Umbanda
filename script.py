import os

# Lista de arquivos a serem criados
arquivos = [
    "db.php", "criar_usuario.php", "index.php", "login.php", "admin.php",
    "registro_gastos.php", "visualizar_gastos.php", "gerar_pdf.php", "composer.json",
    "relatorio_gastos.php", "grafico_gastos.php", "logout.php", "menu.php", "estilo.css",
    "criar_tabelas.sql", "conexao.php", "cabecalho.php", "rodape.php", "atualizar_item.php",
    "excluir_item.php", "editar_gasto.php", "excluir_gasto.php", "adicionar_operacional.php",
    "visualizar_operacionais.php", "editar_operacional.php", "excluir_operacional.php",
    "grafico_operacionais.php", "atualizar_saldo.php", "visualizar_saldo.php", "dashboard.php",
    "relatorio_completo.php", "atualizar_usuario.php", "visualizar_usuarios.php", "excluir_usuario.php",
    "adicionar_usuario.php", "alterar_senha.php", "relatorio_usuarios.php", "configuracoes_sistema.php",
    "relatorio_financeiro.php", "backup_dados.php", "restaurar_backup.php", "relatorio_anual.php",
    "relatorio_mensal.php", "estatisticas_gastos.php", "historico_transacoes.php", "analise_categorica.php",
    "previsao_orcamentaria.php", "controle_investimentos.php"
]

# Diretório onde os arquivos serão criados
diretorio = "projeto_controle_gastos"

# Cria o diretório se ele não existir
os.makedirs(diretorio, exist_ok=True)

# Cria cada arquivo na lista
for arquivo in arquivos:
    with open(os.path.join(diretorio, arquivo), 'w') as f:
        f.write("")  # Cria um arquivo vazio

print(f"Arquivos criados com sucesso no diretório '{diretorio}'.")
