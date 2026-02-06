<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected string $table = 'event_categories';

    protected array $columns = ['id', 'name', 'slug'];
    protected array $data = [
        [1, 'Konser', 'konser'],
        [2, 'Konferans', 'konferans'],
        [3, 'Tiyatro', 'tiyatro'],
        [4, 'Müze', 'muze'],
        [5, 'İş Dünyası', 'is-dunyasi'],
        [6, 'Fuar', 'fuar'],
        [7, 'Stand-up', 'stand-up'],
        [8, 'Söyleşi', 'soylesi'],
        [9, 'Kültürel', 'kulturel'],
        [10, 'Doğal Parklar', 'dogal-parklar'],
        [11, 'Müzeler', 'muezeler'],
        [12, 'Kurslar', 'kurslar'],
        [13, 'Şelaleler', 'selaleler'],
        [14, 'Mağaralar', 'magaralar'],
    ];

    public function up(): void
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamp('created_at', 6)->useCurrent();
            $table->timestamp('updated_at', 6)->useCurrent()->useCurrentOnUpdate();
            $table->timestamp('deleted_at', 6)->nullable();
        });

        $this->seed();
    }

    protected function seed(): void
    {
        $chunks = collect($this->data)->map(function ($item) {
            return collect($this->columns)->combine($item)->toArray();
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
