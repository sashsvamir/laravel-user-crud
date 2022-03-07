<?php

namespace Sashsvamir\LaravelUserCRUD\Console\Commands\User;

use Sashsvamir\LaravelUserCRUD\Services\UserService;
use App\Models\User;
use Illuminate\Console\Command;


class UserNotifySpam extends Command
{
    protected $signature = 'user:notify-spam {email} {--disable}';

    protected $description = 'Enable/disable user email spam notify';

    public function handle()
    {
        if ( ! $this->confirm("Do you wish to " . ($this->option('disable') ? "DISABLE" : "ENABLE") . " user spam notify?", true)) {
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
            UserService::disableNotifySpam($user);
        } else {
            UserService::enableNotifySpam($user);
        }

        $this->info("User with id:{$user->id} mark as spam notified!");
    }

}
