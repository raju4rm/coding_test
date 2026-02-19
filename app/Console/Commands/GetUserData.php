<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\UserDetails;
use App\Models\UserLocation;
use Http;

class GetUserData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-user-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        for ($i = 0; $i < 5; $i++) {
            $response = Http::get('https://randomuser.me/api/');
            if ($response->successful()) {
                $data = $response->json()['results'][0];                
                
                /* unique user check start */
                $email = $data['email'];                
                if (User::where('email', $email)->exists()) {
                    continue;
                }
                /* unique user check end */
                
                /* insert user start */
                $insertUserData =[
                    'name' => $data['name']['title'] . ' ' .$data['name']['first'] . ' ' . $data['name']['last'],
                    'email' => $email,
                    'created_at'=> now(),
                ];
                $user_id = User::insertGetId($insertUserData);
                /* insert user end */

                /* insert user details start */
                $insertUserDetailsData =[
                    'user_id' => $user_id,
                    'gender' => $data['gender'],
                    'created_at'=> now(),
                ];
                UserDetails::insert($insertUserDetailsData);
                /* insert user details end */

                /* insert location start */
                $insertUserLocationData = [
                    'user_id' => $user_id,
                    'city' => $data['location']['city'],
                    'country' => $data['location']['country'],
                    'created_at' => now(),
                ];
                UserLocation::insert($insertUserLocationData);
                /* insert location end */
            }
        }
        Log::info('User data inserted successfully.');
    }
}
