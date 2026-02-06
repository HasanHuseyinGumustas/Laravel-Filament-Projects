<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected string $table = 'currencies';

    protected array $columns = ['id', 'no', 'code', 'name', 'symbol'];
    protected array $data = [
        [1, 949, 'TRY', 'Türk Lirası', '₺'],
        [2, 840, 'USD', 'Amerikan Doları', '$'],
        [3, 978, 'EUR', 'Euro', '€'],
    ];

    public function up(): void
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->id();
            $table->smallInteger('no')->unsigned()->unique();
            $table->string('code');
            $table->string('name');
            $table->string('symbol');
            $table->timestamp('created_at', 6)->useCurrent();
            $table->timestamp('updated_at', 6)->useCurrent()->useCurrentOnUpdate();
            $table->timestamp('deleted_at', 6)->nullable();
        });

        $this->seed();
    }

    protected function seed(): void
    {
        $chunks = collect($this->data)->map(function ($item) {
            return collect($this->columns)->combine($item);
        })->chunk(1000);

        foreach ($chunks as $chunk) {
            DB::table($this->table)->insert($chunk->toArray());
        }
    }

    public function down(): void
    {
        Schema::dropIfExists($this->table);
    }
};
