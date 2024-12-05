This API has been deployed on

```bash
https://apiweb-seller.iqbal-fakhriza.online/api
```

# Laravel Project Installation Guide

This guide provides step-by-step instructions to install a Laravel project using Laragon and configure JWT authentication.

---

## Prerequisites

Before starting, ensure you have the following:

-   **Laragon** installed ([Download Laragon](https://laragon.org/))
-   **Composer** and **Node.js** (pre-installed with Laragon)
-   Working internet connection

---

## Installation Steps

### 1. Clone the Laravel Project

1. Open Laragon and navigate to the root directory for projects (`C:\laragon\www`).
2. Clone the Laravel project repository:
    ```bash
    git clone https://github.com/your-repo-name/laravel-project.git
    cd laravel-project
    ```

### 2. Install Dependencies

```bash
composer update
```

### 3. Set Up .env file

1. copy .env
    ```bash
    cp .env.example .env
    ```
2. Update .env credentials
    ```bash
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=web_seller_api
    DB_USERNAME=root
    DB_PASSWORD=
    ```

### 4. Generate the Application Key

```bash
php artisan key:generate
```

### 5. Set Up the Database

1. Create a new database in phpMyAdmin or your preferred MySQL tool.
2. Run migrations and seeders to set up the database tables and seed sample data:

```bash
php artisan migrate --seed
```

### 6. Install and Configure JWT Authentication

```bash
php artisan jwt:secret
```

### 7. Run the Project

```bash
php artisan serve
```
