# Restaurant aplication manager

This is Backend part of the project.
To see frontend part of the project - https://github.com/MindaugasPaskevicius/restaurant-backend.git
Project will run if both frontend and back end parts are started.

### About project

* Used techonologies:
    - frontend: React library.
    - backend: Laravel framework
    - database: MYSQL

* Project:
    - Is secured with authentication and users have roles
    - Can show all restaurants form database
    - User add and delete dish to restaurant.
    - Have admin page.
    - Admin can add, delete, edit restaurant and dish from app.

### Launching Back_End part

Clone backend part repository.
git clone https://github.com/MindaugasPaskevicius/restaurant-backend.git

For project to run we need PHP interpreter(XAMPP), MySQL Workbench.
- Run Xaamp MYSQL module.
- In MYSQL workbench create schema named laravelapi.
- Change .env.example name to .env
- inside cloned folder run: composer install
- Now run migrations and seeders by typing in terminal:
- php artisan migrate  // php artisan db:seed
- php artisan serve
- if both frontend and backend parts are on project is live at
- http://localhost:3000
- Admin acount:
-  email: admin@admin.com password: admin


## Author

Project is created by Mindaugas Paškevičius.

Github - MindaugasPaskevicius.

