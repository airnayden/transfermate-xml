<?php

namespace App\Command;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class Install extends BaseCommand
{
    /**
     * @return void
     */
    public function handle(): void
    {
        if (file_exists(__DIR__.'/../../install.lock')) {
            $this->line('Already installed!');
            return;
        }

        try {
            // Create `authors` table
            Capsule::schema()->create('authors', function(Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name');
                $table->timestamps();
            });

            // Create 'books` table
            Capsule::schema()->create('books', function(Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('author_id');
                $table->string('name');
                $table->timestamps();
            });

            // Add constraints
            Capsule::schema()->table('books', function (Blueprint $table) {
                $table->foreign('author_id')->references('id')->on('authors');
            });

            // Lock setup
            file_put_contents('install.lock', 'done');

            $this->line('Schema created! Don\'t try this again!');
        } catch (\Throwable $e) {
            $this->line('Error while running the installation! - ' . $e->getMessage());
        }
    }
}