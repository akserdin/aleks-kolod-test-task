<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\NoteModel::truncate();

        factory(\App\NoteModel::class, rand(24, 32))->create();
    }
}
