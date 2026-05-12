# KISS Scan - Keep It Simple System

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
  <img src="https://img.shields.io/badge/Tailwind_CSS-3.x-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white" alt="Tailwind CSS">
</p>

---

## Overview

KISS Scan is a web-based management system for tracking replacement activities and managing APL (APL Komponen Midlife) files. Built with Laravel, it provides multi-role access control for mekanik, planner, GL, and TERE roles.

---

## Features

- **Activity Management** - Input and track component replacement activities
- **Approval Workflow** - GL role approves/rejects pending activities
- **Historical Tracking** - View all approved replacement records with search and export
- **APL File Management** - Create and manage APL Midlife component files with sheets and items
- **User Management** - TERE role manages system users
- **Role-Based Access Control** - Secure authentication with role-specific permissions

---

## Tech Stack

| Component | Technology |
|-----------|------------|
| Backend | Laravel 11.x |
| Frontend | Blade Template Engine |
| Styling | Tailwind CSS + DaisyUI |
| Database | MySQL 8.0 |
| Authentication | Laravel Breeze |
| Icons | Font Awesome 6 |

---

## User Roles & Permissions

| Feature | Mekanik | GL | TERE | Planner |
|---------|:-------:|:---:|:----:|:-------:|
| Dashboard | Yes | Yes | Yes | Yes |
| Input Activity | Yes | No | No | No |
| View Own Activities | Yes | All | All | All |
| Approve/Reject | No | Yes | No | No |
| View Historical | Yes | Yes | Yes | Yes |
| Export Excel | No | No | No | Yes |
| View APL Files | Yes | Yes | Yes | Yes |
| Manage APL Files | No | No | No | Yes |
| User Management | No | No | Yes | No |

### Role Descriptions

- **Mekanik** - Workshop technicians who input replacement activities
- **GL** - Group Leader who approves/rejects activities
- **TERE** - Administrator who manages system users
- **Planner** - Full access to APL file management and data export

---

## Installation

### Prerequisites

- PHP 8.2+
- Composer 2.x
- MySQL 8.0+
- Node.js 18+
- npm or yarn

### Setup Steps

```bash
# 1. Install PHP dependencies
composer install

# 2. Install JavaScript dependencies
npm install

# 3. Copy environment file
cp .env.example .env

# 4. Generate application key
php artisan key:generate

# 5. Configure database in .env
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=kiss_scan
# DB_USERNAME=root
# DB_PASSWORD=

# 6. Run database migrations
php artisan migrate

# 7. Create storage link (for image uploads)
php artisan storage:link

# 8. Start development server
php artisan serve
```

For asset compilation during development:

```bash
npm run dev
```

For production:

```bash
npm run build
```

---

## Environment Setup

Copy `.env.example` to `.env` and configure:

```env
APP_NAME="KISS Scan"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kiss_scan
DB_USERNAME=root
DB_PASSWORD=

SESSION_DRIVER=database
FILESYSTEM_DISK=public
```

---

## Database Migration

```bash
# Run all migrations
php artisan migrate

# Seed with sample data (optional)
php artisan db:seed

# Refresh migrations and seed
php artisan migrate:fresh --seed
```

---

## Default Accounts

After running `php artisan db:seed`, the following accounts are available:

| Role | Email | Password |
|------|-------|----------|
| mekanik | mekanik@kiss.local | password |
| gl | gl@kiss.local | password |
| tere | tere@kiss.local | password |
| planner | planner@kiss.local | password |

> **Note**: Change these passwords immediately in production.

---

## Authentication

The application uses Laravel Breeze for authentication with the following routes:

| Route | Method | Description |
|-------|--------|-------------|
| `/login` | GET/POST | User login |
| `/logout` | POST | User logout |
| `/profile` | GET/PATCH | User profile |
| `/profile` | DELETE | Delete account |

### Auth Controllers

- `AuthenticatedSessionController` - Login/logout
- `PasswordController` - Password updates
- `ProfileController` - User profile management

---

## Role Middleware

Role-based access is handled via custom middleware located in `app/Http/Middleware/RoleMiddleware.php`.

### Usage

```php
Route::middleware(['auth', 'role:mekanik'])->group(function () {
    // Mekanik-only routes
});

Route::middleware(['auth', 'role:gl,tere,planner'])->group(function () {
    // GL, TERE, or Planner routes
});
```

### Route Protection in Controllers

Controllers also verify role before executing actions:

```php
if (Auth::user()->role !== 'planner') {
    abort(403, 'Unauthorized');
}
```

### Blade Protection

Views conditionally show content based on role:

```blade
@if(Auth::user()->role === 'planner')
    <a href="{{ route('management.apl-files.create') }}">Create APL</a>
@endif
```

---

## Route Overview

### Mekanik Routes (`/mekanik`)

| Route | Controller | Description |
|-------|------------|-------------|
| `/mekanik/dashboard` | DashboardController | Dashboard view |
| `/mekanik/input` | DashboardController | Input activity form |
| `/mekanik/input-data` | DashboardController | Alternative input |
| `/mekanik/historical` | DashboardController | View history |
| `/mekanik/apl-files` | AplFileController | View APL files |

### Management Routes (`/management`)

| Route | Role | Description |
|-------|------|-------------|
| `/management/dashboard` | All | Management dashboard |
| `/management/historical` | GL, TERE, Planner | View all history |
| `/management/apl-files` | GL, TERE, Planner | View APL list |
| `/management/apl-files/create` | Planner only | Create APL file |
| `/management/historical/export` | Planner only | Export to Excel |
| `/management/users` | TERE only | User management |

### Activity Routes (`/management/activities`)

| Route | Method | Role | Description |
|-------|--------|------|-------------|
| `/management/activities` | GET | GL | List pending |
| `/management/activities/{id}/approve` | POST | GL | Approve |
| `/management/activities/{id}/reject` | POST | GL | Reject |

---

## APL Module

APL (APL Komponen Midlife) is a spreadsheet-like file management system for tracking component data.

### Structure

```
APL File
├── Sheet 1
│   ├── Item 1 (Part Number, Stock Code, Qty, Price, Amount)
│   ├── Item 2
│   └── ...
├── Sheet 2
│   └── ...
└── ...
```

### Access Control

| Role | View | Create | Edit | Delete |
|------|------|--------|------|--------|
| Mekanik | Yes | No | No | No |
| GL | Yes | No | No | No |
| TERE | Yes | No | No | No |
| Planner | Yes | Yes | Yes | Yes |

### Models

- `AplFile` - Main APL document
- `AplSheet` - Sheets within a file
- `AplItem` - Individual items with auto-calculated `amount = qty × price`

### APL Routes (Planner Only)

```
POST   /management/apl-files              - Create APL file
GET    /management/apl-files/{id}/edit   - Edit APL file
PUT    /management/apl-files/{id}        - Update APL file
DELETE /management/apl-files/{id}         - Delete APL file
POST   /management/apl-files/{id}/sheets - Add sheet
PUT    /management/sheets/{id}           - Update sheet
DELETE /management/sheets/{id}           - Delete sheet
POST   /management/sheets/{id}/items     - Add item
PUT    /management/items/{id}            - Update item
DELETE /management/items/{id}            - Delete item
```

---

## Folder Structure

```
kiss_scan/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/
│   │   │   │   └── (Laravel Breeze auth controllers)
│   │   │   ├── Dashboard/
│   │   │   │   ├── DashboardController.php
│   │   │   │   └── AplFileController.php
│   │   │   ├── ActivityController.php
│   │   │   ├── AplItemController.php
│   │   │   ├── AplSheetController.php
│   │   │   └── UserController.php
│   │   └── Middleware/
│   │       └── RoleMiddleware.php
│   └── Models/
│       ├── User.php
│       ├── Unit.php
│       ├── Component.php
│       ├── ReplacementHistory.php
│       ├── AplFile.php
│       ├── AplSheet.php
│       └── AplItem.php
├── config/
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   └── views/
│       ├── auth/
│       │   └── login.blade.php
│       ├── dashboard/
│       │   ├── mekanik/
│       │   │   ├── dashboard.blade.php
│       │   │   ├── input-activity.blade.php
│       │   │   ├── historical.blade.php
│       │   │   └── apl-files.blade.php
│       │   └── management/
│       │       ├── dashboard.blade.php
│       │       ├── historical.blade.php
│       │       ├── apl-files/
│       │       └── users/
│       ├── layouts/
│       └── components/
├── routes/
│   ├── web.php
│   └── auth.php
├── storage/
│   └── app/public/
└── tests/
```

---

## Screenshots

> **Coming Soon**

| Page | Description |
|------|-------------|
| Login Page | Authentication screen |
| Mekanik Dashboard | Activity input and overview |
| Management Dashboard | Statistics and recent activities |
| Historical Page | Searchable replacement history |
| APL Files | File management interface |
| User Management | User CRUD (TERE role) |

---

## Future Improvements

- [ ] Email notification for approval workflow
- [ ] Dashboard analytics with charts
- [ ] API endpoints for mobile app integration
- [ ] Activity logging and audit trail
- [ ] Two-factor authentication
- [ ] Dark mode theme option
- [ ] PDF export for reports
- [ ] Advanced search filters

---

## License

This project is open-sourced under the [MIT License](LICENSE).

---

<p align="center">
  <strong>KISS - Keep It Simple System</strong><br>
  Built with Laravel
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel Version">
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP Version">
  <img src="https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL Version">
  <img src="https://img.shields.io/badge/Tailwind_CSS-3.x-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white" alt="Tailwind Version">
</p>

---

## 📋 Deskripsi

**KISS (Keep It Simple System)** adalah aplikasi web manajemen replacement activity dan APL Midlife berbasis Laravel. Aplikasi ini dirancang untuk mengelola data pergantian komponen mesin dengan sistem multi-role yang memungkinkan different access levels untuk mekanik, planner, GL, dan TERE.

---

## ✨ Fitur Utama

### 🔐 Authentication & Authorization
- Multi-role login system (Mekanik, Planner, GL, TERE)
- Role-based access control
- Secure password hashing

### 📝 Input Activity
- Create, Read, Update, Delete replacement activities
- Upload activity image
- Search by Code Number, HM Unit, Component, Notes
- Filter by status (Pending, Approved, Rejected)
- HM Unit (Hour Meter) tracking

### 📜 Historical Replacement
- View all approved replacement history
- Advanced search functionality
- Responsive table with pagination

### 📊 APL Komponen Midlife
- Spreadsheet-style interface
- Multiple sheets per APL file
- Add/Edit/Delete items
- Auto-calculate amount: `qty × price`
- Currency formatting (Indonesian Rupiah)

### ✅ Approval System (GL Role)
- Approve pending activities
- Reject activities with status update
- Real-time status tracking

### 👥 User Management (TERE Role)
- Create new users
- Edit user information
- Delete users
- Assign roles to users

---

## 🛠️ Tech Stack

| Component | Technology |
|-----------|------------|
| Backend | Laravel 11.x |
| Frontend | Blade Template |
| Styling | Tailwind CSS |
| Database | MySQL 8.0 |
| Auth | Laravel Breeze |
| Icons | Font Awesome 6 |
| JavaScript | Alpine.js |

---

## 👥 Role Permissions

| Feature | Mekanik | Planner | GL | TERE |
|---------|:-------:|:-------:|:---:|:----:|
| Dashboard | ✅ | ✅ | ✅ | ✅ |
| Input Activity | ✅ | ❌ | ❌ | ❌ |
| View Activities | Own only | ❌ | ✅ | ✅ |
| Approval | ❌ | ❌ | ✅ | ❌ |
| Historical | ✅ | ❌ | ✅ | ✅ |
| APL Files - View | ✅ | ❌ | ✅ | ✅ |
| APL Files - Manage | ❌ | ✅ | ❌ | ❌ |
| User Management | ❌ | ❌ | ❌ | ✅ |

---

## 📁 Project Structure

```
kiss_scan/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── ActivityController.php
│   │   │   ├── Dashboard/
│   │   │   │   ├── DashboardController.php
│   │   │   │   └── AplFileController.php
│   │   │   ├── AplItemController.php
│   │   │   ├── AplSheetController.php
│   │   │   └── UserController.php
│   │   └── Middleware/
│   │       └── RoleMiddleware.php
│   └── Models/
│       ├── User.php
│       ├── ReplacementHistory.php
│       ├── AplFile.php
│       ├── AplSheet.php
│       └── AplItem.php
├── resources/
│   └── views/
│       ├── activities/
│       ├── dashboard/
│       │   ├── mekanik/
│       │   └── management/
│       ├── layouts/
│       └── components/
├── routes/
│   └── web.php
└── database/
    └── migrations/
```

---

## 🚀 Installation Guide

### Prerequisites
- PHP 8.2+
- Composer
- MySQL 8.0+
- Node.js 18+ (for asset compilation)

### Steps

**1. Clone Repository**
```bash
git clone <repository-url>
cd kiss_scan
```

**2. Install Dependencies**
```bash
composer install
npm install
```

**3. Environment Setup**
```bash
cp .env.example .env
```

**4. Generate Application Key**
```bash
php artisan key:generate
```

**5. Configure Database**
Edit `.env` file:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kiss_scan
DB_USERNAME=root
DB_PASSWORD=
```

**6. Run Migrations**
```bash
php artisan migrate
```

**7. Create Storage Link**
```bash
php artisan storage:link
```

**8. Start Development Server**
```bash
php artisan serve
```

---

## 🔧 Environment Variables

Copy `.env.example` to `.env` and configure:

```env
APP_NAME="KISS"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kiss_scan
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
```

---

## 📋 Main Modules

### 1. Activity Management
- **Controller**: `ActivityController.php`
- **Model**: `ReplacementHistory.php`
- **Views**: `resources/views/activities/`
- **Features**:
  - CRUD operations
  - Image upload
  - Status workflow (pending → approved/rejected)
  - Search & filter

### 2. APL Midlife
- **Controllers**: `AplFileController.php`, `AplSheetController.php`, `AplItemController.php`
- **Models**: `AplFile.php`, `AplSheet.php`, `AplItem.php`
- **Views**: `resources/views/dashboard/management/apl-files/`
- **Features**:
  - Multiple sheets per file
  - Auto-calculate amount
  - CRUD items with validation

### 3. User Management
- **Controller**: `UserController.php`
- **Model**: `User.php`
- **Views**: `resources/views/dashboard/management/users/`
- **Features**:
  - Role-based user creation
  - Password hashing
  - Self-deletion protection

---

## 🔒 Security Features

- **Password Hashing**: Uses Laravel's `Hash::make()` for secure password storage
- **Role-based Access**: Middleware-based role verification
- **CSRF Protection**: Laravel's built-in CSRF tokens
- **SQL Injection Prevention**: Eloquent ORM with parameterized queries
- **XSS Prevention**: Blade's automatic escaping

---

## 🗂️ Database Schema

### Users Table
| Field | Type | Description |
|-------|------|-------------|
| id | BIGINT | Primary key |
| name | VARCHAR(255) | User's full name |
| email | VARCHAR(255) | Unique email |
| password | VARCHAR(255) | Hashed password |
| role | ENUM | mekanik, planner, gl, tere |
| email_verified_at | TIMESTAMP | Verification timestamp |
| created_at | TIMESTAMP | Creation date |
| updated_at | TIMESTAMP | Last update |

### Replacement History Table
| Field | Type | Description |
|-------|------|-------------|
| id | BIGINT | Primary key |
| user_id | BIGINT | FK to users |
| code_number | VARCHAR(50) | Activity code |
| hm_km | VARCHAR(50) | Hour meter reading |
| replacement_date | DATE | Date of replacement |
| category | VARCHAR(50) | Activity category |
| component_name | VARCHAR(100) | Component replaced |
| pic | VARCHAR(255) | Person in charge |
| notes | TEXT | Additional notes |
| image | VARCHAR(255) | Image path |
| status | ENUM | pending, approved, rejected |
| approved_by | BIGINT | FK to users (approver) |
| approved_at | TIMESTAMP | Approval timestamp |

### APL Tables
- **apl_files**: APL document files
- **apl_sheets**: Sheets within APL files
- **apl_items**: Items within sheets

---

## 📈 Future Improvements

- [ ] Export data to Excel/CSV
- [ ] Email notification for approval workflow
- [ ] Dashboard analytics with charts
- [ ] Mobile-responsive design optimization
- [ ] API endpoints for mobile app integration
- [ ] Activity logging and audit trail
- [ ] Two-factor authentication
- [ ] Dark mode theme option

---

## 👨‍💻 Developer Information

**Project**: KISS - Keep It Simple System

**Version**: 1.0.0

**Built with**: Laravel 11.x

**Database**: MySQL 8.0

**Documentation**: Markdown

---

## 📄 License

This project is open-sourced and available under the [MIT License](LICENSE).

---
