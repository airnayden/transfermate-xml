<?php

namespace App\DataTransferObjects;

class BookObject
{
    /**
     * @param string $author
     * @param string $bookTitle
     */
    public function __construct(
        public string $author,
        public string $bookTitle
    ) {

    }
}