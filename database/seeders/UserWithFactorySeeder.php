<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserWithFactorySeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        User::factory()
            ->times(5)
            ->hasReplies(3)
            ->hasDiscussions(3)
            ->create();
    }
}
