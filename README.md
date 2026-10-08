# Store App

Aplicação de loja virtual desenvolvida com Laravel 12, como projeto do ebook *Laravel 12: Criando Apps Web*. Ela tem uma vitrine pública com carrinho e checkout, uma área do cliente para acompanhar pedidos e um painel administrativo para gerenciar o catálogo, os usuários e os pedidos.

## Funcionalidades

### Loja (área pública)
- Vitrine de produtos em `/loja` e página de detalhe de cada produto (`/product/{slug}`)
- Carrinho de compras: adicionar e remover itens e cancelar o carrinho
- Cadastro e login de usuários

### Área do cliente (requer login)
- Checkout e finalização do pedido, com página de confirmação
- Listagem dos próprios pedidos em `/customers/my-orders`, com opção de cancelamento

### Painel administrativo (`/admin`)
Acesso restrito a usuários com o papel `ROLE_ADMIN`.
- Dashboard
- CRUD de produtos, com upload e remoção de fotos
- CRUD de categorias (cada produto pode ter várias categorias)
- CRUD de usuários
- Gestão de pedidos: listagem, edição e exclusão

## Tecnologias utilizadas

### Back-end
- **[PHP](https://www.php.net/)** ^8.2
- **[Laravel](https://laravel.com/)** ^12.0 (Eloquent ORM, Blade, Migrations, Factories e Seeders, Queues)
- **[Laravel Tinker](https://github.com/laravel/tinker)**: REPL para interagir com a aplicação
- **[MySQL](https://www.mysql.com/)**: banco de dados (`store_app`); sessões, cache e filas usam o driver `database`

### Front-end
- **[Blade](https://laravel.com/docs/blade)**: templates e componentes de view
- **[Tailwind CSS](https://tailwindcss.com/)** ^4.1 (via `@tailwindcss/vite`)
- **[Vite](https://vitejs.dev/)** ^6.0 com **[laravel-vite-plugin](https://github.com/laravel/vite-plugin)**: build dos assets
- **[Axios](https://axios-http.com/)**: requisições HTTP
- **[Bunny Fonts](https://fonts.bunny.net/)**: fonte Inter

### Desenvolvimento e testes
- **[PHPUnit](https://phpunit.de/)** ^11.5: testes automatizados
- **[Mockery](https://github.com/mockery/mockery)**: mocks para testes
- **[Faker](https://fakerphp.org/)**: dados fictícios para factories e seeders
- **[Laravel Pint](https://laravel.com/docs/pint)**: padronização de código
- **[Laravel Sail](https://laravel.com/docs/sail)**: ambiente Docker
- **[Laravel Pail](https://github.com/laravel/pail)**: visualização de logs no terminal
- **[Collision](https://github.com/nunomaduro/collision)**: relatórios de erro no console
- **[Concurrently](https://github.com/open-cli-tools/concurrently)**: executa servidor, fila e Vite juntos (`composer dev`)

## Pré-requisitos

- PHP 8.2 ou superior
- Composer
- Node.js e npm
- MySQL

## Instalação

1. Instale as dependências do PHP e do JavaScript:

   ```bash
   composer install
   npm install
   ```

2. Crie o arquivo de ambiente e gere a chave da aplicação:

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. Crie no MySQL um banco chamado `store_app` e, se necessário, ajuste as variáveis `DB_*` no `.env`.

4. Execute as migrations e popule o banco com dados de exemplo (10 usuários e 30 produtos com fotos):

   ```bash
   php artisan migrate --seed
   ```

5. Crie o link público do storage, necessário para exibir as fotos dos produtos:

   ```bash
   php artisan storage:link
   ```

## Executando o projeto

Para subir o servidor, o worker de filas e o Vite de uma vez:

```bash
composer dev
```

A aplicação fica disponível em http://localhost:8000. A rota `/` redireciona para a tela de login, e a loja fica em `/loja`.

Para gerar os assets de produção:

```bash
npm run build
```

## Acesso ao painel administrativo

Todo usuário é criado com o papel `ROLE_CUSTOMER`. Os usuários gerados pelo seeder usam a senha `password`. Para promover um deles a administrador, use o Tinker:

```bash
php artisan tinker
```

```php
App\Models\User::first()->forceFill(['role' => 'ROLE_ADMIN'])->save();
```

Depois, faça login com o e-mail desse usuário e acesse `/admin`.

## Testes

```bash
php artisan test
```

## Licença

Projeto distribuído sob a [licença MIT](https://opensource.org/licenses/MIT).
