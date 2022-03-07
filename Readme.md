
## Laravel User model Crud

This extension improve User model, add console commands and page (CRUD) to manage users.



## Setup

Publish and run migration to update `users` table:
```sh
artisan vendor:publish --tag=user-crud-migrations
artisan migrate
```
Note: will be added follow columns: `roles, notify, notify-spam`

If you previously has renamed users table, you can set new name in config, but first you must publish `config/user-crud.php` config:
```sh
artisan vendor:publish --tag=user-crud-config
```
...and set new users table name:
```php
return [
    'users_table' => 'newname',
];
```


Next, add traits `UserNotifyTrait`, `UserRolesTrait` and implementation `HasRolesInterface` to `App\Model\User`:
```php
class Model implements HasRolesInterface {
    use UserNotifyTrait, UserRolesTrait;
    ...
}
```
Also you can define own roles:
```php
class Model implements HasRolesInterface {
    const ROLE_MANAGER = 'manager';
    public static function getAvailableRoles(): array {
        return [
            self::ROLE_ADMIN,
            self::ROLE_MODERATOR,
            self::ROLE_MANAGER,
        ];
    }
}
```







## Commands

Now you can use follow artisan commands to manage users:
```sh
artisan user:add
artisan user:change-password
artisan user:list
artisan user:notify
artisan user:notify-spam
artisan user:remove
artisan user:role-add
artisan user:role-remove
```




## Gates/Roles

Now any user can have follow roles: `admin` and `moderator`

You can check that user have above permissions (i.e. in blade view):
```blade
@can('role-admin')
@can('role-moderator')
```

Also will be adding gate ability `edit-users` that has been applied to all users with `admin` roles. To check that, use follow: 
```blade
@can('user-edit')
```








## Routes

**Warning:** below section only works with specific blade components (yet no published) and use bootstrap5 styles.

Extension adds page routes to manage users (CRUD), you can get acces by url `/admin/user`:
```
http://localhost:8080/admin/user
```

Note: By default all `/admin/user/*` web routes use `auth` and `can:edit-users` middlewares.

To add link to users CRUD in your admin template, add follow (bootstrap5 style):  
```blade
@can('edit-users')
    <li class="nav-item">
        <a href="{{ route('admin.user.index') }}" class="nav-link {{ (request()->routeIs('admin.user.*')) ? 'active' : '' }}">Users</a>
    </li>
@endcan
```





## Override blade templates
To publish blade view files, run:
```sh
artisan vendor:publish --tag=user-crud-views
```

