# XML Books Organizer ###

## Requirements
PHP 8.1
PostgreSQL

## Installation
1. Run `composer install` in order to get the dependencies
2. Rename `.env.example` to `.env`
3. Set the DB credentials in the `.env` file
4. Run `php command Install` in order to create DB schema
5. Run `php command ScanFiles` in order to scan the XML books from `books` directory and subdirectories. This file can be set as a CRON job as well in order to automatically refresh the database.
6. Set up a vhost or similar, which points to `public` directory
7. If you want to access the stored data, navigate to your project's root in the browser and you will see a search form and results.

## Testing
Unit and functional tests are `NOT` provided.