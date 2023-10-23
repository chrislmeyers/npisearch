# NPI Search

This Laravel site searches the NPI registry located here: [https://npiregistry.cms.hhs.gov/api-page](https://npiregistry.cms.hhs.gov/api-page)

To run:

- Make sure you have [Laravel](https://laravel.com/), [Composer](https://getcomposer.org/), [Docker](https://www.docker.com/) and all the supporting pieces installed locally.
- Clone the repository
- `cd npisearch`
- `composer install`
- `cp .env.example .env`
- `php artisan key:generate`
- `sail up -d`
- `npm install`
- `npm run dev`
