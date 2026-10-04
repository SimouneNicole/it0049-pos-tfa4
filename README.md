# IT0049 POS Sessions and Authentication TFA4

A CodeIgniter 4 Point of Sale application that extends TFA3 with password hashing, staff login, session-based authentication, protected customer and user routes, and logout. The TFA3 customer CRUD, user CRUD, validation, avatar upload, and liquid-glass interface remain included.

## Deployed InfinityFree website: http://tfa4.freehosting.dev/

## Features

- Login form with username and password validation
- Passwords stored as hashes created with `password_hash()`
- Login verification with `password_verify()`
- Small session values for `isLoggedIn`, `user_id`, and `username`
- Session ID regeneration after successful login
- Reusable `AuthFilter` registered under the `auth` alias
- All customer and user GET/POST routes protected by the filter
- Logout action that destroys the entire session
- One-time success and error messages using flash data
- Password creation for new users and optional password replacement while editing
- Preserved customer/user forms, validation, old input, avatar upload, and placeholder display
- Fresh database export and a separate TFA3-to-TFA4 upgrade script

## System Requirements

- PHP 8.2 or higher
- Composer 2 or higher
- MySQL 5.7 or MariaDB 10.3 or higher
- PHP extensions: `intl`, `mbstring`, `mysqli`, and `gd`

## Installation and Setup

### 1. Open the project folder

```bash
cd it0049-pos-tfa4-main
```

### 2. Install dependencies

```bash
composer install
```

### 3. Set up the database

For a fresh local setup, import `db_export/database.sql` through phpMyAdmin. It creates the `it0049_pos` database, the customer and user tables, the avatar field, the password field, and the fictional sample records.

For deployment on InfinityFree, import `db_export/infinityfree_database.sql` into the assigned database (`if0_43084784_tfa4`). It omits `CREATE DATABASE` and `USE` statements to prevent permissions errors on shared hosting.

If your completed TFA3 database is already installed and contains records you want to preserve, import only `db_export/tfa4_upgrade.sql`. It adds the password column and assigns a hashed classroom password to existing users. Do not import both SQL files into the same existing database.

### 4. Create the environment file

Copy `env`, rename the copy to `.env`, and confirm these settings:

```ini
CI_ENVIRONMENT = development
app.baseURL = 'http://localhost:8080/'

database.default.hostname = localhost
database.default.database = it0049_pos
database.default.username = root
database.default.password = ''
database.default.DBDriver = MySQLi
database.default.port = 3306
```

### 5. Enable image processing

Enable `extension=gd` in XAMPP's `php.ini`, save the file, and restart Apache. GD is required for preparing uploaded avatars.

### 6. Start the application

```bash
php spark serve --port 8080
```

Open `http://localhost:8080/`.

## Classroom Login

Every sample account uses the same initial plain password for testing, but the database stores only salted hashes.

```text
Username: leila.hassan
Password: TFA4pass123!
```

You may also use `hiroshi.tanaka`, `priya.sharma`, `amina.okafor`, `mateo.garcia`, or `meilin.chen` with the same initial password.

## Database Schema

### customers

| Column | Type | Rules |
|---|---|---|
| `id` | INT | Primary key and auto increment |
| `full_name` | VARCHAR(100) | Required |
| `email` | VARCHAR(100) | Required |
| `phone` | VARCHAR(20) | Optional |
| `created_at` | DATETIME | Required |

### users

| Column | Type | Rules |
|---|---|---|
| `id` | INT | Primary key and auto increment |
| `username` | VARCHAR(50) | Required and unique |
| `password` | VARCHAR(255) | Required password hash |
| `full_name` | VARCHAR(100) | Required |
| `avatar` | VARCHAR(255) | Optional filename only |
| `created_at` | DATETIME | Required |

## Application Routes

| Method | Route | Access | Purpose |
|---|---|---|---|
| GET | `/` | Public | Home page |
| GET | `/about` | Public | About page |
| GET | `/login` | Public | Staff login form |
| POST | `/login` | Public | Validate credentials and start session |
| GET | `/logout` | Public | Destroy session and return to login |
| GET | `/customers` | Auth required | Customer listing |
| GET | `/customers/new` | Auth required | Add Customer form |
| POST | `/customers` | Auth required | Validate and insert customer |
| GET | `/customers/{id}/edit` | Auth required | Edit Customer form |
| POST | `/customers/{id}` | Auth required | Validate and update customer |
| GET | `/users` | Auth required | User listing and avatars |
| GET | `/users/new` | Auth required | Add User form with password |
| POST | `/users` | Auth required | Hash password and insert user |
| GET | `/users/{id}/edit` | Auth required | Edit User, password, and avatar form |
| POST | `/users/{id}` | Auth required | Validate and update user |

## Authentication Workflow

1. The login form posts the username and password to `POST /login`.
2. `Auth::attempt()` validates both fields and finds the user through `UserModel`.
3. `password_verify()` compares the typed password with the stored hash.
4. A successful login regenerates the session ID and stores only the login flag, user ID, and username.
5. The `auth` filter checks `isLoggedIn` before every customer and user route.
6. A logged-out request is redirected to `/login` with a one-time error message.
7. Logout destroys the session and redirects to `/login`.

## Important File Locations

```text
app/Config/Routes.php                         Login, logout, and protected routes
app/Config/Filters.php                        auth filter alias
app/Config/Session.php                        file-based session configuration
app/Controllers/Auth.php                      login verification and logout
app/Controllers/Customers.php                 protected customer workflow
app/Controllers/Users.php                     protected user/password/avatar workflow
app/Filters/AuthFilter.php                     session access check
app/Models/UserModel.php                       password allowed field
app/Views/auth/login.php                       login form
app/Views/layouts/main.php                     login/logout navigation and flash messages
app/Views/users/new.php                        new user password fields
app/Views/users/edit.php                       optional password replacement
app/Database/Migrations/2026-10-03-000002_AddPasswordToUsers.php
db_export/database.sql                        complete fresh database
db_export/tfa4_upgrade.sql                     upgrade from completed TFA3
```

## Testing and Verification

List the registered routes:

```bash
php spark routes
```

Perform these browser checks:

1. While logged out, open `/customers`, `/customers/new`, `/users`, and `/users/new`; each must redirect to `/login`.
2. Submit the login form with empty fields and confirm validation errors appear.
3. Submit an incorrect password and confirm the invalid-login message appears once.
4. Log in with `leila.hassan` and `TFA4pass123!`; confirm `/customers` loads.
5. Open customer and user create/edit forms and confirm the preserved TFA3 functions still work.
6. Create a new user and confirm the database stores a hash rather than the typed password.
7. Log out, then revisit a protected URL and confirm it redirects to `/login`.
8. Confirm the session does not contain a password or complete user record.

## Submission

Submit the GitHub repository containing the raw project files and database export or migration, plus the hosted working application link.

## License

This project is licensed under the MIT License.
