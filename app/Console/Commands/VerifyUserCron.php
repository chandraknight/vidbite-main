<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\VerifyUser;
use Illuminate\Console\Command;

class VerifyUserCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'verifyuser:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = User::withCount(['subscribers','verifyUser'])->having('subscribers_count', '>=', 100000)->having('verify_user_count', '>=', 1)->get();

        foreach ($users as $key => $user) {
            if($user->profile != null){ 
                if($user->profile->cover_image != null && 
                    $user->profile->profile_image != null &&
                    $user->profile->about != null &&
                    $user->videos->count() > 10)
                    {
    
                        $verify = new VerifyUser();
                        $verify->user_id = $user->id;
                        $verify->token = uniqid();
                        $verify->save();
    
    
                    }
            }
    
        }
    
        return $users;
    }
}
