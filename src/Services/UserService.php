<?php
namespace Sashsvamir\LaravelUserCRUD\Services;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UserService
{

    public static function create(array $validated): User
    {
        return User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            // 'password' => bcrypt($password),
            'password' => Hash::make($validated['password']),
            'notify' => $validated['notify'] ?? false,
            'notify_spam' => $validated['notify_spam'] ?? false,
            'roles' => $validated['roles'] ?? [],
        ]);
    }

    public static function update(User $user, array $validated): bool
    {
        return $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'notify' => $validated['notify'] ?? false,
            'notify_spam' => $validated['notify_spam'] ?? false,
            'roles' => $validated['roles'] ?? [],
        ]);
    }

    public static function updatePassword(User $user, string $password): bool
    {
        $user->password = Hash::make($password);

        $user->setRememberToken(Str::random(60));

        $user->save();

        event(new PasswordReset($user));

        return true;
    }

    public static function delete(User $user): ?bool
    {
        return $user->delete();
    }

    public static function enableNotify(User $user)
    {
        return $user->update(['notify' => true]);
    }

    public static function disableNotify(User $user)
    {
        return $user->update(['notify' => false]);
    }

    public static function enableNotifySpam(User $user)
    {
        return $user->update(['notify_spam' => true]);
    }

    public static function disableNotifySpam(User $user)
    {
        return $user->update(['notify_spam' => false]);
    }

}
