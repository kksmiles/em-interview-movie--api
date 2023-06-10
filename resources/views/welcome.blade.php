<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <style>
            body {
                font-size: 22px;
                text-align: center;
                margin-top: 300px
            }
        </style>
    </head>
    <body class="antialiased">
        <span>
            You can either 
            <br> <br>
            Test through the postman collection provided in the root directory <b> em-interview-movie-api.postman_collection.json </b> 
            <br> <br>
            < or >
            <br> <br>
            Run <code>`php artisan scribe:generate`</code> to generate API documentation and access it at <b><a href="/docs">/docs</a></b>
        </span>
    </body>
</html>
