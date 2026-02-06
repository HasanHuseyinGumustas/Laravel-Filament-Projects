<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected string $table = 'locations';
    protected array $columns = ['id', 'province_id', 'district_id', 'ref_id', 'name', 'address', 'latitude', 'longitude', 'google_maps_uri'];
    protected array $data = [
        [1, 20, null, 'ChIJQRr1PfE_xxQRMZo0CDMK0Qw', 'INOGARDEN', 'Kınıklı Mh, 6027. Sk. No:17, 20160 Pamukkale/Denizli, Türkiye', 37.746837899999996, 29.092688000000003, 'https://maps.google.com/?cid=923530612884937265'],
        [2, 20, 261, 'ChIJz9ku2Rk_xxQR8XtNnwK22co', 'Denizli Büyükşehir Belediyesi Pamukkale Kültür Merkezi', 'İncilipınar, 3385. Sk. No:2, 20100 Pamukkale/Denizli, Türkiye', 37.75839740, 29.09468680, 'https://maps.google.com/?cid=14616914187986500593'],
        [3, 20, 261, 'ChIJiTEUeDASxxQRMllVQmKXAZQ', 'Hierapolis', 'Pamukkale, 20280 Pamukkale/Denizli, Türkiye', 37.92487910, 29.12324360, 'https://maps.google.com/?cid=10664971840865524018'],
        [4, 20, 261, 'ChIJF1D_CgA_xxQR_AysFt62wiw', 'Horizon Garden AVM', 'Sümer, Çal Cd. No:1, 20050 Denizli Merkezefendi/Denizli, Türkiye', 37.79039790, 29.08945460, 'https://maps.google.com/?cid=3225341348130065660'],
    ];

    public function up(): void
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('province_id')->nullable();
            $table->unsignedBigInteger('district_id')->nullable();
            $table->string('ref_id')->nullable();
            $table->string('name');
            $table->string('address');
            $table->decimal('latitude', 11, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('google_maps_uri')->nullable();
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
