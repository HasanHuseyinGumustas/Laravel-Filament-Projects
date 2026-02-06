<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected string $table = 'provinces';

    protected array $columns = ['id', 'region_id', 'license_plate_code', 'slug', 'name'];
    protected array $data = [
        [1, 1, '01', 'adana', 'Adana'],
        [2, 4, '02', 'adiyaman', 'Adıyaman'],
        [3, 3, '03', 'afyonkarahisar', 'Afyonkarahisar'],
        [4, 2, '04', 'agri', 'Ağrı'],
        [5, 6, '05', 'amasya', 'Amasya'],
        [6, 5, '06', 'ankara', 'Ankara'],
        [7, 1, '07', 'antalya', 'Antalya'],
        [8, 6, '08', 'artvin', 'Artvin'],
        [9, 3, '09', 'aydin', 'Aydın'],
        [10, 7, '10', 'balikesir', 'Balıkesir'],
        [11, 7, '11', 'bilecik', 'Bilecik'],
        [12, 2, '12', 'bingol', 'Bingöl'],
        [13, 2, '13', 'bitlis', 'Bitlis'],
        [14, 6, '14', 'bolu', 'Bolu'],
        [15, 1, '15', 'burdur', 'Burdur'],
        [16, 7, '16', 'bursa', 'Bursa'],
        [17, 7, '17', 'canakkale', 'Çanakkale'],
        [18, 5, '18', 'cankiri', 'Çankırı'],
        [19, 6, '19', 'corum', 'Çorum'],
        [20, 3, '20', 'denizli', 'Denizli'],
        [21, 4, '21', 'diyarbakir', 'Diyarbakır'],
        [22, 7, '22', 'edirne', 'Edirne'],
        [23, 2, '23', 'elazig', 'Elazığ'],
        [24, 2, '24', 'erzincan', 'Erzincan'],
        [25, 2, '25', 'erzurum', 'Erzurum'],
        [26, 5, '26', 'eskisehir', 'Eskişehir'],
        [27, 4, '27', 'gaziantep', 'Gaziantep'],
        [28, 6, '28', 'giresun', 'Giresun'],
        [29, 6, '29', 'gumushane', 'Gümüşhane'],
        [30, 2, '30', 'hakkari', 'Hakkari'],
        [31, 1, '31', 'hatay', 'Hatay'],
        [32, 1, '32', 'isparta', 'Isparta'],
        [33, 1, '33', 'mersin', 'Mersin'],
        [34, 7, '34', 'istanbul', 'İstanbul'],
        [35, 3, '35', 'izmir', 'İzmir'],
        [36, 2, '36', 'kars', 'Kars'],
        [37, 6, '37', 'kastamonu', 'Kastamonu'],
        [38, 5, '38', 'kayseri', 'Kayseri'],
        [39, 7, '39', 'kirklareli', 'Kırklareli'],
        [40, 5, '40', 'kirsehir', 'Kırşehir'],
        [41, 7, '41', 'kocaeli', 'Kocaeli'],
        [42, 5, '42', 'konya', 'Konya'],
        [43, 3, '43', 'kutahya', 'Kütahya'],
        [44, 2, '44', 'malatya', 'Malatya'],
        [45, 3, '45', 'manisa', 'Manisa'],
        [46, 1, '46', 'kahramanmaras', 'Kahramanmaraş'],
        [47, 4, '47', 'mardin', 'Mardin'],
        [48, 3, '48', 'mugla', 'Muğla'],
        [49, 2, '49', 'mus', 'Muş'],
        [50, 5, '50', 'nevsehir', 'Nevşehir'],
        [51, 5, '51', 'nigde', 'Niğde'],
        [52, 6, '52', 'ordu', 'Ordu'],
        [53, 6, '53', 'rize', 'Rize'],
        [54, 7, '54', 'sakarya', 'Sakarya'],
        [55, 6, '55', 'samsun', 'Samsun'],
        [56, 4, '56', 'siirt', 'Siirt'],
        [57, 6, '57', 'sinop', 'Sinop'],
        [58, 5, '58', 'sivas', 'Sivas'],
        [59, 7, '59', 'tekirdag', 'Tekirdağ'],
        [60, 6, '60', 'tokat', 'Tokat'],
        [61, 6, '61', 'trabzon', 'Trabzon'],
        [62, 2, '62', 'tunceli', 'Tunceli'],
        [63, 4, '63', 'sanliurfa', 'Şanlıurfa'],
        [64, 3, '64', 'usak', 'Uşak'],
        [65, 2, '65', 'van', 'Van'],
        [66, 5, '66', 'yozgat', 'Yozgat'],
        [67, 6, '67', 'zonguldak', 'Zonguldak'],
        [68, 5, '68', 'aksaray', 'Aksaray'],
        [69, 6, '69', 'bayburt', 'Bayburt'],
        [70, 5, '70', 'karaman', 'Karaman'],
        [71, 5, '71', 'kirikkale', 'Kırıkkale'],
        [72, 4, '72', 'batman', 'Batman'],
        [73, 4, '73', 'sirnak', 'Şırnak'],
        [74, 6, '74', 'bartin', 'Bartın'],
        [75, 2, '75', 'ardahan', 'Ardahan'],
        [76, 2, '76', 'igdir', 'Iğdır'],
        [77, 7, '77', 'yalova', 'Yalova'],
        [78, 6, '78', 'karabuk', 'Karabük'],
        [79, 4, '79', 'kilis', 'Kilis'],
        [80, 1, '80', 'osmaniye', 'Osmaniye'],
        [81, 6, '81', 'duzce', 'Düzce'],
    ];

    public function up(): void
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Region::class);
            $table->char('license_plate_code', 2);
            $table->string('slug');
            $table->string('name');
            $table->timestamp('created_at', 6)->useCurrent();
            $table->timestamp('updated_at', 6)->useCurrent()->useCurrentOnUpdate();
            $table->timestamp('deleted_at', 6)->nullable();
        });

        Schema::table($this->table, function (Blueprint $table) {
            $table->foreign('region_id')->references('id')->on('regions')->onUpdate('cascade');
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
