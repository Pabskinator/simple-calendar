<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="/css/app.css">

        <title>Simple Calendar</title>
    </head>
    <body>
        <div id="app">
            <div class="container-fluid p-3">
                <router-view></router-view>
            </div>
        </div>
    </body>
    <script src="/js/app.js"></script>
</html>
