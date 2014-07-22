<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;
use Carbon\Carbon;

class JobTableSeeder extends Seeder {

	public function run(){
        DB::connection()->disableQueryLog();
        $this->createJobs(34000000,43000000,-112000000,-98000000);
        $this->createJobs(36000000,45000000,-81000000,-67000000);


	}

    private function createJobs($latLow, $latHigh, $lngLow, $lngHigh){
        $faker = Faker::create();
        $jobTitlesAndDescriptions = [
            ['title' =>'Administrative Assistant','description'=>'Admin assistant to support operations'],
            ['title' =>'Data Entry','description'=>'Data Entry for customer transactions'],
            ['title' =>'Receptionist','description'=>'Greet customers.  Answer phones'],
            ['title' =>'Beauty Stylist','description'=>'Certified Stylist for hair and nails'],
            ['title' =>'IT support','description'=>'Computer and network management'],
            ['title' =>'Call center support','description'=>'Support customer escallations'],
            ['title' =>'Trainer','description'=>'Deliver Training'],
            ['title' =>'Waiter/Waitress','description'=>'Food delivery for local resaurant '],
            ['title' =>'Waiter/Waitress','description'=>'Bar service'],
            ['title' =>'Lawn Care','description'=>'provide lawn care services'],
            ['title' =>'Construction','description'=>'General construction'],
            ['title' =>'Machinist','description'=>'General machine work and welding'],
            ['title' =>'Tour Guide','description'=>'Tour service at state park'],
            ['title' =>'Maintenance','description'=>'General maintenace support'],
            ['title' =>'Equipment operator','description'=>'Fork lift and truck operator'],
            ['title' =>'Warehouse management','description'=>'Basic warehouse management'],
            ['title' =>'Assembly','description'=>'Productionline assembly'],
            ['title' =>'Season worker','description'=>'summer job '],
            ['title' =>'Customer Servcie','description'=>'Support customer escallations'],
            ['title' =>'Sales','description'=>'works on sales floor'],
            ['title' =>'Security Monitor','description'=>'Monitor building security'],
            ['title' =>'HVAC Tech','description'=>'Repair HVAC systems'],
            ['title' =>'IT support','description'=>'Fix computer issues'],
            ['title' =>'Automotive Repair','description'=>'Work in auto repair shop'],
            ['title' =>'Carpentry','description'=>'General carpentry'],
            ['title' =>'Electrical','description'=>'Install electrical fixtures'],
            ['title' =>'Computer Tech','description'=>'Repair computers'],
            ['title' =>'Driver','description'=>'Warehouse delivery driver']
        ];

        $maxUsers = User::max('id');
        $maxSkillId = Skill::max('id');
        $skillIds = range(1, $maxSkillId);
        $allDays = range(1,7);

        foreach(range(1,100)as $index){
            $email = ($faker->boolean(80)) ? $faker->email : "";
            $randomData[] = ['contact_phone' => $faker->phoneNumber,'contact_email' => $email,'address1' => $faker->streetAddress,'city' => $faker->city,'state' => $faker->stateAbbr];
        }

        $sql = "INSERT INTO `jobs`(`title`,`description`,`posted_by`,`max_payrate`,`contact_phone`,`contact_email`,`address1`,`city`,`state`,`duration_start`,`duration_end`,`expired`,`expired_at`,`locked`,`lat`,`lng`) VALUES (:title,:description,:posted_by,:max_payrate,:contact_phone,:contact_email,:address1,:city,:state,:duration_start,:duration_end,:expired,:expired_at,:locked,:lat,:lng)";
        $getJobQuery = "SELECT * FROM `jobs` WHERE ID = :id";
        $insertSkillsQuery = "INSERT INTO `job_skill`(`job_id`,`skill_id`) VALUES (:job_id,:skill_id)";
        $insertDaysQuery = "INSERT INTO `day_job`(`day_id`,`job_id`) VALUES (:day_id,:job_id)";
        $insertLocationQuery = "INSERT INTO `locations`(`job_id`,`lat`,`lng`) VALUES(:job_id,:lat,:lng)";
        $jobIds = Job::lists('id');
        $pdo = DB::getPdo();
        $prepared = $pdo->prepare($sql);
        $getJob = $pdo->prepare($getJobQuery);
        $insertSkill = $pdo->prepare($insertSkillsQuery);
        $insertDay = $pdo->prepare($insertDaysQuery);
        $insertLocation = $pdo->prepare($insertLocationQuery);
        $maxJobs = $_ENV['SEEDER_MAXJOBS'];

        foreach(range(1, $maxJobs) as $index) {
            $active = (mt_rand(0, 1) == 1) ? 1 : 0;
            $randDate = Carbon::createFromFormat("Y-m-d H:i:s", $faker->dateTimeBetween('-1 years')->format("Y-m-d H:i:s"));
            $expired = 0;
            $expired_at = null;
            if (Carbon::now()->diffInDays($randDate) > 22) {
                $expired = 1;
                $expired_at = $randDate->toDateTimeString();
            }
            $titleDescription = mt_rand(0, 27);
            $lat = number_format(mt_rand($latLow, $latHigh) / 1000000);
            $lng = number_format(mt_rand($lngLow, $lngHigh) / 1000000);
            $prepared->execute([':title' => $jobTitlesAndDescriptions[$titleDescription]['title'], ':description' => $jobTitlesAndDescriptions[$titleDescription]['description'], ':posted_by' => mt_rand(1, $maxUsers), ':max_payrate' => mt_rand(1, 200), ':contact_phone' => $randomData[mt_rand(0, 99)]['contact_phone'], ':contact_email' => $randomData[mt_rand(0, 99)]['contact_email'], ':address1' => $randomData[mt_rand(0, 99)]['address1'], ':city' => $randomData[mt_rand(0, 99)]['city'], ':state' => $randomData[mt_rand(0, 99)]['state'], ':duration_start' => mt_rand(0, 12), ':duration_end' => mt_rand(13, 23), ':expired' => $expired, ':expired_at' => $expired_at, ':locked' => $active, ':lat' => $lat, ':lng' => $lng]);
            shuffle($skillIds);
            $skills = array_slice($skillIds,0,mt_rand(0,5));
            foreach($skills as $skill){
                $insertSkill->execute([':job_id' => $index,':skill_id' => $skill]);
            }
            shuffle($allDays);
            $days = array_slice($allDays,0,mt_rand(1,7));
            foreach($days as $day){
                $insertDay->execute([':day_id' => $day,':job_id' => $index]);
            }
            $insertLocation->execute([':job_id'=>$index,':lat'=>$lat,':lng'=>$lng]);
            print 'Job: '.$index.PHP_EOL;
        }
    }
}