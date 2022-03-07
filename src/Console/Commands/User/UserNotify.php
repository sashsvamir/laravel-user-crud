<?php

namespace Sashsvamir\LaravelUserCRUD\Console\Commands\User;

use Sashsvamir\LaravelUserCRUD\Services\UserService;
use App\Models\User;
use Illuminate\Console\Command;


class UserNotify extends Command
{
    protected $signature = 'user:notify {email} {--disable}';

    protected $description = 'Enable/disable user email notify';

    public function handle()
    {
        if ( ! $this->confirm("Do you wish to " . ($this->option('disable') ? "DISABLE" : "ENABLE") . " user notify?", true)) {
            $this->info('Cancelled!');
            return false;
        }

        $email = $this->argument('email');

        /** @var \App\Models\User $user */
        if ( ! $user = User::where('email', $email)->first() ) {
            $this->error('Undefined user with email ' . $email);
            return false;
        }

        if ($this->option('disable')) {
            UserService::disableNotify($user);
        } else {
            UserService::enableNotify($user);
        }

        $this->info("User with id:{$user->id} mark as notified!");
    }

}
