# fintiny
Sistema em Laravel para Financeiro - Tiny Erp

Dependencias

* Composer
* Php >8.0
* Laravel > 11

```
composer create-project laravel/laravel <nomedoprojeto> // para instalar na mesma use o ponto (.)

```
copiar o arquivo .env.example  e criar o (.env);
```
php artisan serve 

gerar a chave da aplicaçao
```
php artisan key:generate
```
Ajustar o .env o banco de dados
```
Rodar o comando migrate para executar as migração e criar o banco de dados
```
php artisan migrate


Inserir paginação bootstrap
```
 php artisan vendor:publish --tag=laravel-pagination