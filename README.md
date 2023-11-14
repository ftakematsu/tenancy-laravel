# Aplicação Multi-tenant

`php artisan migrate:fresh --seed`

## Criando tenants e domains

`php artisan tinker`

### Execute os seguintes comandos
> `$tenant = \App\Models\Tenant::create(['id' => 'hello', 'plan' => 'Free']);`
> `$tenant->domains()->create(['domain' => 'hello.localhost']);`

### Crie usuários
``
App\Models\Tenant::all()->runForEach(function () {
    App\Models\User::factory()->create();
});
``

# Executando com o Docker
 - Downloado do Docker (se estiver no Windows, utilize a instalação com WSL).
   - Certifique-se de que o WSL2 esteja instalado. Siga as orientações neste [link](https://docs.microsoft.com/windows/wsl/wsl2-kernel).
 - Execute o comando `docker-compose up -d`
   - Caso esteja com containers anteriores, execute `docker-compose down`
 - Aguarde até a criação dos containers.
 - Acesse o container `docker-compose exec -w /var/www api bash`
 - Execute os comandos:
    - `composer install` (caso não tenha feito isso no projeto local)
    - `php artisan migrate --seed` (para criar o banco de dados e as tabelas)
 - `docker-compose exec mysql bash`
    - `mysql -u root -p` (senha padrão definida como `password`)
    - `GRANT ALL PRIVILEGES ON *.* TO 'admin'@'%';`
    - `FLUSH PRIVILEGES;`