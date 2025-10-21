# Aplikasi Kasir (Point of Sales) 


## Tech Stack

- Laravel 11.x
- Inertia
- React
- TailwindCSS
- MySQL


------------
## 💻 Panduan Instalasi Project

1. **Clone Repository**
```bash
git clone https://github.com/aryadwiputra/point-of-sales 
```
2. **Buka terminal, lalu ketik**
```
cd point-of-sales
composer install
npm install
cp .env.example .env
php artisan key:generate
```

3. **Buka ```.env``` lalu ubah baris berikut sesuaikan dengan databasemu yang ingin dipakai**
```
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```

3. **Jalankan bash**
```bash
php artisan config:cache
php artisan storage:link
php artisan route:clear
```

4. **Jalankan migrations dan seeders**
```
php artisan migrate --seed
```
5. **Jalankan nodejs**
```
npm run dev
```

5. **Jalankan website**
```bash
php artisan serve
```

