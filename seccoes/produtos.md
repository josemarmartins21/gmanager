# Seccção de Produtos

**Versão:** 1.0.0

**Status:** Em Planejamento

**Dependências:**

- Categorias;
- Utilizadores.


---

# Objetivo

A secção de produtos é a razão de existencia do GManager.

Seu objetivo é fornecer aos gestores de caixa a possibilidade de trazerem
os produtos físico para o mundo virtual, tornando assim mais fácil o monitaramento da saúde
da cantina.

---

# Problema

Sem um painel de produtos os gestores ficaram impossibilitados de informatizar
as informações referente ao produto principal da empresa.

Isso resulta em:

- Perda de informações;
- Incertezas sobre o estado dos produtos da empresa;
- Contagem constante do stock;
- Termino de stock inesperados.

---

# Objetivos do Módulo

- Gestão das informações dos produtos;
- Agrupamento de produtos por categoria;
- Alertar o gerente para reposição do stock.
---
# Usuários

| Perfil | Acesso |
|---------|--------|
| Administrador | Completo |
| Default | Parcial |

## User Stories
### 📦 Módulo de Produtos
US-01: Como gestor, quero registar a entrada de produtos informando o número de caixas/volumes e quantas unidades contêm, para alimentar o stock em unidades individuais.
***
US-02: Como operador de caixa, quero poder ter acesso a um UI intuitiva para ter noção de quais produtos estão a minha disposição.


---
# Funcionalidades
A secção deverá apresentar:

- Filtrar produtos por categoria;
- Criação, deleção, buscar, edição, activação de produtos;
- Botão de geração de tabela de produtos em Pdf;
- Upload de imagem do produto.

---

# Requisitos Funcionais

## RF001
Gestão de informações do produto.

## RF002
Geração de Pdf com a uma lista de produtos.

## RF003
Envio de alerta de produto abaixo do stock.


# Regras de Negócio

## RN001

Um produto não pode existir sem estar associado a uma categoria

## RN002
Um utilizador default não pode excluir, editar dados de um
produto, pode simplismente consultar.

# Fluxo determinado
<pre>
┌──────────────────────┐
│ 1. Acessar o Módulo  │
└──────────┬───────────┘
           │
           ▼
┌──────────────────────┐
│ 2. Listar Produtos   │
└──────────┬───────────┘
           │
           ├───────────────┐
           ▼               ▼
   Novo Produto      Selecionar Produto
           │               │
           ▼               ▼
┌─────────────────┐  ┌──────────────────┐
│ Criar Produto   │  │ Visualizar Dados │
└────────┬────────┘  └─────────┬────────┘
         │                     │
         ▼                     ▼
 Preencher Formulário     Escolher Ação
         │                     │
         ▼                     ├───────────────┐
 Validar Dados                │               │
         │                    ▼               ▼
         ▼              Editar Produto   Excluir Produto
         │                    │               │
         ▼                    ▼               ▼
 Salvar no Banco        Validar Dados    Confirmar Exclusão
         │                    │               │
         |                    ▼               ▼
         |            Atualizar Banco  Remover/Inativar
         │                    │               │
         └──────────────┬─────┴───────────────┘
                        ▼
                Atualizar Listagem
                        │
                        ▼
               Pesquisar / Filtrar
                        │
                        ▼
              Exportar / Imprimir
                        │
                        ▼
                  Encerrar Módulo
</pre>