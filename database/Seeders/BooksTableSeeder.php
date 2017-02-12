<?php

use Illuminate\Database\Seeder;

use LaccBook\Models\Book;

class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = \LaccBook\Models\Category::all();

        factory( Book::class, 50 )->create()->each(function ( $book ) use ( $categories ) {
            $categoriesRamdom = $categories->random( 4 );

            $book->categories()->sync( $categoriesRamdom->pluck( 'id' )->all() );

        });
    }
}
