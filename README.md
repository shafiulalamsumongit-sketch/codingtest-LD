# Laravel 11 URL Shortener API (Sanctum)

A RESTful, API-only backend built with **Laravel 11** using **Laravel Sanctum** for authentication.  
This project provides user registration, login, authenticated URL shortening, and short URL redirection.

---

## 🚀 Features
- User Registration & Login
- Token-based Authentication (Laravel Sanctum)
- Secure Password Hashing (bcrypt)
- URL Shortening (Authenticated)
- Redirect Short URL → Original URL
- Input Validation with Proper JSON Errors
- Invalid / Missing Token Handling

---

## 🛠 Requirements
- PHP >= 8.2
- Composer
- MySQL / MariaDB

---

## 📦 Installation
```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve

🔐 Authentication
Use Bearer token authentication for protected endpoints:
Authorization: Bearer YOUR_API_TOKEN

📡 API Documentation
Base URL
http://localhost:8000/api



1️⃣ Register User
POST /api/register
Request:

{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123"
}

Success Response (201):
{
  "message": "Registration successful",
  "token": "YOUR_API_TOKEN"
}

Validation Error (422):
{
  "message": "Validation Error",
  "errors": {
    "email": ["The email has already been taken."]
  }
}

2️⃣ Login User

POST /api/login

Request:

{
  "email": "john@example.com",
  "password": "password123"
}


Success Response (200):

{
  "message": "Login successful",
  "token": "YOUR_API_TOKEN"
}


Invalid Credentials (401):

{
  "message": "Invalid credentials"
}

3️⃣ Logout User

POST /api/logout (Authenticated)

Headers: Authorization: Bearer {API_TOKEN}

Success Response (200):

{
  "message": "Logged out successfully"
}

4️⃣ Shorten URL (Authenticated)

POST /api/shorten

Headers: Authorization: Bearer {API_TOKEN}

Request:

{
  "url": "https://google.com"
}


Success Response (201):

{
  "message": "URL shortened successfully",
  "short_url": "http://localhost:8000/AbC123"
}


Duplicate URL (200):

{
  "message": "URL already shortened",
  "short_url": "http://localhost:8000/AbC123"
}


Validation Error (422):

{
  "message": "Validation Error",
  "errors": {
    "url": ["The url format is invalid."]
  }
}


Invalid / Missing Token (401):

{
  "message": "Invalid or missing API token"
}

5️⃣ Redirect Short URL

GET /{short_code}
Success Response (302): Redirects to original URL

Not Found (404):
{
  "message": "Short URL not found"
}

6️⃣ Error Responses
- HTTP Code	Error Type	Example Response
- 401	Unauthorized / Invalid Token	{ "message": "Invalid or missing API token" }
- 422	Validation Error	{ "message": "Validation Error", "errors": { "field": ["error message"] } }
- 404	Not Found	{ "message": "Short URL not found" }
- 500	Server Error	{ "message": "Internal server error" }

7️⃣ Sample Workflow
- Register → Receive API token
- Login → Receive API token
- Shorten URL → Get short URL
- Redirect → GET /{short_code}
- Logout → Token revoked

8️⃣ Security
- Passwords hashed using bcrypt
- Sanctum personal access tokens
- Protected routes via auth:sanctum

