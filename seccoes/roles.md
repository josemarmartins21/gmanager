# Seccção de Categorias

**Versão:** 1.0.0

**Status:** Planejado

**Dependências:**
- Permissões.
---

# Objetivo

A secção de role vai permitir que o admin reenventi as permissões de cada cargo
possibilitrá criarm editar, excluir roles e permissions.

---

# Problema

Sem uma secção de roles os admins não seriam capazes de criar
cargos sobre medida inviabilizando a restrição de partes especificas
dos sistema a um tipo utilizador forçando assim a conceder permissões que 
não encaixam com o perfil do usuário.

Isso resulta em:

- Pouca flexibilidade ao conceder permissões;
- Sistema que não acompanha a dinâmica da empresa;
---

# Objetivos do Módulo

- Centrailizar a gestão de roles e permissões;
---
# Usuários

| Perfil | Acesso |
|---------|--------|
| Administrador | Completo |

## User Stories
### 📦 Módulo de Produtos

US-01: Como gestor, admin quero poder criar roles personalizadas
para usuários especificos.

---
# Funcionalidades
A secção deverá apresentar:

- Criação, deleção, listagem em tabela, edição de roles;
- Asscição de role com permissão.

---

# Requisitos Funcionais

## RF001
Gestão das roles (CRUD).

# Regras de Negócio

## RN001
Uma role não pode existir sem possuir permissão.
## RN002
Uma permissão deve estar estritamente associada a uma role.

# Fluxo determinado
```
┌──────────────────────┐
│ 1. Acessar o Módulo  │
└──────────┬───────────┘
           │
           ▼
┌────────────────────────┐
│ 2. Listar Roles        │
└──────────┬─────────────┘
           │
           ├───────────────┐
           ▼               ▼
        Novo Role      Visualizar Role
           │                  │
           ▼                  |
┌───────────────────┐         |
│ Criar Role        │         |
└────────┬──────────┘         | 
         │                    |
         ▼                    | 
 Preencher Formulário     Escolher Ação
         │                    │
         ▼                    ├───────────────┐─────────────┐
 Validar Dados                │               │             │
         │                    ▼               ▼             ▼
         ▼              Editar Role   Excluir Role      Escolher Permissão (modal)
         │                    │               │             │
         ▼                    ▼               ▼             ▼
 Associar permission(read)  Confirmar Role   Confirmar Assoiação
         │                    │               │             │
         |                    ▼               ▼             ▼
 Salvar no Banco             Atualizar Banco       Remover     Atualidzar Banco
         │                    │               │              │
         └──────────────┬─────┴───────────────┘──────────────┘
                        ▼
                Atualizar Listagem
                        │
                        ▼
                  Encerrar Módulo
```