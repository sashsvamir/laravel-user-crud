<?php
namespace Sashsvamir\LaravelUserCRUD\Models;


use Illuminate\Database\Eloquent\Builder;


/**
 * @property array $roles
 */
trait UserRolesTrait
{

    public function initializeUserRolesTrait()
    {
        $this->fillable = array_merge($this->fillable, [
            'roles',
        ]);

        $this->attributes = array_merge($this->attributes, [
            'roles' => '[]',
        ]);

        $this->casts = array_merge($this->casts, [
            'roles' => 'array',
        ]);
    }

    /**
     * 'roles' accessor (Fix: return empty array if roles is null, see laravel 9 changes.)
     */
    protected function getRolesAttribute($value)
    {
        return parent::castAttribute('roles', empty($value) ? '[]' : $value);
    }

    public static function getAvailableRoles(): array
    {
        return [
            self::ROLE_ADMIN,
            self::ROLE_MODERATOR,
        ];
    }

    public function hasRole(string $role): bool
    {
        return in_array($role, $this->roles);
    }


}

