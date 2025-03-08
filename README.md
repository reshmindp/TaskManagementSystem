Task Management API

Prerequisites
Ensure you have the following installed:
PHP 8.2+
MySQL
Composer
Laravel 11+

Installation
Step 1: Clone the Repository
Step 2: Open the project in VSCode editor
Step 3: Install Dependencies: composer install
Step 4: Set Up Environment Variables: cp .env.example .env
Step 5: Update the .env file with your database credentials:
        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=task_management_db
        DB_USERNAME=root
        DB_PASSWORD=
Step 6: Generate App Key: php artisan key:generate
Step 7: Run Migrations: php artisan migrate
Step 8: Configure Queue Driver: Set the queue driver to database in the .env file:
        QUEUE_CONNECTION=database

API Endpoints
Authentication (Sanctum)
1. Register: POST /api/register
   Request body:
   {
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password"
   }   

2. Login: POST /api/login
   Request body:
   {
    "email": "john@example.com",
    "password": "password"
   }

Task Management 
3. Create Task: POST /api/tasks
   Request body:
   {
    "title": "New Task",
    "description": "Task description",
    "due_date": "2025-03-10 12:00:00"
   }

Start the queue worker to send notification email: php artisan queue:work

4. Assign Task: PUT /api/tasks/{id}/assign
   Request body:
   {
    "assigned_to": 2
   }
5. Mark Task Completed: PUT /api/tasks/{id}/complete
6. List Tasks with Filters: GET /api/tasks?status=pending&assigned_to=2

Logging Execution Time
Request execution time will be logged in storage/logs/laravel.log.

Run Scheduler
To process scheduled commands, need to add the following cron job in the server: 
* * * * * php /path-to-your-project/artisan schedule:run >> /dev/null 2>&1

To test manually in local server run this command in terminal: php artisan schedule:run