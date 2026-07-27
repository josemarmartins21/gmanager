# Seccção de Categorias

**Versão:** 1.0.0

**Status:** Planejado

**Dependências:**
- Utilizadores.
---

# Objetivo

A secção de categorias tem como proposito permitir que
o gestor possa gerenciar categorias e permitindo
assim que os produtos possam ser agrupados por categoria e tornar
mais trivial a busca por produtos de um tipo e dar insights sobre o perfil dos produtos que mais vendem.

---

# Problema

Sem um painel de categorias o sistema estaria limitado a um número restrito de 
categorias o que inviabilizaria o agrupamento de produtos não associados a uma
categoria pré-cadastrada.

Isso resulta em:

- Dificil distinção entre produtos;
- Listagem de produtos exclusivamente poluida;
- Dificil identificação de que tipo de produto mais gera lucro.
---

# Objetivos do Módulo

- Gestão das informações das categorias;
- Listagem das categorias disponiveis;
---
# Usuários

| Perfil | Acesso |
|---------|--------|
| Administrador | Completo |

## User Stories
### 📦 Módulo de Produtos
US-01: Como gestor, quero poder criar categorias para poder fazer um distinção mais rica dos produtos
comercializados.

---
# Funcionalidades
A secção deverá apresentar:

- Criação, deleção, listagem em tabela, edição;

---

# Requisitos Funcionais

## RF001
Gestão de informações da categoria (CRUD).

# Regras de Negócio

## RN001
Categoria só pode ser excluida caso haja zero produtos 
associada a ela.
## RN002
Categoria pode existir sem estar associada a um criador (usuário).

# Fluxo determinado

┌──────────────────────┐
│ 1. Acessar o Módulo  │
└──────────┬───────────┘
           │
           ▼
┌────────────────────────┐
│ 2. Listar Categorias   │
└──────────┬─────────────┘
           │
           ├───────────────┐
           ▼               ▼
   Novo Categoria      Visualizar Categoria
           │                  │
           ▼                  |
┌───────────────────┐         |
│ Criar Categoria   │         |
└────────┬──────────┘         | 
         │                    |
         ▼                    | 
 Preencher Formulário     Escolher Ação
         │                    │
         ▼                    ├───────────────┐
 Validar Dados                │               │
         │                    ▼               ▼
         ▼              Editar Categoria   Excluir Categoria
         │                    │               │
         ▼                    ▼               ▼
 Salvar no Banco        Validar Dados    Confirmar Exclusão
         │                    │               │
         |                    ▼               ▼
         |            Atualizar Banco       Remover
         │                    │               │
         └──────────────┬─────┴───────────────┘
                        ▼
                Atualizar Listagem
                        │
                        ▼
                  Encerrar Módulo
