## System Information School
School information system is a useful website to facilitate school data collection. Built with laravel v.7.0, vue.js v.2.5.17, vue router v.3.3.4 and vuex v.3.4.0
### Before installation
- Please configuration database for this projects. Change in .env.example to .env
- php v.7 or later
### Installation

```
npm install
composer install
php artisan key:generate
php artisan config:clear
php artisan view:clear
php artisan application:install
```
### Middleware
- Administrator
- Admin
- Teacher
### Feature
- Admin Template
- Dashboards
- CRUD school
- CRUD class
- CRUD study
- CRUD teacher
- CRUD student
- CRUD homeroom teacher
- CRUD task assessment
- CRUD report card
- Export excel in all tables
- Import excel in all tables
- Notes
### Package npm yang digunakan
- axios
- jquery
- chart.js
- laravel-vue-pagination
- metismenu
- sweetalert2
### Package composer yang digunakan
- laravel/passport
- maatwebsite/excel
### Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.
