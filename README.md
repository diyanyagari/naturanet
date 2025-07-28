# ♻️ NaturaNet CMS - Laravel + Filament

This is a CMS system built with **Laravel 11** and **Filament v3**, intended to manage a digital waste bank and tree planting platform.\
It supports roles such as `superadmin`, `admin-sampah`, `admin-pohon`, and other extendable user roles. (just in case, thats naming roles can be changes)

---

## 🚀 Features

- ⚙️ User & Role Management
- 🧾 Waste Types Master Data (`jenis_sampah`)
- 🌱 Tree Planting Management
- 📊 Dashboard via Filament
- 🔐 Protected Admin Panel
- and more feature extendable

---

## 📦 Requirements

- PHP 8.2+
- Composer
- MySQL
- Node.js (if you plan to use Vite for frontend assets)

---

## 🛠️ Installation

Follow the steps below to run this project locally:

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

