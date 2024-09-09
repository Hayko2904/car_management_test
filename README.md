# Laravel Car Management API

This project is a car management API built with Laravel. It allows users to create, update, delete, and view cars. The API also includes authentication using Laravel Sanctum.

## Features
- User authentication (Login, Sign up, Logout)
- Car CRUD operations
- Pagination support for car listing
- Image upload and management for cars

## Requirements
- PHP 8.1 or higher
- Composer
- Vue.js
- MySQL or another supported database

## Installation

1. Install PHP dependencies:
    ```bash
   composer install

2. Install JavaScript dependencies:
    ```bash
   npm install

3. Copy the .env.example file to .env and configure your environment variables:
    ```bash
   cp .env.example .env

4. Generate the application key:
    ```bash
   php artisan key:generate

5. Set up your database and update your .env file with the database credentials.

6. Run database migrations: 
    ```bash
   php artisan migrate
   
7. Create a link for the storage/public directory
    ```bash
   php artisan storage:link

8. Start the development server:
    ```bash
   php artisan serve

## API Endpoints
### Authentication
- POST /login - Log in the user.
- Request example
```json
{
  "email": "user@example.com",
  "password": "your_password"
}
```
- Response example
```json
{
  "token": "your_generated_token",
  "user": "user data"
}
```
- POST /signup - Register a new user.
- Request example
```json
{
  "name": "John Doe",
  "email": "user@example.com",
  "password": "your_password",
  "password_confirmation": "your_password"  
}

```
- Response example
```json
{
  "token": "your_generated_token",
  "user": "user data"
}
```
- POST /logout - Log out the authenticated user.
Response example
```json
{
  "message": "Logout successful."
}
```
### Cars
- GET /cars - Get a paginated list of cars.
- Response example
```json
{
  "data": [
    {
      "id": 1,
      "make": "Toyota",
      "model": "Camry",
      "year": 2020,
      "price": 200,
      "description": "test description",  
      "image": "/storage/image1.jpg"
    },
    {
      "id": 2,
      "make": "Honda",
      "model": "Accord",
      "year": 2021, 
      "price": 200,
      "description": "test description",
      "image": "/storage/image2.jpg"
    }
  ],
  "links": {
    "first": "http://example.com/cars?page=1",
    "last": "http://example.com/cars?page=10",
    "prev": null,
    "next": "http://example.com/cars?page=2"
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 10,
    "per_page": 3,
    "to": 3,
    "total": 30
  }
}

```
- GET /cars/{id} - Get details of a specific car.
- Response example
```json
{
    "id": 1,
    "make": "Toyota",
    "model": "Camry",
    "year": 2020,
    "price": 200,
    "description": "test description",
    "image": "/storage/image1.jpg"
}
```
- POST /cars - Create a new car (requires authentication).
- Request example
```json
{
  "make": "Ford",
  "model": "Mustang",
  "year": 2022,
  "price": 200,
  "description": "test description",  //Optional
  "image": "base64_encoded_image_data"//Optional
}
```
- Response example
```json
{
    "id": 1,
    "make": "Toyota",
    "model": "Camry",
    "year": 2020,
    "price": 200,
    "description": "test description",
    "image": "/storage/image1.jpg"
}
```
- PUT /cars/{id} - Update a specific car (requires authentication).
- Request example
```json
{
  "make": "Ford",
  "model": "Mustang",
  "year": 2022,
  "price": 200,
  "description": "test description",  //Optional
  "image": "base64_encoded_image_data"//Optional
}
```
- Response example
```json
{
    "id": 1,
    "make": "Toyota",
    "model": "Camry",
    "year": 2020,
    "price": 200,
    "description": "test description",
    "image": "/storage/image1.jpg"
}
```
- DELETE /cars/{id} - Delete a specific car (requires authentication).
```json
{
  "message": "Car deleted successfully!"
}
```
### Image Upload
The car image can be uploaded along with the car data. The image is stored in the public directory.
## Frontend with Vue.js
This project uses Vue.js for the frontend. The frontend assets are managed using Vite, which provides a fast development experience and efficient build process.

1. To start the frontend development server, run:
    ```bash
   npm run dev
   
This command will start Vite and provide hot-reloading for a smooth development experience.

2. To build the frontend assets for production, run:
    ```bash
   npm run build

This will compile and optimize the assets for deployment.
