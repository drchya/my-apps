
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Laravel Simple Admin Panel for Pendakian App

This is a simple Laravel-based admin panel designed for managing mountain hiking (pendakian) data. Built using Laravel 12, TailwindCSS, Blade, and Alpine.js. No Livewire or Breeze included — everything is built manually for flexibility and learning.

## Features

- ✅ User Authentication (Login, Register, Logout)
- ✅ Dashboard with sidebar and topbar
- ✅ Dropdown user menu: Profile, Settings, Logout
- ✅ Flash messages with Alpine.js and animation
- ✅ Middleware-protected routes
- ✅ Responsive design with TailwindCSS
- ✅ Font Awesome support (CDN or local)
- ✅ Validation with custom error messages

### Upcoming Features

- ⛰️ Master Data Gunung (Mountain List)
- 🎒 Barang & Wishlist Pendakian (Items grouped by category)
- 🚌 Transportasi (with price, departure time, and duration)
- 📋 Rincian Pendakian (Full summary with status: 'Siap Berangkat', 'Dalam Persiapan', etc.)
- 📦 Admin Approval & Fulfillment
- 🔔 Notification System (Alpine.js)
- 📊 Simple Analytics (Pendakian status tracking)

## Tech Stack

- Laravel 12
- TailwindCSS
- Blade Templating
- Alpine.js
- Font Awesome 5

## Installation

```bash
git clone https://github.com/your-username/pendakian-admin-panel.git
cd pendakian-admin-panel
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

## Folder Structure

- `resources/views/layouts` – Base layout files (main layout, auth layout)
- `resources/views/auth` – Login & Register pages
- `resources/views/dashboard.blade.php` – Admin dashboard
- `app/Http/Controllers/AuthController.php` – Auth logic
- `routes/web.php` – Web route definitions
- `public/fontawesome` – (Optional) Local Font Awesome

## Authentication Middleware

- Guest users cannot access the dashboard
- Logged in users are redirected from `/login` or `/register`
- Session regeneration for security

## Flash Message Example

```blade
@if (session('success'))
<div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show"
    class="bg-emerald-500/70 text-white px-4 py-2 rounded mb-4 text-center shadow-md transition">
    <p>{{ session('success') }}</p>
</div>
@endif
```

## Custom Validation

```php
$request->validate([
    'username' => ['required', 'regex:/^\S*$/u'],
    'email' => 'required|email|unique:users,email',
    'password' => 'required|min:8|confirmed'
]);
```

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
