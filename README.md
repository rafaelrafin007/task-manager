#Keep the project file in htdocs of xampp on your device

Task Manager — Setup & Run
1) Prerequisites

PHP 8.1+ with pdo_mysql enabled

Check: php -m | grep -i pdo_mysql (macOS/Linux) or php -m | findstr /I pdo_mysql (Windows)

Composer 2+

MySQL/MariaDB running locally (or a reachable server)

2) Get the code

Unzip the project, or clone your repo, then go into the folder:

cd task-manager

3) Install dependencies
composer install

4) Configure environment

Copy the template and edit values for your machine:

cp .env.example .env            # macOS/Linux
# or
Copy-Item .env.example .env     # Windows PowerShell


Edit .env:

APP_ENV=local
APP_URL=http://localhost:8000
SESSION_NAME=tm_sess

DB_HOST=127.0.0.1
DB_PORT=3306
DB_NAME=task_manager
DB_USER=your_mysql_user
DB_PASS=your_mysql_pass

5) Create database tables (pick ONE path)
A) CLI (if mysql is in PATH)
mysql -u DB_USER -p -e "CREATE DATABASE IF NOT EXISTS task_manager CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
mysql -u DB_USER -p task_manager < database/schema.sql

B) phpMyAdmin

Create database task_manager (utf8mb4).

Import database/schema.sql.

C) PHP migrator (no mysql client needed)
php scripts/migrate.php

6) Start the app
php -S localhost:8000 -t public


Open http://localhost:8000.

7) Use

Register a new account.

Add, edit, delete, and toggle tasks.

Works with or without JS; with JS, actions use AJAX for no page reloads.