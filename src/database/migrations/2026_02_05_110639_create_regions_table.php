<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected string $table = 'regions';

    protected array $columns = ['id', 'country_id', 'name'];
    protected array $data = [
        [1, 1, 'Akdeniz'],
        [2, 1, 'Doğu Anadolu'],
        [3, 1, 'Ege'],
        [4, 1, 'Güneydoğu Anadolu'],
        [5, 1, 'İç Anadolu'],
        [6, 1, 'Karadeniz'],
        [7, 1, 'Marmara'],
    ];

    public function up(): void
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Country::class);
            $table->string('name');
            $table->timestamp('created_at', 6)->useCurrent();
            $table->timestamp('updated_at', 6)->useCurrent()->useCurrentOnUpdate();
            $table->timestamp('deleted_at', 6)->nullable();
        });

        Schema::table($this->table, function (Blueprint $table) {
            $table->foreign('country_id')->references('id')->on('countries')->onUpdate('cascade');
        });

        $this->seed();
    }

    protected function seed(): void
    {
        $columns = collect($this->columns);
        collect($this->data)
            ->chunk(1000)
            ->each(function ($chunk) use ($columns) {
                $insertData = $chunk->map(function ($item) use ($columns) {
                    return $columns->combine($item)->toArray();
                })->toArray();

                DB::table($this->table)->insert($insertData);
            });
    }

    public function down(): void
    {
        Schema::dropIfExists($this->table);
    }
};
