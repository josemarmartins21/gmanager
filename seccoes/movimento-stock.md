# Seccção de Categorias

**Versão:** 1.0.0

**Status:** Planejado

**Dependências:**
- Utilizadores.
---

# Objetivo

A secção de movimento de estoque tem como objectivo permitir maior controle do estquq por conta dos
gestores. Ele poderá possibilitar reajustar, actualizar o estoque actual detalhando cada interação.

---

# Problema

Sem um painel de gestão de estoque o sistema estaria limitado a conceber actualização do
estoque de um produto directamente na seção de produtos, o que não atenderia todas as necessidades reais
da empresa. Fazendo com que não haja um rastreamento coerente das entradas, percas, rejustes do estoque da cantina.

Isso resulta em:

- Falta de contexto sobre o estoque actual;
- Inexistência de histórico de percas, reajuste de produto;
- Dificil identificação de que tipo de produto mais gera lucro.
---

# Objetivos do Módulo

- Permitir registar entrada, reajuste, percas de estoque;
- Fornecer contexto sobre cada movimentação do estoque da cantina.
---
# Usuários

| Perfil | Acesso |
|---------|--------|
| Administrador | Completo |

## User Stories

### 📦 Módulo de Produtos
US-01: Como gestor, quero poder registar entradas, percas reajuste e deixar uma nota
a explicar de que modo ocorreu cada uma dessas movimentação.

---
# Funcionalidades
A secção deverá apresentar:

- Deverá listar movimentações de estoque em formato de tabela;
- Permitir: adicionar, excluir, editar reajuste de estoque.

---

# Requisitos Funcionais

## RF001
Criar, excluir, actualizar, editar movimentações de estoque.

## RF002
Gerar Pdf com as movimentações de um determinado intervalo de tempo.

# Regras de Negócio

## RN001
Cada movimentção deve estar ou não vinculada a um usuário.


# Fluxo determinado
```
┌──────────────────────┐
│ 1. Acessar o Módulo  │
└──────────┬───────────┘
           │
           ▼
┌─────────────────────────┐
│ 2. Listar Movimentações │
└──────────┬──────────────┘
           │
           ├──────────────────┐
           ▼                  ▼
   Nova Movimentação      Visualizar Movimentação
           │                  │
           ▼                  |
┌───────────────────┐         |
│ Criar Movimentação│         |
└────────┬──────────┘         | 
         │                    |
         ▼                    | 
 Preencher Formulário     Escolher Ação
         │                    │
         ▼                    ├───────────────┐
 Validar Dados                │               │
         ▼                    ▼               ▼
Incrementar/Decrementar Editar Movimentação   Excluir Movimentação
Qtd do Produto                │               │
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
```