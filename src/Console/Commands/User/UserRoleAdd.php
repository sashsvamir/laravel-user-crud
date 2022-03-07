<?php

namespace Sashsvamir\LaravelUserCRUD\Console\Commands\User;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;


class UserRoleAdd extends Command
{
    protected $signature = 'user:role-add';

    protected $description = 'Set role to user';

    public function handle()
    {
        $email = $this->ask('Email?');

        /** @var \App\Models\User $user */
        if ( ! $user = User::where('email', $email)->first() ) {
            $this->error('Undefined user with email ' . $email);
            return false;
        }

        $role = $this->ask('Role (' . implode(', ', User::getAvailableRoles()) . ')?');

        // validate
        $validator = $this->getValidator(compact('role'));
        try {
            $validator->validate();
        } catch (ValidationException $exception) {
            $this->error($validator->errors());
            return 1;
        }

        $role = $validator->validated()['role'];

        if (in_array($role, $user->roles)) {
            $this->error("Role '{$role}' already used by user {$user->email}");
            return false;
        }

        // add role to user
        $roles = $user->roles;
        $roles[] = $role;
        $user->roles = $roles;
        $user->save();

        $this->info("User with id:{$user->id} set role: {$role}!");

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
            'role' => Rule::in(User::getAvailableRoles()),
        ]);
    }

}
