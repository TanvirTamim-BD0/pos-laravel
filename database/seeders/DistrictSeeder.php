<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\District;
use Illuminate\Support\Facades\DB;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
     public function run()
    {
        $districts =[
        	
	    [
	      'name'=>'Panchagar',
	      'code'=>1
	    ],

	    [
	      'name'=>'Thakurgaon',
	      'code'=>2
	    ],
	    
	     [
	      'name'=>'Dinajpur',
	      'code'=>3
	    ],

	     [
	      'name'=>'Nilphamari',
	      'code'=>4
	    ],

		[
	      'name'=>'Lalmonirhat',
	      'code'=>5
	    ],


	     [
	      'name'=>'Rangpur',
	      'code'=>6
	    ],


	     [
	      'name'=>'Kurigram',
	      'code'=>7
	    ],

	     [
	      'name'=>'Gaibandha',
	      'code'=>8
	    ],

	     [
	      'name'=>'Joypurhat',
	      'code'=>9
	    ],

	     [
	      'name'=>'Bogura',
	      'code'=>10
	    ],

	     [
	      'name'=>'Naogaon',
	      'code'=>11
	    ],

	     [
	      'name'=>'Natore',
	      'code'=>12
	    ],

	     [
	      'name'=>'Nawabganj',
	      'code'=>13
	    ],

	     [
	      'name'=>'Rajshahi',
	      'code'=>14
	    ],

	     [
	      'name'=>'Sirajganj',
	      'code'=>15
	    ],

	     [
	      'name'=>'Pabna',
	      'code'=>16
	    ],

	     [
	      'name'=>'Kushtia',
	      'code'=>17
	    ],

	     [
	      'name'=>'Meherpur',
	      'code'=>18
	    ],

	     [
	      'name'=>'Chuadanga',
	      'code'=>19
	    ],

	     [
	      'name'=>'Jhenaidah',
	      'code'=>20
	    ],

	     [
	      'name'=>'Magura',
	      'code'=>21
	    ],

	     [
	      'name'=>'Narail',
	      'code'=>22
	    ],

	     [
	      'name'=>'Jashore',
	      'code'=>23
	    ],

	     [
	      'name'=>'Satkhira',
	      'code'=>24
	    ],

	     [
	      'name'=>'Khulna',
	      'code'=>25
	    ],

	     [
	      'name'=>'Bagerhat',
	      'code'=>26
	    ],

	     [
	      'name'=>'Pirojpur',
	      'code'=>27
	    ],

	     [
	      'name'=>'Jhalakati',
	      'code'=>28
	    ],

	     [
	      'name'=>'Barishal',
	      'code'=>29
	    ],

	     [
	      'name'=>'Bhola',
	      'code'=>30
	    ],

	     [
	      'name'=>'Patuakhali',
	      'code'=>31
	    ],

	     [
	      'name'=>'Barguna',
	      'code'=>32
	    ],
		

		[
	      'name'=>'Netrokona',
	      'code'=>33
	    ],


	    [
	      'name'=>'Mymensingh',
	      'code'=>34
	    ],


	    [
	      'name'=>'Sherpur',
	      'code'=>35
	    ],

	    [
	      'name'=>'Jamalpur',
	      'code'=>36
	    ],

	    [
	      'name'=>'Tangail',
	      'code'=>37
	    ],


	    [
	      'name'=>'Kishoreganj',
	      'code'=>38
	    ],

	    [
	      'name'=>'Manikganj',
	      'code'=>39
	    ],

	    [
	      'name'=>'Dhaka',
	      'code'=>40
	    ],

	    [
	      'name'=>'Gazipur',
	      'code'=>41
	    ],

	    [
	      'name'=>'Gazipur',
	      'code'=>41
	    ],


	    [
	      'name'=>'Narsinghdi',
	      'code'=>42
	    ],


	    [
	      'name'=>'Narayanganj',
	      'code'=>43
	    ],


	    [
	      'name'=>'Munshiganj',
	      'code'=>44
	    ],

	    [
	      'name'=>'Faridpur',
	      'code'=>45
	    ],

		
		[
	      'name'=>'Rajbari',
	      'code'=>46
	    ],

	    [
	      'name'=>'Gopalgan',
	      'code'=>47
	    ],

	    [
	      'name'=>'Madaripur',
	      'code'=>48
	    ],

	    [
	      'name'=>'Shariatpur',
	      'code'=>49
	    ],


	    [
	      'name'=>'Sunamganj',
	      'code'=>50
	    ],

	    [
	      'name'=>'Sylhet',
	      'code'=>51
	    ],

	    [
	      'name'=>'Moulvibazar',
	      'code'=>52
	    ],

	    [
	      'name'=>'Habiganj',
	      'code'=>53
	    ],

	    [
	      'name'=>'Cumilla',
	      'code'=>55
	    ],

	    [
	      'name'=>'Chandpur',
	      'code'=>56
	    ],

	    [
	      'name'=>'Lakshmipur',
	      'code'=>57
	    ],


	    [
	      'name'=>'Noakhali',
	      'code'=>58
	    ],


	    [
	      'name'=>'Feni',
	      'code'=>59
	    ],

	    [
	      'name'=>'Chattogram',
	      'code'=>60
	    ],

	    [
	      'name'=>'Cox’s Bazar',
	      'code'=>61
	    ],

	    [
	      'name'=>'Khagrachhari',
	      'code'=>62
	    ],

	    [
	      'name'=>'Rangamati',
	      'code'=>63
	    ],

	    [
	      'name'=>'Bandarban',
	      'code'=>64
	    ],

        ];

       District::insert($districts);
	}
}
