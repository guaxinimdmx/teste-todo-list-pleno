# ✅ To-Do List - Projeto de Avaliação Técnica

Este projeto é uma aplicação **SPA simples** para gerenciamento de listas de tarefas, utilizando **CodeIgniter 4 (backend)** e **Vue.js via CDN (frontend)**.
O foco do teste é a API, autenticação e manipulação de dados via REST, com persistência em banco.

---

## 🚀 Como rodar o projeto

- Clone este repositório

```
git clone https://github.com/guaxinimdmx/teste-todo-list-pleno
```

- Configure o `.env` com as credenciais do banco

```
database.default.hostname = localhost
database.default.database = nome_do_banco
database.default.username = root
database.default.password = senha_do_banco
jwt.secret = senha_jwt
```

3. Execute o script SQL para criar a base de dados _(ou restaure o estras/db.sqlite)_

```
php spark migrate
php spark db.seed:run
```

4. Suba o servidor com o `spark serve`

```
php spark serve
```

5. Pronto
   **API** disponivel em `http://localhost:8080/api`
   **Frontend** disponível em `http://localhost:8080/front/app.html`

---

## 📦 Funcionalidades implementadas

- Login com autenticação JWT (expiração de 2h)
- Listagem de listas e tarefas associadas
- Criação, renomeação e exclusão de listas
- Criação, renomeação, exclusão e conclusão de tarefas
- Interface reativa (Vue 3 via CDN)
- Consumo de API desacoplado (SPA em `/public/front`)
- Sistema preparado para múltiplos testes com várias listas/tarefas

---

## 🛠️ Tecnologias utilizadas

- **PHP 8.3 + CodeIgniter 4**
- **MySQL**
- **Vue.js 3 CDN**
- **SCSS** (arquivo original mantido)

---

## 🧪 Usuário para teste

```
Email: teste@teste.com
Senha: 1234
```

_implementado para testes de valição de token_

---

## 🧾 Observações

- Este front-end foi construído como uma SPA leve, **sem build tools**.
- Ele está **desacoplado** da aplicação PHP e consome a API REST via chamadas diretas.
- Ele dispónivel em **/public/front/app.hmtl** para facilitar os testes da aplicação.
- Pode ser movido para outro local ou servidor para testes.
- O layout foi mantido **minimalista** e sem frameworks. O arquivo original scss está na pasta do front.
