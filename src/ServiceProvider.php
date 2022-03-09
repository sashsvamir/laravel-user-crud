<?php
namespace Sashsvamir\LaravelUserCRUD;


use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Sashsvamir\LaravelUserCRUD\Console\Commands\User\UserAdd;
use Sashsvamir\LaravelUserCRUD\Console\Commands\User\UserChangePassword;
use Sashsvamir\LaravelUserCRUD\Console\Commands\User\UserList;
use Sashsvamir\LaravelUserCRUD\Console\Commands\User\UserNotify;
use Sashsvamir\LaravelUserCRUD\Console\Commands\User\UserNotifySpam;
use Sashsvamir\LaravelUserCRUD\Console\Commands\User\UserRemove;
use Sashsvamir\LaravelUserCRUD\Console\Commands\User\UserRoleAdd;
use Sashsvamir\LaravelUserCRUD\Console\Commands\User\UserRoleRemove;


class ServiceProvider extends \Illuminate\Support\ServiceProvider
{

    public function boot(): void
    {
        // publish config
        $this->publishes([
            __DIR__.'/../config/user-crud.php' => config_path('user-crud.php'),
        ], 'user-crud-config');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/user-crud'),
        ], 'user-crud-views');

        $this->publishes([
            __DIR__.'/../database/migrations' => database_path('migrations'),
        ], 'user-crud-migrations');


        // load migrations
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        // register console commands
        $this->loadCommands();

        // load routes
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        // register user roles
        $this->registerAuthRoles();

        // load components
        $this->loadViewsFrom([
            __DIR__.'/../resources/views'
        ], 'user-crud');
    }

    /**
     * Load console commands
     */
    protected function loadCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                UserAdd::class,
                UserChangePassword::class,
                UserList::class,
                UserNotify::class,
                UserNotifySpam::class,
                UserRemove::class,
                UserRoleAdd::class,
                UserRoleRemove::class,
            ]);
        }
    }

    /**
     * register roles for auth user
     */
    protected function registerAuthRoles()
    {
        // add roles to "can:role-<role>" validations
        foreach (User::getAvailableRoles() as $role) {
            Gate::define("role-${role}", function (User $user) use ($role) {
                return $user->hasRole($role);
            });
        }

        // add role "edit-users"
        Gate::define('edit-users', function (User $user) {
            return $user->hasRole(User::ROLE_ADMIN);
        });

    }

}
