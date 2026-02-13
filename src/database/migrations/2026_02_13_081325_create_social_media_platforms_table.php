<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected string $table = 'social_media_platforms';

    protected array $columns = ['id', 'name', 'icon_uri', 'created_at', 'updated_at'];

    protected array $data = [1, 'Facebook', 'https://upload.wikimedia.org/wikipedia/commons/0/05/Facebook_Logo_(2019).png', '2015-10-01 00:00:00'];

    public function up(): void
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('icon_uri')->nullable();
            $table->timestamp('created_at', 6)->useCurrent();
            $table->timestamp('updated_at', 6)->useCurrent()->useCurrentOnUpdate();
            $table->timestamp('deleted_at', 6)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists($this->table);
    }
};
