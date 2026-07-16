# Ehl-i Keyf Kaş — Website

Ehl-i Keyf Kaş meyhanesinin resmi web sitesi. Kaş, Antalya'da bulunan bohem tarzı Akdeniz meyhanesi için dinamik, çoklu dil destekli web uygulaması.

**Canlı:** [ehlikeyfkas.com](https://ehlikeyfkas.com)

## Tech Stack

- **Backend:** Laravel 12 (PHP 8.4)
- **Admin Panel:** Filament 3
- **Frontend:** Livewire 3 + TailwindCSS 4 + Vite 7
- **Database:** MySQL 8.4
- **Deployment:** Coolify + Cloudflare

## Features

- 🌐 Çoklu dil desteği (TR/EN) — `mcamara/laravel-localization`
- 📋 Dinamik menü yönetimi (Kanban board)
- 📅 Rezervasyon sistemi
- 💬 Ziyaretçi geri bildirim sistemi
- 📝 Blog (AI destekli içerik üretimi + otomatik çeviri)
- 🖼️ Galeri yönetimi
- 📱 QR kod takip sistemi
- 🔔 Web Push bildirimleri
- 🗺️ Dinamik sitemap (hreflang destekli)
- ⚙️ Filament admin paneli ile tam yönetim

## Local Development

```bash
# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Database
php artisan migrate
php artisan db:seed

# Build assets
npm run build

# Start dev server
composer run dev
```

## Deployment (Coolify)

The project uses `nixpacks.toml` for Coolify deployments:

1. Coolify, GitHub `main` branch'ine push yapıldığında otomatik deploy eder
2. Build: `composer install --no-dev` + `npm install` + `npm run build`
3. Start: `php artisan migrate --force && php artisan serve`
4. `php.ini` ile upload limitleri (50M) ayarlıdır

## Project Structure

```
app/
├── Filament/          # Admin panel resources, pages, widgets
├── Livewire/          # Frontend Livewire components
├── Models/            # Eloquent models
├── Services/          # Business logic (AI, WebPush, ExchangeRate)
├── Http/Controllers/  # HTTP controllers (Sitemap)
└── Console/Commands/  # Artisan commands (blog, translation)
database/
├── migrations/        # Database schema
├── seeders/           # Initial data (menu, settings, gallery)
resources/
├── views/             # Blade templates
├── css/               # TailwindCSS entry
└── js/                # JavaScript entry
```

## License

Proprietary — © Ehl-i Keyf Kaş
