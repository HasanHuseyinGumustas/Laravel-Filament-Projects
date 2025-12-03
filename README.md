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
