# 📚Lexibook REST API

This is a fully object-oriented REST API for managing a simple library system built with pure PHP (no frameworks). The API allows user authentication, book management, and includes features like pagination, basic auth, and clean URL routing with .htaccess.



## 🛠 Features

- ✅ User Registration & Login
- 🔐 Basic Authentication
- 📚 Book CRUD (Create, Read, Update, Delete)
- 📄 Pagination for listing books
- 🧼 Clean URLs using .htaccess
- 💡 Built 100% in OOP PHP (No frameworks)



## 📁 Folder Structure

lexibook/ 
    ├── config/
            ├── database.php                # Database connection class 
    ├── controllers/
            ├── BookController
            ├── AuthController        
    ├── helpers/
            ├── ResponseHelper.php          # JSON response helper 
    ├── middleware/
            ├──AuthMiddleware.php           # Basic authentication middleware 
    ├── models/
            ├── Book.php
            ├── User.php                    # User and Book models 
    ├── routes/
            ├── api.php                     # API routing file 
    ├── index.php                           # Entry point 
    └── .htaccess                           # Clean URLs via mod_rewrite









## ⚙ Setup Instructions 

1. Clone the repo:

```bash
git clone https://github.com/Ollypumping/lexibook.git
cd lexibook

2. Create the database:

CREATE DATABASE lexibook;

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(100) NOT NULL,
  `isbn` varchar(20) NOT NULL,
  `published_year` year(4) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
);


CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
);



3. Configure Apache:

Make sure mod_rewrite is enabled.

Ensure this exists in httpd.conf:


<Directory "C:/xampp/htdocs">
    AllowOverride All
    Require all granted
</Directory>

Restart Apache.


4. Place the project in:

C:/xampp/htdocs/lexibook/






🧪 Testing the API

You can test the API using Postman, Thunder Client (VS Code)

Base Url => http://localhost/lexibook/api

🔐 Authentication

Register:
POST /register

{
  "username": "admin",
  "password": "password123"
}

Login:
POST /login
{
  "username": "admin",
  "password": "password123"
}





📚 Books (requires authentication)

> Basic authentication with username and password



- List Books (Paginated):
    - GET /book?limit=2&page=1

- Get Books
    - GET /books

- Get Book by ID:
    - GET /books/1

- Create Book:
    - POST /books

    {
    "title": "Purple Hibiscus",
    "author": "Chimamanda Ngozi Adichie",
    "isbn": "9780007200283",
    "published_year": 2003
    }

- Update Book:
    - PUT /books/1

- Delete Book:
    - DELETE /books/1







🚀 Technologies Used

PHP 8+

MySQL

Apache + mod_rewrite

Postman for testing






✍ Author

Developed by Olayemi Ojo

