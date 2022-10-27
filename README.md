# XML Books Organizer ###

## Requirements
PHP 8.1

PostgreSQL

## Description
This is a proof-of-concept mini framework, written from scratch in order to carry out very simple tasks, like basic console commands and controller actions.

## Demo
http://transfermate.drpanchev.com/

## Searching
Search is looking into both books and author names.

## Installation
0. Clone the repo locally
1. Run `composer install` in order to get the dependencies
2. Rename `.env.example` to `.env`
3. Set the DB credentials in the `.env` file
4. Run `php transfermate Install` in order to create DB schema
5. Run `php transfermate ScanFiles` in order to scan the XML books from `books` directory and subdirectories. This file can be set as a CRON job as well in order to automatically refresh the database.
6. Set up a vhost or similar, which points to `public` directory
7. If you want to access the stored data, navigate to your project's root in the browser and you will see a search form and results.

## Testing
Unit and functional tests are `NOT` provided.

## Localization
Application is still not localized and all of the text is hardcoded into the template files.

## What's missing:
1. Proper exception handler
2. Router
3. Other stuff a proper framework should have