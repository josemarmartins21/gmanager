# Serviço de permissões

**Versão:** 1.0.0

**Status:** Planejado

**Dependências:**
Sem dependêcias.
---

# Objetivo

Permitir ter acesso as permissões disponivél na hora de criar
um novo utilizador.

---

# Problema

Sem um serviço de permissões o sistema não poderia ser capaz de distinguir
que acesso cada utilizador deve possuir.

Isso resulta em:

- Acessos indevido, fraude, etc.
---

# Objetivos do Serviço

- Interação com as permissões;
---
# Usuários

| Perfil | Acesso |
|---------|--------|
| Administrador | Completo |

## User Stories
### 📦 Serviço de Permissões

US-01: Como admin quero decidir que area cada utilizador pode acessar.

---
# Funcionalidades
O serviço deverá apresentar:

- Listagem de permissões;
- Asscição de permissões com usuário;
- Desasscição de permissões com usuário.

---

# Requisitos Funcionais

## RF001
Listar permissões no bloco de form de criação de utilizador.

## RF002
Associar multiplas permissões a um usuário.
