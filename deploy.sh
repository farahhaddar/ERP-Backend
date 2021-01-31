#Run Database Migrateions
php artisan migrate:fresh

#Run seeds
php artisan db:seed --class=Teams
php artisan db:seed --class=Projects
php artisan db:seed --class=Roles
php artisan db:seed --class=TeamProjects
php artisan db:seed --class=Employees
php artisan db:seed --class=EmployeeProjectRoles
php artisan db:seed --class=Kpis
php artisan db:seed --class=KpiDetails
php artisan db:seed --class=UserSeeder