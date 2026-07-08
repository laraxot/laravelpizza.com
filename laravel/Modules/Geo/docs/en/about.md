
The Laravel module_tenant is a package that allows developers to easily set up multi-tenancy in their Laravel applications.

To install the package, you can use Composer by running the following command:

Copy code
composer require laraxot/module_tenant
Once the package is installed, you can register the service provider in your config/app.php file by adding the following line to the providers array:

Copy code
Laraxot\ModuleTenant\TenantServiceProvider::class,
To publish the package's configuration file, you can run the following command:

Copy code
php artisan vendor:publish --provider="Laraxot\ModuleTenant\TenantServiceProvider"
This will create a config/module_tenant.php file where you can customize the package's settings.

To create a tenant, you can use the laraxot:tenant Artisan command. For example, to create a tenant with the name acme, you can run the following command:

Copy code
php artisan laraxot:tenant acme
This will create a new database and run all of the necessary migrations to set up the tenant's database schema.

To switch to a tenant's database, you can use the tenant helper function. For example, to switch to the acme tenant's database, you can use the following code:

Copy code
tenant('acme');
From this point, all database queries will be run against the acme tenant's database. To switch back to the default database, you can use the resetTenant helper function like this:

Copy code
resetTenant();
The module_tenant package makes it easy to set up and manage multi-tenancy in your Laravel applications. For more detailed information, please see the package's README file on GitHub.

