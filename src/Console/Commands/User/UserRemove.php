<?php

namespace Sashsvamir\LaravelUserCRUD\Console\Commands\User;

use Sashsvamir\LaravelUserCRUD\Services\UserService;
use App\Models\User;
use Illuminate\Console\Command;


class UserRemove extends Command
{
    protected $signature = 'user:remove {email}';

    protected $description = 'Remove user';

    public function handle()
    {
        if ( ! $this->confirm('Do you wish to remove user?', true)) {
            $this->info('Cancelled!');
            return false;
        }

        $email = $this->argument('email');

        /** @var \App\Models\User $user */
        if ( ! $user = User::where('email', $email)->first() ) {
            $this->error('Undefined user with email ' . $email);
            return false;
        }

        UserService::delete($user);

        $this->info("User with id:{$user->id} removed!");
    }

}
