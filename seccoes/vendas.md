# Seccção de Vendas

**Versão:** 1.0.0

**Status:** Em planejamento

**Dependências:**
- Utilizadores;
- Produtos;
- Items Vendas.
---

# Objetivo

A secção de vendas é secção responsavel por da vida ao GManager
nela será possivel registar vendas com a possibilidade de associa-la a multiplos
produtos.

---

# Problema

Sem um painel de vendas, o sistema ficaria refém de simplismente gerenciar produtos e nada mais além disso
e consequentemente não cumpriria com o proposito principal do sistema.

Isso resulta em:

- Sistema parcialmente funcional;
- Impossibilidade de acompanhar a performance de um determinado produto;
- Baixa manual do estoque do produto apenas.
---

# Objetivos do Módulo

- Gestão das vendas, possibilitar: editar, excluir, visualizar;
---
# Usuários

| Perfil | Acesso |
|---------|--------|
| Administrador | Completo |
| Default | Parcial |

## User Stories
### 📦 Módulo de Produtos
US-01: Como gestor, quero ter a possibilidade de confirmar exclusão de um item de uma
venda para evitar fraudes por parte do operador de caixa.

US-02: Como operador de caixa, quero poder fazer anotações explicando por que razão tal
venda não foi totalmente paga.

US-03: Como gestor, quero poder marcar uma venda como paga assim que o dinheiro
for completado por parte do cliente.

---
# Funcionalidades
A secção deverá apresentar:

## Gestão de vendas

- CRUD das vendas;
- Conclusão de pagamento de vendas.

---

# Requisitos Funcionais

## RF001
Gestão de vendas (CRUD)

## RF002
Permitir conceder desconto de determinada venda

## RF003
Conclusão de pagamento da vendas

## RF004
Registar kilapes

# Regras de Negócio

## RN001
Um operador de caixa não pode excluir item de uma venda

## RN002
Uma venda pode ser totalmente paga ao longo do tempo

# Fluxo determinado
```
┌──────────────────────┐
│ 1. Acessar o Módulo  │
└──────────┬───────────┘
           │
           ▼
┌────────────────────────┐
│ 2. Listar Vendas       │
└──────────┬─────────────┘
           │
           ├───────────────┐
           ▼               ▼
        Novo Venda      Visualizar Vendas
           │                  │
           ▼                  |
┌───────────────────┐         |
│ Criar Venda       │         |
└────────┬──────────┘         | 
         │                    |
         ▼                    | 
 Preencher Formulário     Escolher Ação
         │                    │
         ▼                    ├───────────────────────────────────────┐
 Validar Dados                │               │                       │
         │                    ▼               ▼                       |
        ▼              Editar Venda    Excluir Venda                  | 
         │                    │               │                       |
         ▼                    ▼               ▼                       ▼
 Salvar no Banco        Validar Dados    Confirmar Exclusão     Marcar Venda Como Totalmente Paga
         │                    │               │                       │
         |                    ▼               ▼                       ▼
         |            Atualizar Banco       Remover             Atualizar Status na BD
         │                    │               │                       |
         └──────────────┬─────┴───────────────┘───────────────────────┘
                        ▼
                Atualizar Listagem
                        │
                        ▼
                  Encerrar Módulo
```