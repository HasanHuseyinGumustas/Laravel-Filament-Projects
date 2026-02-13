<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected string $table = 'social_media_urls';

    public function up(): void
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\SocialMediaPlatform::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\Artist::class)->constrained()->cascadeOnDelete();
            $table->string('url');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists($this->table);
    }
};
