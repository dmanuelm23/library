<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('categories')->truncate();
        Schema::enableForeignKeyConstraints();
        DB::table('categories')->insert([
            [
                'name'=> 'Action and Adventure',
                'description' =>'Lorem ipsum dolor sit amet consectetur adipisicing elit. Tenetur, aut. Repellat magni repellendus nulla esse quod labore est. Sapiente necessitatibus reprehenderit nemo soluta, possimus ducimus eius ea totam id aliquam!',
                'status' => '1',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'=> 'Classics',
                'description' =>'Lorem ipsum dolor sit amet consectetur adipisicing elit. Tenetur, aut. Repellat magni repellendus nulla esse quod labore est. Sapiente necessitatibus reprehenderit nemo soluta, possimus ducimus eius ea totam id aliquam!',
                'status' => '1',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'=> 'Comic Book or Graphic Novel',
                'description' =>'Lorem ipsum dolor sit amet consectetur adipisicing elit. Tenetur, aut. Repellat magni repellendus nulla esse quod labore est. Sapiente necessitatibus reprehenderit nemo soluta, possimus ducimus eius ea totam id aliquam!',
                'status' => '1',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'=> 'Detective and Mystery',
                'description' =>'Lorem ipsum dolor sit amet consectetur adipisicing elit. Tenetur, aut. Repellat magni repellendus nulla esse quod labore est. Sapiente necessitatibus reprehenderit nemo soluta, possimus ducimus eius ea totam id aliquam!',
                'status' => '1',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'=> 'Fantasy',
                'description' =>'Lorem ipsum dolor sit amet consectetur adipisicing elit. Tenetur, aut. Repellat magni repellendus nulla esse quod labore est. Sapiente necessitatibus reprehenderit nemo soluta, possimus ducimus eius ea totam id aliquam!',
                'status' => '1',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'=> 'Historical Fiction',
                'description' =>'Lorem ipsum dolor sit amet consectetur adipisicing elit. Tenetur, aut. Repellat magni repellendus nulla esse quod labore est. Sapiente necessitatibus reprehenderit nemo soluta, possimus ducimus eius ea totam id aliquam!',
                'status' => '1',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'=> 'Horror',
                'description' =>'Lorem ipsum dolor sit amet consectetur adipisicing elit. Tenetur, aut. Repellat magni repellendus nulla esse quod labore est. Sapiente necessitatibus reprehenderit nemo soluta, possimus ducimus eius ea totam id aliquam!',
                'status' => '1',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'=> 'Literary Fiction',
                'description' =>'Lorem ipsum dolor sit amet consectetur adipisicing elit. Tenetur, aut. Repellat magni repellendus nulla esse quod labore est. Sapiente necessitatibus reprehenderit nemo soluta, possimus ducimus eius ea totam id aliquam!',
                'status' => '1',
                'created_at' => date('Y-m-d H:i:s')
            ],
        ]);
    }
}
