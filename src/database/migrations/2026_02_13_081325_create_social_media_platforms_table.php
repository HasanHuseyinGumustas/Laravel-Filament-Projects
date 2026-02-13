<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected string $table = 'social_media_platforms';

    protected array $columns = ['id', 'name', 'icon_uri', 'created_at', 'updated_at'];

    protected array $data = [
        [1, 'Facebook', 'https://upload.wikimedia.org/wikipedia/commons/0/05/Facebook_Logo_(2019).png', '2015-10-01 00:00:00'],
        [2, 'Twitter', 'https://upload.wikimedia.org/wikipedia/en/thumb/c/c8/Twitter_Bird.svg/1200px-Twitter_Bird.svg.png', '2015-10-01 00:00:00'],
        [3, 'Instagram', 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/a5/Instagram_icon.png/1024px-Instagram_icon.png', '2015-10-01 00:00:00'],
        [4, 'LinkedIn', 'https://upload.wikimedia.org/wikipedia/commons/thumb/c/ca/LinkedIn_logo_initials.png/1024px-LinkedIn_logo_initials.png', '2015-10-01 00:00:00'],
        [5, 'YouTube', 'https://upload.wikimedia.org/wikipedia/commons/thumb/9/9f/Youtube%28amin%29.png/1024px-Youtube%28amin%29.png', '2015-10-01 00:00:00'],
        [6, 'TikTok', 'https://upload.wikimedia.org/wikipedia/en/thumb/6/69/TikTok_logo.svg/1200px-TikTok_logo.svg.png', '2015-10-01 00:00:00'],
        [7, 'Spotify', 'https://upload.wikimedia.org/wikipedia/en/thumb/1/19/Spotify_logo_without_text.svg/1200px-Spotify_logo_without_text.svg.png', '2015-10-01 00:00:00'],
    ];

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
