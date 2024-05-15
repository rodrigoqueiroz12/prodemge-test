## Pré-requisitos

Certifique-se de ter as seguintes ferramentas instaladas em sua máquina:

- [PHP](https://www.php.net/downloads.php) >= 8.2
- [Composer](https://getcomposer.org/download/)
- [Node.js](https://nodejs.org/) & [npm](https://www.npmjs.com/get-npm)
- [Laravel](https://laravel.com/)

## Instalação

Siga estas etapas para configurar o ambiente de desenvolvimento.

### Clonar o repositório

```bash
git clone https://github.com/rodrigoqueiroz12/prodemge-test.git

cd prodemge-test
```

### Instalar as dependências com composer

```
composer install
```

### Instalar as dependências com node

```
npm install
```

Atualize as variáveis do banco de dados no arquivo `.env`.

### Gerar a chave da aplicação

```
php artisan key:generate
```

### Migrar o banco de dados

```
php artisan migrate
```

### Compilar os assets

```
npm run dev
```

### Executar o servidor

```
php artisan serve
```

Agora você pode acessar a aplicação em http://localhost:8000.

### Importante

Se necessários, o arquivo `.sql` do banco de dados está na raiz do projeto.
