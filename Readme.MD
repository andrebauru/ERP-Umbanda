# Projeto de Controle de Gastos

Este projeto é um sistema de controle de gastos desenvolvido em PHP, com armazenamento de dados em MySQL. Ele oferece funcionalidades como registro e visualização de gastos, geração de relatórios, controle de investimentos, entre outros.

## Funcionalidades

- **Autenticação de Usuários**: Sistema de login e registro para acesso ao sistema.
- **Registro de Gastos**: Permite aos usuários registrar seus gastos e receitas.
- **Visualização de Gastos**: Os usuários podem visualizar os gastos registrados.
- **Geração de Relatórios**: Geração de relatórios em PDF com detalhamento de gastos e receitas.
- **Controle de Investimentos**: Registro e acompanhamento de investimentos realizados.
- **Estatísticas e Análises**: Visualização de estatísticas e análises sobre os gastos e receitas.
- **Backup e Restauração de Dados**: Funcionalidades para backup e restauração dos dados do sistema.

## Tecnologias Utilizadas

- **PHP**: Linguagem de programação para o backend.
- **MySQL**: Sistema de gerenciamento de banco de dados.
- **Bootstrap**: Framework para desenvolvimento de interfaces responsivas.
- **Chart.js**: Biblioteca para geração de gráficos.
- **Dompdf**: Biblioteca para geração de arquivos PDF.

## Estrutura de Arquivos

A estrutura de arquivos do projeto é organizada da seguinte forma:

projeto_controle_gastos/
├── db.php
├── criar_usuario.php
├── index.php
├── login.php
├── admin.php
├── registro_gastos.php
├── visualizar_gastos.php
├── gerar_pdf.php
├── composer.json
├── relatorio_gastos.php
├── grafico_gastos.php
├── logout.php
├── menu.php
├── estilo.css
├── criar_tabelas.sql
├── conexao.php
├── cabecalho.php
├── rodape.php
├── atualizar_item.php
├── excluir_item.php
├── editar_gasto.php
├── excluir_gasto.php
├── adicionar_operacional.php
├── visualizar_operacionais.php
├── editar_operacional.php
├── excluir_operacional.php
├── grafico_operacionais.php
├── atualizar_saldo.php
├── visualizar_saldo.php
├── dashboard.php
├── relatorio_completo.php
├── atualizar_usuario.php
├── visualizar_usuarios.php
├── excluir_usuario.php
├── adicionar_usuario.php
├── alterar_senha.php
├── relatorio_usuarios.php
├── configuracoes_sistema.php
├── relatorio_financeiro.php
├── backup_dados.php
├── restaurar_backup.php
├── relatorio_anual.php
├── relatorio_mensal.php
├── estatisticas_gastos.php
├── historico_transacoes.php
├── analise_categorica.php
├── previsao_orcamentaria.php
└── controle_investimentos.php

## Instruções de Uso

1. Clone o repositório ou baixe os arquivos do projeto.
2. Configure o banco de dados MySQL e execute o script `criar_tabelas.sql` para criar as tabelas necessárias.
3. Configure o arquivo `conexao.php` com as informações de acesso ao seu banco de dados.
4. Acesse o projeto através de um servidor PHP.

## Licença

Este projeto é distribuído sob a licença MIT.

AndreTsC