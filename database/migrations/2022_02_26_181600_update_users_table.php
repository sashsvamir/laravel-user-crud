<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public string $table;

    public function __construct()
    {
        $this->table = config('user-crud.users_table', 'users');
    }

    public function up(): void
    {
        Schema::table($this->table, function (Blueprint $table) {
            $table->boolean('notify')->nullable();
            $table->boolean('notify_spam')->nullable();
            $table->json('roles')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table($this->table, function (Blueprint $table) {
            $table->dropColumn(['notify', 'notify_spam', 'roles']);
        });
    }

};
