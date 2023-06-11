# Introduction

This application is build with the following stacks : PHP ^8.1 + Laravel ^10.10. I've made use of https://scribe.knuckles.wtf/ to document the APIs. You can either test through the postman collection in the root directory em-interview-movie-api.postman_collection.json or access the documentation at /docs after generating with the following command :

```
php artisan scribe:generate
```

# Solution Approach

Here's a database diagram of the application :

![em er](https://github.com/kksmiles/em-interview-movie--api/assets/39384662/6632264d-6f0e-4037-ab53-c1748f083346)

All the endpoints follow the laravel conventions for RESTful API resources along with restore, force destroy for models with soft delete. Currently there's no authentication implemented in the application. For APIs that require authentication, I would use Laravel Sanctum or Laravel Passport to implement token based authentication if it is a requirement.

There are some notable quirks in the application that I would like to highlight : 
1. I've used local storage driver for storing the images. This is not recommended for production environment. I would use S3 or any other cloud storage service for storing the images. Also instead of linking the storage with public, I've made a custom MoviePictureController to handle the image fetching. Normally I would have a seperate file model, controller and a service to handle all the drivers and file related operations in one place. But for the sake of simplicity I've used the MoviePictureController controller to handle storage driver local only.
2. I've created a job to clear the deleted movie pictures from the storage after 7 days.
3. For now, I've relied on eloquent eager loading to fetch the related models. But if the application grows, we can add json columns to the tables to act as a cache for the related models which will be populated through jobs/queues. This will reduce the number of queries to the database and improve the performance of the application.
4. To filter movies by categories or tags, you can either use show endpoints of tags and categories for single filtering or use the index endpoint of movies for multiple filtering. Here are some examples :
```
GET /api/tags/1
GET /api/categories/1
```
```
GET /api/movies?category_ids[]=1&category_ids[]=2&tag_ids[]=1&tag_ids[]=2
```

# How to run

## Method 1 Using Laravel Sail with Docker

Make sure you have composer on your machine and your docker is running when using this method.

Step 1 - Run the following command to install the dependencies

```
composer install
```

Step 2 - Copy the .env.example file to .env

```
cp .env.example .env
```

Step 3 - Generate APP_KEY

```
php artisan key:generate
```

Step 4 - Run the following command to start the docker container

```
./vendor/bin/sail up -d
```

Step 5 - Once the container is up, Run the following command to run the migrations

```
./vendor/bin/sail artisan migrate:fresh --seed
```

Step 6 - You can now access the application on env('APP_URL') : http://movie-api.test

## Method 2 Installing Laravel on your local machine

You'll need to have PHP 8.1 and composer installed on your local machine to use this method.

Step 1 - Run the following command to install the dependencies

```
composer install
```

Step 2 - Copy the .env.example file to .env

```
cp .env.example .env
```

Step 3 - Generate APP_KEY

```
php artisan key:generate
```

Step 4 - Run the following command to run the migrations

```
php artisan migrate:fresh --seed
```

Step 5 - Run the following command to start the application

```
php artisan serve
```

Step 6 - You can now access the application on 127.0.0.1:8000
