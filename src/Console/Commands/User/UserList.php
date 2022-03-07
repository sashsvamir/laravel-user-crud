<?php

namespace Sashsvamir\LaravelUserCRUD\Console\Commands\User;

use App\Models\User;
use Illuminate\Console\Command;


class UserList extends Command
{
    protected $signature = 'user:list';

    protected $description = 'List users';

    public function handle()
    {
        $users = User::all(['id', 'name', 'email', 'roles', 'notify', 'email_verified_at'])->each(function (User $user) {
            // convert array attribute "roles" to string type (to render in table, see below)
            return $user->roles = implode(', ', $user->roles);
        });

        $this->table(['id', 'name', 'email', 'roles', 'notify', 'verified (by email)'], $users);
        $this->info("Total users count: {$users->count()}");
    }

}
