User Registration & Management System


A simple and modern PHP & MySQL user registration and management system with validation, secure password hashing, CRUD operations, and two-step delete verification.



Features

User registration

Email validation

Secure password hashing

MySQL database integration

View registered users

Edit user details

Delete users with two-step verification

Responsive and modern UI

Prepared SQL statements


Technologies

PHP

MySQL

HTML5

CSS3



Project Structure

registration/
│
├── index.php
├── register.php
├── users.php
├── edit.php
├── delete.php
├── style.css


Database


Create a MySQL database named:


registration_db


Create a users table with:


CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL
);

How to Run

Install XAMPP or another PHP/MySQL server.

Copy the project into the htdocs folder.

Start Apache and MySQL.

Create the registration_db database in phpMyAdmin.

Create the users table using the SQL above.

Update your database configuration.




Important: Never upload real database passwords, API keys, or other secrets to GitHub.


Future Improvements

User login and logout

Email OTP verification

Forgot password

Admin dashboard

Session authentication

CSRF protection

User profile management

License


This project is licensed under the MIT License.

Register interface : https://github.com/ASHIK-k123/Registration-form/blob/main/Register.png
