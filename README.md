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

## Answers

1. What problems do you identify in the current setup?
   1. Using CSV and JSON files as your cold storage solution does not scale well when working with big data. In most cases, they cannot be split into partitions for parallel processing, and cannot be compressed as well as binary formats.
   2. Without any restraints on the data model, CSV and JSON files are prone to data corruption.
   3. Easily can reach PHP memory_limit and often need to play with his value, or to setup to unlimited which will indicate more security risks.
   4. Fetching data from WebsiteDB will face with BigData problems.
2. What new architecture would you suggest that optimizes for performance, scalability, and reliability?
   1. Will think about Peer-to-peer architecture or maybe Microservice or Service Oriented architecture.
   2. But for this testcase and in interest of time I will try to achieve Monolith solution for this problem and give space for extend to Service or Microservice.
3. How would you ensure your chosen architecture is working as expected?
   1. Tests will be one of them.
   2. Resources and costs can be minimized.
4. For the new architecture you designed in answer to the question above, if you had to start from scratch, what team do you think you would need to pull off an MVP in 3 weeks? What would you leave outside this MVP and how would you prioritize the backlog?
   1. In a team with one or two backend developers this is possible to achieve. Outside the MVP I will leave cloud CD/CI integration, caching system maybe, and BigData problem with fetching data From WebsiteDB. Board will be organized in epics like 
      1. Import, 
      2. Store Imported Files,
      3. Queue and Process system 
      4. Store in WebsiteDB
      5. Logging system
5. For audit reasons, once the MVP is live, we would like to keep a snapshot of what data was pulled from Operators' APIs. How would you implement that?
   1. Make schedule DB backup (.sql script), with mysqldump if DB will be MySQL
   2. Can provide migration for DB schema for faster DB schema creation
   3. For test purposes can make fake data with Seed and Factories

## Contributing

The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## License

This project is solution for testcase for **TourRadar**, developed by 
**Zoran Panev** (panev.zoran.te@gmail.com)
