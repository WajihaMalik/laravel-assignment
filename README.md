# Laravel Assignment

## About the Project

This project is a Laravel-based application built with **AdminLTE** for the dashboard interface and **Laravel Breeze** for authentication in dashboard. For API authentication **Sanctum** is used. It features categories and products, allowing users to manage and view various products associated with categories.

## Installation Steps

Follow the steps below to set up the project on your local machine:

### 1. Clone the Repository
First, clone the repository to your local machine:
```bash
git clone https://github.com/WajihaMalik/laravel-assignment.git
```
### 2. Install Packages
```bash
composer install
npm install
```
### 3. Create Storage Link and Seed DB
```bash
php artisan storage:link
php artisan migrate
php artisan db:seed
```
Login credentials are:
- admin@admin.com
- password


## API Endpoints

#### Get list of categories and products

```http
  POST http://127.0.0.1:8000/api/register-user
  POST http://127.0.0.1:8000/api/login-user
```
```
Request Body
{
    "name": "John Doe",
    "email": "johndoe@example.com",
    "password": "password123",
    "password_confirmation": "password123"
}
```

#### Get list of categories and products

```http
  GET http://127.0.0.1:8000/api/categories
  GET http://127.0.0.1:8000/api/products
```
| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `Authorization Token` | `bearer` | **Required**|

### 4. Run project
```bash
php artisan queue:work
php artisan serve
npm run dev
```
