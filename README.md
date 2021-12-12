# Ad API

## Instructions

-   copy .env.example to .env
-   `composer install`
-   `php artisan migrate --seed`
- `php artisan queue:work`
-   `\* \* \* \* \* cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1`


-  change email configuration variables in .env file

### Run Testing
- `php artisan test`

[Post man collection](https://www.getpostman.com/collections/9cebaceed656a1a8315a).
