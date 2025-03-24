## Athena RestAPI for School Enrollment Application
# Created using Laravel 11 & Sanctum

## How to run
1. install depencency :
<code>composer install</code>
2. create file .env copied from .env.example and setting your own database, mail server.
3. generate new key :
<code>php artisan key:generate</code>
4. migrate and seeding into your database
<code>php artisan migrate --seed </code>
5. run your API
<code>php artisan serve</code>
