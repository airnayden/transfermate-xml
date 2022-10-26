<?php

namespace App\Actions;

use App\DataTransferObjects\BookObject;
use Carbon\Carbon;
use Illuminate\Database\Capsule\Manager as Capsule;

class CreateOrUpdateBookRecord
{
    /**
     * @param BookObject $bookObject
     * @param int $authorId
     * @return void
     */
    public static function execute(BookObject $bookObject, int $authorId): void
    {
        $book = Capsule::table('books')
            ->select('id')
            ->where([
                'author_id' => $authorId,
                'name' => $bookObject->bookTitle
            ])
            ->first();

        if (is_null($book)) {
            Capsule::table('books')->insert([
                'author_id' => $authorId,
                'name' => $bookObject->bookTitle,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ]);
        } else {
            Capsule::table('books')->where('id', $book->id)->update([
                'updated_at' => Carbon::now()->toDateTimeString()
            ]);
        }
    }
}