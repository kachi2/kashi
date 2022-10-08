<?php

use Illuminate\Database\Seeder;
use App\SmeData;
class SmeDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $data = [

            ['slug' => 'mtn', 'amount'=>'200', 'code' => '11', 'variation' => '500MB'],
            ['slug' => 'mtn', 'amount'=>'300', 'code' => '12', 'variation' => '1GB'],
            ['slug' => 'mtn', 'amount'=>'550', 'code' => '13', 'variation' => '2GB'],
            ['slug' => 'mtn', 'amount'=>'800', 'code' => '14', 'variation' => '3GB'],
            ['slug' => 'mtn', 'amount'=>'1200', 'code' => '15', 'variation' => '5GB'],
            ['slug' => 'mtn', 'amount'=>'2500', 'code' => '16', 'variation' => '10GB'],

        ];
        foreach($data as $sme){
            SmeData::create($sme);
        }
    }
}
