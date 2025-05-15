# Users List PHP CRUD

A simple PHP CRUD (Create, Read, Update, Delete) application for managing a list of users. The app uses PDO for database access and Bootstrap (Bootswatch Darkly theme) for styling.

## Features

- List all users in a table
- Add new users (name, email, password, role)
- Edit existing users
- Delete users with confirmation
- Roles: Guest, Author, Admin

## Requirements

- PHP 7.x or higher
- MySQL
- Web server (e.g., Apache, Nginx)

## Setup

1. **Clone the repository**
   ```sh
   git clone <repo-url>
   cd users_list_php_crud
   ```
2. **Create a database**

   ```sql
   CREATE DATABASE enset_2025;
   USE enset_2025;

   CREATE TABLE users (
     idd INT AUTO_INCREMENT PRIMARY KEY,
     name VARCHAR(100) NOT NULL,
     email VARCHAR(100) NOT NULL,
     pass VARCHAR(100) NOT NULL,
     role VARCHAR(20) NOT NULL
   );
   ```

## File Structure

`index.php` — Main page; contains all CRUD functions (list, add, edit, delete users)
`readme.md` — Project documentation
