# Technical Test

## Tasks
1. Create an Application that connects to MySQL
2. Create a routine that receive: Date Range, Status and Location (The fields must be optional to the final user) and return the list of invoices with the following information: Location name, date, status and total invoice value.
3. Create a routine that receives the location id and return the sum of invoice values grouped by status.
4. Create a simple list page to show the result

## Info
- The structure or the DB with some examples can be find on /dump
- Use the framework of your preference
- Submit your code via pull request
- List on README.md all files with your own code

Good luck :)


## Set up instructions
```
cp .env.example .env
composer install
npm install
npm run dev
php artisan key:generate
docker-compose up --build
env DB_HOST=127.0.0.1 php artisan migrate:fresh --seed

# run unit tests
vendor/bin/phpunit

# visit web page
http://localhost:8000/
```

## Reference files for the task

* app/Models/(InvoiceHeader|InvoiceLine|Location).php
* app/Service/InvoiceService.php
* app/Http/InvoiceController.php
* database/migrations/2021_02_*
* database/factories/(InvoiceHeader|InvoiceLine|Location)Factory.php
* database/seeders/BaseTableSeeder.php
* resources/views/index.blade.php
* routes/web.php
* tests/*.php
* docker-compose.yml
* Dockerfile
