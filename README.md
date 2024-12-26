# Dockerized Laravel Project

This project includes a Laravel application configured to run in a Docker environment. The Docker setup includes services for Nginx, PHP-FPM, MySQL, Redis, Node.js, queue workers, Horizon, and MailHog, providing a comprehensive environment for developing and deploying Laravel applications.

Additionally, the project includes a job for sending emails, which can be tracked using Horizon. There is also a pre-written test for this job to ensure its functionality.

## Requirements

- Docker
- Docker Compose

## Installation

1. Clone the repository:

   ```
   git clone https://github.com/josecortesdev/laravel-horizon-dockerized
   cd laravel-horizon-dockerized
   ```


3. In the root of the project, build and lift the containers:
```
docker-compose up -d --build
```  

4. Install Composer dependencies:
```
docker-compose exec app composer install
``` 

5. Generate the application key:
```
docker-compose exec app php artisan key:generate
``` 
6. Publish Horizon assets:
```
docker-compose exec app php artisan horizon:publish
``` 

7. Run the migrations
```
docker-compose exec app php artisan migrate
```  

## Development use

```
docker-compose up
```


# Testing Jobs in Laravel Horizon

## Dispatch a Job

To dispatch a job that sends an email, navigate to the following URL in your browser:

http://localhost:8080/dispatch-email-job


## Access Horizon

To see the status of the job in Horizon, navigate to the following URL in your browser:

http://localhost:8080/horizon/jobs/completed


## Access MailHog

To see the email captured by MailHog, navigate to the following URL in your browser:

http://localhost:8025/


## Running Unit Tests

To run the unit tests, follow these steps:

1. **Start the Containers**: Make sure the Docker containers are running:
    ```sh
    docker-compose up -d
    ```

2. **Run the Tests**: Use the following command to run the unit tests:
    ```sh
    docker-compose exec app php artisan test
    ```

These steps will allow you to run the unit tests to verify that the `SendEmailJob` works correctly.

## Accessing the Database

To access the MySQL database, use the following credentials:

- **Host**: `localhost`
- **Port**: `3307`
- **Database**: `laravel`
- **Username**: `laravel`
- **Password**: `secret`

You can use a database client like MySQL Workbench, HeidiSQL, or phpMyAdmin to connect to the database.


## Suggestions
Suggestions are welcome. Please write to me at josecortesdev@gmail.com