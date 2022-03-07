<?php

namespace Sashsvamir\LaravelUserCRUD\Console\Commands\User;

use Sashsvamir\LaravelUserCRUD\Services\UserService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;


class UserAdd extends Command
{
    protected $signature = 'user:add';

    protected $description = 'Create new user';

    public function handle()
    {
        $name = $this->ask('Name?');
        $email = $this->ask('E-mail?');
        $password = $this->secret('Password?');

        if ( ! $this->confirm('Do you wish to create user?', true)) {
            $this->info('Cancelled!');
            return false;
        }

        // validate
        $validator = $this->getValidator(compact('name', 'email', 'password'));
        try {
            $validator->validate();
        } catch (ValidationException $exception) {
            $this->error($validator->errors());
            return 1;
        }

        // create user
        $data = $validator->validated();
        $user = UserService::create($data);

        $this->info("User with id:{$user->id} added!");
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:4'],
        ]);
    }

}
