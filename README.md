<<<<<<< HEAD
# Orpawnage
A web-based pet adoption website for Angeles City Veterinary Office

---
<strong>1. Clone the repository</strong> 
```bash
git clone https://github.com/jdbacuno/orpawnage.git
```
Then, install Laravel Herd and move cloned project folder into Herd's project directory.

<strong>2. Install and Set up MySQL</strong>
- Install and set up MySQL
- Create a database named `orpawnage`

<strong>3. Install and Set up TablePlus</strong>
- Install and set up TablePlus
- Connect TablePlus to the database you created using MySQL

<strong>4. Populate Admin Account</strong>
```bash
php artisan migrate:fresh --seed
```

<strong>5. Install NPM</strong> 
```bash
npm i
```

<strong>6. Install Composer</strong> 
```bash
composer i
```

<strong>7. Copy the example environment file:</strong> 
```bash
cp .env.example .env
```

<strong>8. Open the .env file and set the following configuration options:</strong> 
- **APP_NAME**: Set this to the name of your application.

- **APP_ENV**: Set this to `local` for local development. You can change it to `production` if you're deploying the application to a production server.

- **APP_KEY**: If you do not have a key yet, generate one using the command `php artisan key:generate`.

- **APP_DEBUG**: Set this to `true` for local development to enable debugging. Set it to `false` in production.

- **APP_URL**: Set this to the URL for your local development or production environment.

```bash
APP_NAME=Orpawnage
APP_ENV=local
APP_KEY=your_generated_app_key_here
APP_DEBUG=true
APP_URL=your_app_url

# Database Configuration (update according to your setup)
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```
<strong>9. Create config.py in the `scripts/ml` folder</strong> 

Create a file named `config.py` inside the `scripts/ml` directory and add your database credentials: (must be the same credentials you put in the `.env` file)

```bash
# config_template.py
DB_CONFIG = {
    'username': 'your_database_username',
    'password': 'your_database_password',
    'host': 'localhost',
    'database': 'your_database_name',
    'dialect': 'mysql',
    'driver': 'pymysql'
}
```

<strong>10. Build Assets for Development</strong> 
```bash
npm run dev
```

<strong>11. Install Python</strong> 
- Install Python and add make sure to click **ADD TO PATH**, so that `python` command will be recognized
- Checkout the `prediction_script.py` file in the `scripts/ml` folder and install the necessary modules
- Checkout the `UpdateFeaturedPets.php` file in the `app\Console\Commands` folder and modify according to your Python installation folder

<strong>12. Run Scheduler</strong>
```bash
php artisan schedule:run
```
---
**You must setup the cron or task scheduler:**
Setting up Laravel Scheduler on Windows with Task Scheduler

1. **Open Task Scheduler**  
   Press **Win + R**, type `taskschd.msc`, and press Enter.

2. **Create a New Task**  
   In **Task Scheduler**, click **Create Task** on the right side.

3. **General Settings**  
   - **Name** the task: `Laravel Schedule Run`.
   - **Configure for**: Choose your Windows version.
   - **Run with highest privileges**: Check this if necessary.

4. **Trigger**  
   - Click the **Triggers** tab, then click **New**.
   - Set **Begin the task** to **On a schedule** and choose **Daily**.
   - Set **Repeat task every** to **1 minute** for **Indefinitely**.

5. **Action**  
   - Click the **Actions** tab, then **New**.
   - Select **Start a program**.
   - **Program/script**: Browse to **php.exe** (e.g., `C:\xampp\php\php.exe`).
   - **Add arguments**: `artisan schedule:run`
   - **Start in**: Path to your Laravel project.

6. **Save the Task**  
   Click **OK** to save the task.

7. **Confirm the Task Runs**  
   Test by right-clicking the task in Task Scheduler and selecting **Run**.

--- 

This will make sure your Laravel scheduler runs every minute.

<strong>13. Routes</strong>
- Start the Laravel Herd app, make sure NGINX and PHP are active
- Go the browser and in the address bar, type: http://`your_project_folder_name.test`. It should direct you to signin / signup page.
- You may proceed to sign up a new user account or login as admin with the following credentials:
**ADMIN USERNAME:** `admin@orpawnage.com`
**ADMIN PASWORD:** `!Admin0329`
---
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
>>>>>>> a71a53f (First commit)
