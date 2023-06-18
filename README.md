# RTN - Player Overview Demo Solution

## Starting Up Locally

Estimated time to do this: 45 minutes.

Summary of commands to execute:

Copy .env and *.csv from `Coding Challenge` folder to the storage/seeders folder

```
./vendor/bin/sail up
docker exec -it rtn-player-overview-laravel.test-1 bash
php artisan migrate --seed
php artisan rtn-player-overview:populate-all-years
```

Paste in the .env file provided by Ervinne to the root directory. He should send an email with it as an attachment.

1. Start up the containers:

```
./vendor/bin/sail up
```

2. Bash in to the application

```
docker exec -it rtn-player-overview-laravel.test-1 bash
```

3. Migrate and seed
Copy the contents of the `Coding Challenge` folder to the storage/seeders folder then run:

```
php artisan migrate --seed
```

Note that the seeding process may take about 5-10 minutes. I've set the match stats seeder to log every 10k row of data inserted to see that the thing is still running.

4. Populate denormalized table used for cached data:

```
php artisan rtn-player-overview:populate-all-years
```

Populating the player overview should take about 15-20 minutes of processing.

## Dev Notes

### Sanctum Generated Tables
If you inspect the database, there should be an extra table `personal_access_tokens`, this is created by Laravel Sanctum. For this iteration, let's please ignore this table for now.

### Laravel Tables
`failed_jobs` should be retained for laravel background processes.

## Tech Debt Backlog

- Sanctum is not being used, find a way to gracefully uninstall it and prevent it from creating its own table when application is migrated

## Deployment

Dockerfile may be built and deployed to AWS Container Registry or similar solution. From there, ECS or AWS App Runner may be used to run the application.

WARNING: AWS App Runner is just an ECS without a load balancer and is easier to set up.  Under the hood both use EC2 so make sure you have credits in your AWS, or only deploy this with whitelisting to avoid uninteded costs. Double check the services created in AWS cloudformation to see which services are running.

I didn't actually try to deploy this as I'm out of credits right now and is running on my own credit card but it should work like how you normally deploy container based solutions.