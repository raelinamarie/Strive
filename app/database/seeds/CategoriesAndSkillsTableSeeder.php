<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class CategoriesAndSkillsTableSeeder extends Seeder {

	public function run()
	{
        $categoriesAndSkills = [
            ['name' => 'Admin / Office', 'skills' => ['Reception','Data Entry','Administrative']],
            ['name' => 'Customer Service', 'skills' => ['Call Center','Sales Rep']],
            ['name' => 'Food', 'skills' => ['Wait Staff','Hostess','Manager','Bar Staff','Preparation','Clean-Up']],
            ['name' => 'Hospitality', 'skills' => ['Reception','Tours','Maintenance']],
            ['name' => 'General Labor', 'skills' => ['Construction','Lawn Care','Moving','General Maintenance']],
            ['name' => 'Government', 'skills' => []],
            ['name' => 'Manufacturing', 'skills' => ['Maintenance','Machinist','Production','Assembly','Equipment Operator','Warehouse and Shipping']],
            ['name' => 'Non-Profit', 'skills' => []],
            ['name' => 'Retail / Wholesale', 'skills' => ['Sales','Customer Service','Delivery','Warehouse']],
            ['name' => 'Sales', 'skills' => ['Retail','Call Center']],
            ['name' => 'Fitness', 'skills' => ['Trainer','Reception']],
            ['name' => 'Security', 'skills' => ['Officer','Surveillance']],
            ['name' => 'Skilled Trade / Craftsman', 'skills' => ['Carpentry','Electrical','Plumbing','HVAC','Construction','Automotive','Computer','Information Technology']],
            ['name' => 'Transportation', 'skills' => ['Drivers','Delivery','Warehouse']],
            ['name' => 'Part-Time', 'skills' => ['Seasonal','General']],
            ['name' => 'Beauty', 'skills' => ['Hair','Nails']],
            ['name' => 'Mental Health', 'skills' => []],
            ['name' => 'Legal', 'skills' => []],
            ['name' => 'Accounting/Finance', 'skills' => []],
            ['name' => 'Computers / IT', 'skills' => ['Technical Support','Web']],
            ['name' => 'Writing / Editing', 'skills' => []],
            ['name' => 'Translation', 'skills' => []]
        ];
        foreach($categoriesAndSkills as $srcCategory){
            $category = Category::create(['name'=>$srcCategory['name']]);
            foreach($srcCategory['skills'] as $skill){
                Skill::create(['name' => $skill,'category_id' => $category->id]);
            }
            Skill::create(['name'=>'Other','category_id'=>$category->id]);
        }
	}

}