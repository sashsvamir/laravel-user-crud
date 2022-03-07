<?php

namespace Sashsvamir\LaravelUserCRUD\Console\Commands\User;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;


class UserRoleRemove extends Command
{
    protected $signature = 'user:role-remove';

    protected $description = 'Remove role from user';

    public function handle()
    {
        $email = $this->ask('Email?');

        /** @var User $user */
        if ( ! $user = User::where('email', $email)->first() ) {
            $this->error('Undefined user with email ' . $email);
            return false;
        }

        $role = $this->ask('Role (' . implode(', ', $user->roles) . ')?');

        // validate
        $validator = $this->getValidator(compact('role'));
        try {
            $validator->validate();
        } catch (ValidationException $exception) {
            $this->error($validator->errors());
            return 1;
        }

        $role = $validator->validated()['role'];

        if (! in_array($role, $user->roles)) {
            $this->error("User {$user->email} no have role '{$role}'");
            return false;
        }

        // remove role from user
        $user->roles = array_filter($user->roles, function ($val) use ($role) {
            return $val !== $role;
        });
        $user->save();

        $this->info("User with id:{$user->id} was remove role: {$role}!");

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
