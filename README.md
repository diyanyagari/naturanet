# ♻️ NaturaNet CMS - Laravel + Filament

This is a CMS system built with **Laravel 11** and **Filament v3**, intended to manage a digital waste bank and tree planting platform.  
It supports roles such as `superadmin`, `admin-sampah`, `admin-pohon`, and other extendable user roles.

---

## 🚀 Features

- ⚙️ User & Role Management
- 🧾 Waste Types Master Data (`jenis_sampah`)
- 🌱 Tree Planting Management
- 📊 Dashboard via Filament
- 🔐 Protected Admin Panel

---

## 📦 Requirements (Manual Setup)

- PHP 8.2+
- Composer
- MySQL
- Node.js (if you plan to use Vite for frontend assets)

---

## 🐳 Run with Docker (Recommended)

### ⚙️ Prerequisites

- Docker
- MySQL (can be external or shared host DB)
- `.env` file configured

### 📥 1. Clone the Repository

```bash
git clone https://github.com/your-username/naturanet-cms.git
cd naturanet-cms
```

### ⚙️ 2. Configure Environment Variables

Create `.env` from the example:

```bash
cp .env.example .env
```

Edit `.env` to set your **MySQL credentials** (e.g., from a VPS-hosted DB):

```env
DB_HOST=your-db-host
DB_PORT=3306
DB_DATABASE=naturanet
DB_USERNAME=your-user
DB_PASSWORD=your-pass
```

### 🐳 3. Build & Run the Container

```bash
docker-compose up -d --build
```

> It will expose the app on [http://localhost:8080](http://localhost:8080)

### 🧬 4. Run Migrations & Seeders

If this is the first time running the project, execute:

```bash
docker exec -it natura-net php artisan migrate
docker exec -it natura-net php artisan db:seed --class=RoleSeeder
```

> Optionally, seed an admin user:
```bash
docker exec -it natura-net php artisan db:seed --class=SuperAdminSeeder
```

You can also use custom credentials via `.env`:
```env
SEED_ADMIN_USERNAME=admin
SEED_ADMIN_PASSWORD=securepass123
```

---

## 💻 Manual Installation (Non-Docker)

### 1. Clone the Repository

```bash
git clone https://github.com/your-username/naturanet-cms.git
cd naturanet-cms
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Copy Environment File

```bash
cp .env.example .env
```

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Configure `.env`

Set your database credentials:

```env
DB_DATABASE=naturanet
DB_USERNAME=root
DB_PASSWORD=
```

### 6. Run Migrations & Seeders

```bash
php artisan migrate --seed
```

### 7. Run the Application

```bash
php artisan serve
```

Visit: [http://localhost:8000/admin](http://localhost:8000/admin)

Default credentials (if seeded):

```
Username: superadmin
Password: password
```

---

## 📁 Folder Structure Overview

```
app/
🏁👉🏻 Filament/Resources/       # Filament CMS resources
🏁👉🏻 Models/                   # Eloquent Models
database/
🏁👉🏻 migrations/               # Schema
🏁👉🏻 seeders/                  # Demo data
routes/
🏁👉🏻 web.php                   # Web routes
```

---

## 📄 License

This project is open-sourced for internal or public use. You may fork and customize it to your needs.

---

## 🤝🏼 Contribution

Pull requests are welcome! For major changes, please open an issue first to discuss what you would like to change.
