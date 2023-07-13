<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Personnel ;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $personnels = [
            [
                "name"=> "admin",
                "email"=> "admin@gmail.com",
                "phone"=> "257679",
                "date_of_birth"=> "2023-02-25",
                "salary"=>1200, 
                "role_id"=>1,
                "position"=>"ing" , 
                "password"=>bcrypt("14hjgjkjhkhjb"),
            ],
             [
            
                    "name"=> "manager",
                    "email"=> "manager@gmail.com",
                    "phone"=> "257679",
                    "date_of_birth"=> "2023-02-25",
                    "salary"=>1200, 
                    "role_id"=>2,
                    "position"=>"ing" , 
                    "password"=>bcrypt("14hjgjkjhkhjb"),
            
            ],
              [
                "name"=> "technician",
                "email"=> "technician@gmail.com",
                "phone"=> "257679",
                "date_of_birth"=> "2023-02-25",
                "salary"=>1200, 
                "role_id"=>3,
                "position"=>"ing" , 
                "password"=>bcrypt("14hjgjkjhkhjb"),
            
            ],];
            
        foreach ($personnels as $personnelData) {
            Personnel::create($personnelData);
    }
    }
}
