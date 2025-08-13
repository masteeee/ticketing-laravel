# Keloola Ticketing App

## 🚀 Cara Menjalankan (Deploy)

### 1. Clone Repository

```bash
git clone git@github.com:devthrive/keloola-support.git
cd keloola-support
```

### 2. Build dan Jalankan Docker Compose

```bash
docker-compose up -d --build
```

Jika berhasil, kamu akan melihat container-container berikut berjalan:

```
CONTAINER ID   IMAGE                   COMMAND                  CREATED        STATUS             PORTS                                         NAMES
0fb818a2c555   keloola-ticketing-app   "/usr/local/bin/dock…"   43 hours ago   Up About an hour   9000/tcp                                      keloola-ticketing-app
9cf144d5b72f   nginx:1.25-alpine       "/docker-entrypoint.…"   9 days ago     Up About an hour   0.0.0.0:8080->80/tcp, [::]:8080->80/tcp       keloola-ticketing-nginx
78aaaf05dc15   postgres:15             "docker-entrypoint.s…"   12 days ago    Up About an hour   0.0.0.0:5432->5432/tcp, [::]:5432->5432/tcp   keloola-ticketing-db
```

### 3. Jalankan Migrasi dan Seeder

```bash
docker exec -it keloola-ticketing-app php artisan migrate:fresh --force
docker exec -it keloola-ticketing-app php artisan db:seed --force
```

### 4. Akses Aplikasi

Buka browser dan akses:

```
http://localhost:8080
```

## ⚙️ Struktur Docker Compose

- **App:** Laravel (PHP-FPM)
- **Web Server:** Nginx (port 8080)
- **Database:** PostgreSQL (port 5432)

## 🛠 Tools & Teknologi

- Laravel 10+
- PostgreSQL 15
- Docker Compose
- Nginx
