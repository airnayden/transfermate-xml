<?php

namespace App\Actions;

use Carbon\Carbon;
use Illuminate\Database\Capsule\Manager as Capsule;

class CreateAuthorRecord
{
    /**
     * @param string $name
     * @return int
     */
    public static function execute(string $name): int
    {
        return Capsule::table('authors')->insertGetId([
            'name' => $name,
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString(),
        ]);
    }
}