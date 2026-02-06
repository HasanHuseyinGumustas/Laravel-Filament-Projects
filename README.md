# Laravel Filament Projects

Bu repo, **Laravel** ve **Filament Admin Panel** kullanılarak geliştirilmiş projeleri içerir.  
Amaç, modern PHP uygulamalarında hızlı ve ölçeklenebilir yönetim panelleri oluşturmayı kolaylaştırmaktır.

---

## 🚀 Özellikler
- Laravel 10 tabanlı backend
- Filament v4 ile modern admin panel
- CRUD işlemleri için hazır resource yapısı
- Kullanıcı yönetimi ve rol bazlı yetkilendirme
- Docker ile kolay kurulum ve deployment

---

## ToDo
- Oyun incelemeleri ve oyun detayları için oluşturulacak sayfalar için post oluşturma, resim ekleme ve puanlama gibi özelliklerin hazırlandığı ve gözlemlenebildiği sayfalar.
- Oyun incelemelerinde onaylama ve reddetme seçenekleri olacak.
- Oyunlara gelen yorumların izlenebilmesi ve düzenlenebilmesi için sayfalar.
- Kullanıcıların listelendiği ve düzenlenbildiği sayfa.
- Oyun inceleme kanallarının düzenlendiği ve eklenebildiği sayfa. 

--

## 🛠️ Kurulum

Projeyi klonladıktan sonra aşağıdaki adımları izleyin:

```bash
# Repoyu klonla
git clone git@github.com:HasanHuseyinGumustas/Laravel-Filament-Projects.git

cd Laravel-Filament-Projects

# Bağımlılıkları yükle
composer install
npm install && npm run build

# Ortam dosyasını ayarla
cp .env.example .env

# Uygulama anahtarı oluştur
php artisan key:generate

# Migration çalıştır
php artisan migrate
