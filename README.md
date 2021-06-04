## About MonerisAssignment

This is test assignment for simple service for Moneris Payment Provider integration.

## How to use

- *`git clone https://github.com/arxymond/moneris.git`*
- *`cd moneris`*
- *`composer install`*
- *`php artisan key:generate`*
- *`chmod -R 777 storage`*
- *`cp .env.example .env`*

For this test sqlite was used as DB, so modifications in .env DB section needed.
Replace 
```.env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=moneris
DB_USERNAME=root
DB_PASSWORD=
```

with 

```.env
DB_CONNECTION=sqlite
DB_DATABASE=Full/Path/To/storage/moneris.sqlite
```


- *`php artisan migrate:fresh --seed` - this will regenerate all DB tables and add some mocks*
- *`php artisan serve` - to run application*

## Notes

- *in routes/web.php there is one route for testing the application. It is getting Customer with ID:2 and tries to charge for $1.1. In your case it can throw an ``NoDefaultPaymentMethodException``. This is done for demonstration purposes. Just try another Customer, there will be 10 Customers with IDs 1-10.*
- *in .env file there are configs for connecting to Moneris test environment. Other test values can be found in [Moneris official documentation](https://developer.moneris.com/en/More/Testing/Testing%20a%20Solution)*
