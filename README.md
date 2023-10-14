## Daily Sphere (Laravel + jQuery + Bootstrap)

[Daily Sphere](https://github.com/thesalahrand/daily-sphere-laravel-jquery-bootstrap) comes up with multiple trackers which are very essential in our day to day life such as:

1. Muslim Prayer Tracker
2. Muslim Fasting Tracker (Upcoming)
3. URL Shortener (Upcoming)
4. Transaction Tracker (Upcoming)

## Project Setup Guide

### Install PHP Dependencies

```
composer install
```

### Install Node Dependencies

```
npm install
```

### Database Setup

This app uses `MySQL`. To use `MySQL`, make sure you install it, setup a database and then add your db credentials (`db_name`, `db_username` and `db_password`) to the `.env.example` file and rename it to `.env`

### Migrations and Seeding

To create all the necessary tables and columns, run the following

```
php artisan migrate --seed
```

Through seeding, some `fixed` and `mandatory` rows have been inserted into the following tables `prayer_names`, `prayer_types`, `prayer_variations`, `prayer_offering_options`. Rows from those `4 tables` must not be altered.

### File Uploading

When uploading listing files, they go to "storage/app/public". Create a symlink with the following command to make them publicly accessible.

```
php artisan storage:link
```

### Running The App

On localhost, run:

```
npm run dev
```

and,

```
php artisan serve
```

### Test Website

[Daily Sphere](https://github.com/thesalahrand/daily-sphere-laravel-jquery-bootstrap) is running successfully on [https://daily-sphere-test.salahrand.me/](https://daily-sphere-test.salahrand.me/) so that you may play around with it.

## License

[Daily Sphere](https://github.com/thesalahrand/daily-sphere-laravel-jquery-bootstrap) is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
