<?php
namespace Sashsvamir\LaravelUserCRUD\Models;



use Illuminate\Database\Eloquent\Builder;
use Illuminate\Notifications\HasDatabaseNotifications;


interface HasRolesInterface
{
    const ROLE_ADMIN = 'admin';
    const ROLE_MODERATOR = 'moderator';

    public static function getAvailableRoles(): array;

    public function hasRole(string $role): bool;

}

