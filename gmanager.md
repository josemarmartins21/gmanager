# GManager 
- Versão 1.0.0

Gmanager será um sistema de gestão de estoque
de bares pequenos, será construido com foco em usabilidade,
escalabilidade e peformance.

O sistema terá os seguintes modúlos:

## User Stories
### 📦 Módulo de Produtos e Stock
US-01: Como operador, quero registar a entrada de produtos informando o número de caixas/volumes e quantas unidades contêm, para alimentar o stock em unidades individuais.

US-02: Como operador, quero categorizar os produtos (ex: "Bebidas", "Cigarros") e atribuir um preço de venda fixo por unidade.

US-03: Como operador, quero consultar o stock atual e receber alertas visuais quando um produto estiver abaixo do limite mínimo.

### 🛒 Módulo de Vendas (Registo Rápido)
US-04: Como operador, quero selecionar produtos numa grelha visual com botões grandes e registar a venda apenas selecionando a quantidade.

US-05: Como operador, quero ver o valor total da conta atual para poder informar o cliente verbalmente.

US-06: Como operador, quero confirmar a venda com 1 clique para que o stock seja abatido imediatamente.
### 📊 Módulo de Relatórios e Ajustes
US-07: Como proprietário, quero ver um resumo simples de vendas do dia (total faturado e unidades vendidas por produto).

US-08: Como proprietário, quero dar baixa manual no stock para ajustar contagens ou registar garrafas partidas/perdas.

## Moncks

### Como fica o Ecrã de Vendas (POS)

+-----------------------------------------------------------------------+
|  Módulo de Vendas Rápida                                              |
+-----------------------------------+-----------------------------------+
|  [ Bebidas ]   [ Cigarros ]       |  Carrinho / Saída Atual          |
|                                   |                                   |
|  +--------------+ +-------------+ |  • 2x Cuca / Sagres     800 Kz    |
|  | Cuca / Sagres| |  Coca-Cola  | |  • 1x Marlboro Box    1.200 Kz    |
|  |   400 Kz     | |   500 Kz    | |                                   |
|  +--------------+ +-------------+ |                                   |
|  +--------------+ +-------------+ |                                   |
|  | Marlboro Box | | Dunhill Red | |  -------------------------------  |
|  |  1.200 Kz    | |  1.500 Kz   | |  TOTAL:               2.000 Kz    |
|  +--------------+ +-------------+ |                                   |
|                                   |  [ REGISTAR VENDA ]  [ CANCELAR ] |
+-----------------------------------+-----------------------------------+

## Requisitos Funcionais/Não Funcionais

### Funcionais

**RF-01:** O sistema deve ser capaz de cadastrar, editar, excluir, buscar
**produtos** na base de dados.
***
**RF-02:** O sistema deve ser capaz de registrar, editar, excluir, buscar
vendas por data na base de dados.
***
**RF-03** O sistema deve poder registar multiplos produtos em uma única
venda.
***
**RF-04** O sistema deve enviar um email ao gerente assim que estoque de um produto
atingir o valor definido de estoque mínimo.
***
**RF-05** O sistema deve emitir relatório diário de forma automatizada.
***
**RF-06** O sistema deve ser capaz de monitorar todas as entradas e saidas no estoque.
Ele deve permitir: registar entrada, perda, ajuste manualmente.

### Não Funcionais
**RNF-01:** o sistema deve ser totalmente responsivo (mobile, tablet, PC)
***
**RNF-02:** o sistema não pode estar vulneravel
a multiplas tentativas de login em um curto espaço de tempo
*** 

## Estrutura da base de dados
### Entidades
- Produto
- Venda
- ItemVenda
- EstoqueMovimento
- Categoria
- Usuário
- Permissoes
- permissoes_ususuario
### M.E.R

Produtos(
    name, 
    category_id, 
    price, 
    is_active,  
    box_price, 
    current_stock, 
    min_stock, 
    created_at, 
    updated_at,
    user_id
)
***
Venda(total, user_id, created_at)
***
ItemVenda(
    produto_id, 
    venda_id, 
    subtotal, 
    qty
)
***
Categoria(name, user_id)
***
EstoqueMovimento(
    type, 
    box_qty, 
    units_per_box, 
    notes, 
    created_at, 
    total_units
    product_id
)
***
Permissoes(name)
***
permissoes_usuario(usuario_id, permissao_id)
***

## Funções por Modúlo

### Productos
- Gerenciar Produto (CRUD)
- Envio de email de stock abaixo da qtd mínima
- Lista de produtos em Pdf
***
### Categoria
- Gerenciar Categoria (CRUD)
***
### Vendas
- Gerenciar Vendas (CRUD)
- Marcar venda como paga ou não paga
- Não fechamento de venda exclusivo a admins
- Exclusão de um item da venda restrita a
operadores de caixa.
- Sistema deve emitir relatório de venda assim que forem 22h.
Detalhando o fluxo de vendas naquele dia.
### EstoqueMovimento
- Gerenciar EstoqueMovimento (CRUD)
- Manipulação de EstoqueMovimento exclusiva a admins
### Gestão de usuários
- Permitir admins concederem permissoes de:
    - Editar produto/venda;
    - Deletar produto/venda;
    - Ler produto/venda;
    - Criar produto/venda.
- Tipos de usuários
    - Admins;
    - User Default