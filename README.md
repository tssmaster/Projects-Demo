### Manage projects and tasks using RESTful API

Technologies:
- PHP >= 7.4
- Laravel
- MySQL
- Bootstrap

Installation:
- You need to have installed XAMPP or similar package with PHP >= 7.2 (This project is created and tested with PHP version 7.4.9)
- Create project folder and clone repository
- Create database 'projects'
- In project folder open '.env' file and configure DB_USERNAME and DB_PASSWORD if needed. In production environment you need to generate .env with Jenkins and remove it from repository.
- In project folder open Bash console and type
    
    **composer install**
    
- To create database tables in Bash console type:

    **php artisan migrate**

- To start web server in Bash console type:
    
    **php artisan serve**
    
- In browser open http://127.0.0.1:8000/ or http://localhost:8000/

- If you want to change API endpoint open /config/app.php and change 'api_endpoint' value, the default is:

    **'api_endpoint' => 'http://127.0.0.1:8000/api/'**

Description:
- API models: /app/Projects.php, /app/Tasks.php
- API controllers: /app/Http/Controllers/ProjectsController.php, /app/Http/Controllers/TasksController.php
- API routes are defined in /routes/api.php 
- Front web controllers are: /app/Http/Controllers/ProjectsFrontController.php, /app/Http/Controllers/TasksFronController.php
- The web routes are defined in /routes/web.php
- The blade templates are in /resources/views
