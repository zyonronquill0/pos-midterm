# Point-of-Sale (POS) System Foundations

**Course:** IT0049 - Web System Technologies  
**Assessments:** TFA1 & TFA2

## Project Overview

This web application is developed using CodeIgniter 4 to demonstrate MVC architecture, routing, dynamic views, and database integration across two phases:

- **Activity 1 (TFA1):** Created a 4-page website (Home, About, Customers, Users) using static PHP arrays for mock data storage.
- **Activity 2 (TFA2):** Migrated customer and staff records to a MySQL database using CodeIgniter Models (`CustomerModel`, `UserModel`) and Query Builder methods (`findAll()`).

## Application Routes

- `/` — POS Dashboard / Landing Page
- `/about` — About Page
- `/customers` — Customer Accounts (loaded from MySQL)
- `/users` — User Accounts (loaded from MySQL)

## Database Setup

1. Create a database named `ci4_pos` in MySQL / phpMyAdmin.
2. Import the schema and seed records from:
   ```text
   database/ci4_pos.sql
   ```

The SQL dumps above are from the earlier coursework and do not include passwords
for login. They are not a complete setup for the current authentication feature.
The application uses `database.default.database` in `.env`; make sure this is the
database you inspect in phpMyAdmin. Do not re-import an old dump to fix a password.

## Resetting a login password

If an existing account shows "Invalid username or password", run this from the
project folder (replace `admin` if your account has a different username):

```sh
php spark auth:reset-password admin
```

The command displays the configured database and account, then asks you to enter
and confirm a new password. Input is visible in your local terminal. Use at least
6 characters and at most 72 bytes. It stores a PHP password hash and only updates
that existing account's password. Then log in with `admin` and the new password.
There is no built-in default password.
