
## Simple Calendar

A project for the coding challenge of [Appetiser Apps](https://appetiser.com.au/).

## Installation

- **Basic Installation Commands**
> - `composer install`
> - `npm install && npm run dev`

- **Run tests**
> - `vendor\bin\phpunit` or `php artisan test`

- **Run migrations**
 > - `php artisan migrate`

## Project overview

- **Database design**
> I chose multiple row structure rather than one column with json data for days and multiple column for days for **Simplicity**.
> To avoid too much parsing of data and to achieve the goal presented by the demo video.

- **Functionality**
> A simple event calendar which overrides the current event whenever a new one is added. It has simple validations,
> alerts and basic user interface.

- **Technical**
> - Created and written using Laravel and Vuejs frameworks.
> - IDE: Phpstorm
> - Plugins and other toolkits: Izitoast, Font awesome icons




