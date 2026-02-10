EO Tour System
A comprehensive tour booking and management system built with Laravel 12 with role-based access control and modern admin dashboard.

🚀 Features
🔐 Authentication & Authorization
User registration and login system

Role-based access control (RBAC)

Two user roles: Admin, Regular User

Permission management system

👨‍💼 Admin Panel
Dashboard with statistics (total tours, bookings, income, etc.)

Complete CRUD for tours management

Booking management system

Role and permission management

Search and filter functionality

Image upload for tours

👥 User Features
Browse available tours with details

Book tours with real-time price calculation

View booking history

User profile management

🎨 Frontend
Responsive design with Bootstrap 5

Tour slideshow and featured section

Detailed tour pages

Modern UI with EO color scheme

⚙️ Installation
1. Clone the repository
bash
git clone https://github.com/yourusername/eo-tour.git
cd eo-tour
2. Install PHP dependencies
bash
composer install
3. Install Node.js dependencies
bash
npm install
npm run build
4. Configure environment
bash
cp .env.example .env
php artisan key:generate
Edit .env file with your database credentials:

env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=eo_tour
DB_USERNAME=root
DB_PASSWORD=
5. Run migrations and seeders
bash
php artisan migrate --seed
6. Create storage link
bash
php artisan storage:link
7. Start development server
bash
php artisan serve
