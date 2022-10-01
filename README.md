### Manage projects and tasks using RESTful API

Technologies used:
- PHP >= v.7.4.9
- Laravel
- MySQL
- Bootstrap

Installation:

- You need to have installed XAMPP or similar package with PHP >= 7.4.9

- Clone repository

- Create database 'projects'

- In project folder open '.env' file and configure DB_USERNAME, DB_PASSWORD, mail settings

- In project folder open Bash console and type

    **composer install**
    
- To create database tables in Bash console type

    **php artisan migrate**

- To start web server in Bash console type
    
    **php artisan serve**
    
- In browser open http://127.0.0.1:8000/ or http://localhost:8000/. You also can cofigure Apache server to open specific address like http://projects-demo.dev which must serve /public folder in project

- If you want to change API endpoint open .env and change API_ENDPOINT value, the default is:

    **API_ENDPOINT=http://127.0.0.1:8000/api/**

Structure description:
- API models: /app/Projects.php, /app/Tasks.php
- API backend controllers: /app/Http/Controllers/ProjectsController.php, /app/Http/Controllers/TasksController.php
- API routes are defined in /routes/api.php 
- Frontend controllers are: /app/Http/Controllers/ProjectsFrontController.php, /app/Http/Controllers/TasksFrontController.php
- The web routes are defined in /routes/web.php
- The blade templates are in /resources/views
