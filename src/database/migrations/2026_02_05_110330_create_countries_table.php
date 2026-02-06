<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected string $table = 'countries';

    protected array $columns = ['id', 'name', 'country_code', 'internet_code', 'un_code', 'un_number', 'calling_code', 'license_plate_code'];
    protected array $data = [
        [1, 'Türkiye', 'TR', 'tr', 'TUR', '792', '90', 'tr']
    ];

    public function up(): void
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('country_code');
            $table->char('internet_code', 2)->unique();
            $table->string('un_code');
            $table->string('un_number');
            $table->char('calling_code', 3)->unique();
            $table->string('license_plate_code');
            $table->timestamp('created_at', 6)->useCurrent();
            $table->timestamp('updated_at', 6)->useCurrent()->useCurrentOnUpdate();
            $table->timestamp('deleted_at', 6)->nullable();
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
