<?php

namespace Sashsvamir\LaravelUserCRUD\Console\Commands\User;

use Sashsvamir\LaravelUserCRUD\Services\UserService;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;


class UserChangePassword extends Command
{
    protected $signature = 'user:change-password {email}';

    protected $description = 'Change user password';

    public function handle()
    {
        $email = $this->argument('email');

        /** @var User $user */
        if ( ! $user = User::where('email', $email)->first() ) {
            $this->error('Unknown user with email ' . $email);
            return 1;
        }

        $password = $this->secret('Password?');
        $password_confirmation = $this->secret('Confirm password?');

        // validate
        $validator = $this->getValidator(compact('password', 'password_confirmation'));
        try {
            $validator->validate();
        } catch (ValidationException $exception) {
            $this->error($validator->errors());
            return 1;
        }

        $result = UserService::updatePassword($user, $password);

        if (! $result) {
            $this->error("Error of change password!");
            return 1;
        }

        $this->info("User with id:{$user->id} password changed success!");

        return 0;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function getValidator(array $data)
    {
        return Validator::make($data, [
            'password' => ['required', 'confirmed', /* Rules\Password::min(5) */'string', 'min:5'],
        ]);
    }

}
