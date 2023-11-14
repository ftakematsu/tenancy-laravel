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
