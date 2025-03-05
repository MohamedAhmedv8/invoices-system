## Invoice Management System

<img src="https://media.licdn.com/dms/image/v2/D4D2DAQHyXn1t3hJAoQ/profile-treasury-image-shrink_800_800/profile-treasury-image-shrink_800_800/0/1728976741907?e=1741741200&v=beta&t=tOlDngj1vnwUdMEuzw0ENkUVwO0UAUg42sPy732zwoM">

**Created By :**  Mohamed Ahmed
**Email :** mohamed.ahmed.rc@gmail.com


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
