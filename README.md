# Sembark URL Shortener
 Implementing a service which will allow your users to generate short urls.
- Your service mustn’t have multiple companies
- Each company will have multiple users
- Each user will neither be an Admin nor a Member
 
## Stack

- PHP 8.2+, Laravel 11.54.0
- MySQL supported via `.env`
- Plain server-rendered Blade views, no build step, no JS framework

## Setup

```bash
git clone https://github.com/kuldeeprk2593-web/urlshotner.git
cd urlshotner

composer update

.env to update:
    # DB_CONNECTION=mysql
    # DB_HOST=127.0.0.1
    # DB_PORT=3306
    # DB_DATABASE=laravel_urlshortner
    # DB_USERNAME=root
    # DB_PASSWORD=

php artisan key:generate  

php artisan migrate --seed

php artisan optimize:clear

php artisan serve
or
php artisan serve --port=8070
```

Visit `http://localhost:8000`.
or
Visit `http://localhost:8070`.

### Seeded accounts

`php artisan migrate --seed` runs two seeders:

1. **`SuperAdminSeeder`**  Login:
   - `superadmin@sembark.com` / `password`
2. **`DemoDataSeeder`** Login:
   - `admin@sembark.com` / `password`
   - `member@sembark.com` / `password` 
 
