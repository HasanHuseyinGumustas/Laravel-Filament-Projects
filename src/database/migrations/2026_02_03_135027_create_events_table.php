<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected string $table = 'events';

    protected array $columns = ['id', 'visibility_type_id', 'event_category_id', 'user_id', 'organizer_id', 'is_online', 'slug', 'title', 'approval_status', 'approval_at'];
    protected array $data = [
        [1, 1, 5, 1, 1, 0, 'ayakta-duzen', 'Ayakta Düzen', 'approved', '2015-10-01 00:00:00'],
    ];

    public function up(): void
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_category_id')->default(1)->constrained('event_categories')->cascadeOnDelete();
            $table->foreignId('visibility_type_id')->default(1)->constrained('visibility_types')->cascadeOnDelete();
            $table->foreignId('currency_id')->default(1)->nullable()->constrained('currencies')->cascadeOnDelete();
            $table->string('location_id')->index()->nullable();
            $table->boolean('is_online')->default(false);
            $table->string('url')->nullable();
            $table->string('slug')->unique();
            $table->string('title');
            $table->text('description')->nullable();
            $table->dateTime('started_at')->nullable();
            $table->dateTime('ended_at')->nullable();
            $table->decimal('price')->nullable()->unsigned();
            $table->decimal('commission_rate', 5)->nullable()->unsigned();
            $table->string('purchase_link')->nullable();
            $table->smallInteger('person_capacity')->default(0)->unsigned();
            $table->boolean('is_commentable')->default(true);
            $table->approvals();
            $table->timestamp('created_at', 6)->useCurrent();
            $table->timestamp('updated_at', 6)->useCurrent()->useCurrentOnUpdate();
            $table->timestamp('deleted_at', 6)->nullable();
        });

//        $this->seed();
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
