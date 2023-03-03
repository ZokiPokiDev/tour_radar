# TourRadar testcase solution

## Start and setup Laravel project

Based on Laravel Sail build in package, on the next link can be found 
official documentation about it
https://laravel.com/docs/9.x/installation#getting-started-on-linux

Basically you need to run

```allykeynamelanguage
cd solution

./vendor/bin/sail up -d
```

Setup project and DB:

```allykeynamelanguage
./vendor/bin/sail artisan optimize:clear
./vendor/bin/sail artisan migrate
```

Solution is implemented with commands placed in the importers folder.
To start pull from operator 1 run:

```allykeynamelanguage
./vendor/bin/sail artisan solution:importer_1
```

Processor logic is inside Factories folder. Queue is implemented with Job.

Useful links:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

## Contributing

The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## License

This project is solution for testcase for **TourRadar**, developed by 
**Zoran Panev** (panev.zoran.te@gmail.com)
