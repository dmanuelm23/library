<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('books')->truncate();
        Schema::enableForeignKeyConstraints();
        DB::table('books')->insert([
            [    
                'name'=> "Tom Clancy's Oath of Office",
                'author' =>'Marc Cameron',
                'publication_date' => '2019-10-17',
                'category_id' => 1,
                'status' => '1',
                'created_at' => date('Y-m-d H:i:s')   
            ],
            [    
                'name'=> "Black Sun",
                'author' =>'Owen Matthews',
                'publication_date' => '2019-10-03',
                'category_id' => 1,
                'status' => '1',
                'created_at' => date('Y-m-d H:i:s')   
            ],
            [    
                'name'=> "To Kill A Mockingbird",
                'author' =>'Harper Lee',
                'publication_date' => '2010-06-24',
                'category_id' => 2,
                'status' => '1',
                'created_at' => date('Y-m-d H:i:s')   
            ],
            [    
                'name'=> "Pride and Prejudice",
                'author' =>'Jane Austen  Vivien Jones (Edited by)  Tony Tanner (Introducer)',
                'publication_date' => '2008-11-06',
                'category_id' => 2,
                'status' => '1',
                'created_at' => date('Y-m-d H:i:s')   
            ],
            [    
                'name'=> "The Handmaid's Tale",
                'author' =>'Margaret Atwood  Renée Nault (Illustrator)',
                'publication_date' => '2019-03-26',
                'category_id' => 3,
                'status' => '1',
                'created_at' => date('Y-m-d H:i:s')   
            ],
            [    
                'name'=> "Rain",
                'author' =>'Bryan and Mary Talbot',
                'publication_date' => '2019-10-03',
                'category_id' => 3,
                'status' => '1',
                'created_at' => date('Y-m-d H:i:s')   
            ],
            [    
                'name'=> "The Burning Girls",
                'author' =>'C. J. Tudor',
                'publication_date' => '2021-01-21',
                'category_id' => 4,
                'status' => '1',
                'created_at' => date('Y-m-d H:i:s')   
            ],
            [    
                'name'=> "Prodigal Son",
                'author' =>'Gregg Hurwitz',
                'publication_date' => '2021-05-27',
                'category_id' => 4,
                'status' => '1',
                'created_at' => date('Y-m-d H:i:s')   
            ],
            [    
                'name'=> "The Starless Sea",
                'author' =>'Erin Morgenstern',
                'publication_date' => '2019-11-05',
                'category_id' => 5,
                'status' => '1',
                'created_at' => date('Y-m-d H:i:s')   
            ],
            [    
                'name'=> "The Gormenghast Trilogy",
                'author' =>'Mervyn Peake',
                'publication_date' => '1999-04-01',
                'category_id' => 5,
                'status' => '1',
                'created_at' => date('Y-m-d H:i:s')   
            ],
            [    
                'name'=> "Burnt Sugar",
                'author' =>'Avni Doshi',
                'publication_date' => '2020-07-30',
                'category_id' => 6,
                'status' => '1',
                'created_at' => date('Y-m-d H:i:s')   
            ],
            [    
                'name'=> "Grown Ups",
                'author' =>'Marian Keyes',
                'publication_date' => '2020-02-06',
                'category_id' => 6,
                'status' => '1',
                'created_at' => date('Y-m-d H:i:s')   
            ],
        ]);
    }
}
