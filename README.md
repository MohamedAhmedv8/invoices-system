## Invoice Management System

<img src="https://www.technoheaven.net/Theme/img/Hotel-Booking-Software.jpg">

**Created By :**  Mohamed Ahmed
**Email :** mohamed.ahmed.rc@gmail.com

Invoice Management System


About the Project:


This is a fully functional Online Hotel Booking System built with Laravel, designed to provide users with a seamless and efficient booking experience.

Key Features:
- Invoice Creation: Users can add new invoices by specifying essential details such as invoice number, amount, customer name, and date.
  
- Invoice Management: A dashboard allows users to view all invoices in a table format, with options to search, filter, and paginate the list.
  
- CRUD Operations: Fully implemented Create, Read, Update, and Delete (CRUD) functionality for managing invoices.
  
- User Authentication: integrated user login and authentication to ensure secure access to invoice date.
  
- Database Management: Designed and implemented a MySQL database schema to store invoices and user data efficiently.
  
- Responsive UI: Used Bootstrap and JavaScript to create a simple, responsive user interface, making it easy to manage invoices on both desktop and mobile devices.



## Installation

To get started, clone this repository.

```
git clone https://github.com/MohamedAhmedv8/invoices-system
```

Next, copy your `.env.example` file as `.env` and configure your Database connection.

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=YOUR-DATABASE-NAME
DB_USERNAME=YOUR-DATABASE-USERNAME
DB_PASSWORD=YOUR-DATABASE-PASSWROD
```

## Run Packages and helpers

You have to all used packages and load helpers as below.

```
composer install
npm install
npm run build
```

## Generate new application key

You have to generate new application key as below.

```
php artisan key:generate
```

## Run Migrations and Seeders

You have to run all the migration files included with the project and also run seeders as below.

```
php artisan migrate
```
