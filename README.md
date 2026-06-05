# Kedai MDP Web Application

A web-based Food & Beverage (F&B) ordering system developed using Laravel and MySQL. The application supports two different user roles (Admin and Customer) with separate authentication systems and dashboards.

---

## Features

### Customer Features

- User Registration & Login
- Browse Food & Beverage Menu
- Add Items to Cart
- Manage Shopping Cart
- View Restaurant Information
- Contact Information Access

### Admin Features

- Admin Authentication
- Dashboard Management
- Menu Management (Create, Read, Update, Delete)
- Gallery Management
- Contact Management
- Order Monitoring

---

## Technology Stack

- Laravel 11
- PHP 8.2
- MySQL
- Bootstrap
- HTML
- CSS
- JavaScript

---

## User Roles

This application uses two separate roles:

| Role | Description |
|--------|-------------|
| Admin | Manages menus, galleries, contacts, and system data |
| Customer | Browses menu, manages cart, and places orders |

---

## Demo Accounts

### Admin Account

| Email | Password |
|---------|----------|
| admin@mail.com | admin@mail.com |

### Customer Account

| Email | Password |
|---------|----------|
| user1@mail.com | user1@mail.com |

---

## Registration

Newly registered accounts are automatically created as Customer accounts.

Administrator accounts cannot be created through the registration page and must be inserted directly into the database or seeded using Laravel Seeder.

---

## Installation

### Clone Repository

```bash
git clone https://github.com/KharisteasJosan988/ProjectKedaiMdp.git  
cd ProjectKedaiMdp
```

### Install Dependencies

```bash
composer install
```

### Generate Application Key

```bash
php artisan key:generate
```

### Run Migration

```bash
php artisan migrate
```

### Seed Demo Data

```bash
php artisan db:seed
```

### Start Development Server

```bash
php artisan serve
```

Visit:

```
http://127.0.0.1:8000
```

---

## Database Seeder

The project includes predefined accounts through Laravel Seeder.

Seeder file:

```text
database/seeders/DatabaseSeeder.php
```

To recreate demo accounts:

```bash
php artisan db:seed
```

---

## Screenshots
<img width="1365" height="675" alt="Screenshot 2026-06-05 204018" src="https://github.com/user-attachments/assets/d806288d-7ebb-4870-8e48-ebf099db3e00" />
<img width="1365" height="638" alt="Screenshot 2026-06-05 204101" src="https://github.com/user-attachments/assets/bd72e137-eaab-443b-8f7b-4e1f96bc31e1" />
<img width="1362" height="643" alt="Screenshot 2026-06-05 204124" src="https://github.com/user-attachments/assets/c3456844-4c50-469c-8eeb-93e244ab99e3" />
<img width="1365" height="640" alt="Screenshot 2026-06-05 205021" src="https://github.com/user-attachments/assets/5d9a7136-f82e-4419-a003-100a30a04776" />

### Login Page

Authentication page for Admin and Customer users.

### Customer Dashboard

Displays featured menu items, restaurant information, and navigation to menu and cart pages.

### Admin Dashboard

Allows administrators to manage menus, galleries, contacts, and monitor application data.

---

## Author

Kharisteas Josan Sedi
