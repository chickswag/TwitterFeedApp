<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class createUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add users data to the database';

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
     * @return mixed
     */
    public function handle()
    {

        try{
            $files = File::exists(public_path('users.txt'));
            if(!$files){
               $this->line('File Not Found');
            }
            //ignore all the empty lines
            $content = file(public_path('users.txt'), FILE_IGNORE_NEW_LINES);

            $arrData = [];
            foreach ( $content as $key=>$line){

                $currentArray = explode(' ', preg_replace('/\s*,\s*/', ' ', $line));
                array_push($arrData,$currentArray);
            }

            $dataCount = count($arrData);
            $users =  [];
            if($dataCount > 0){
                foreach ($arrData  as $userindex => $objUser){


                    foreach ($objUser as $u => $user_name){
                        array_push($users,$user_name);
                    }

                }
                //insert to DB
                $arrUsers  = array_unique($users);

                $unserInsert = [];

                // remove follows as it in sot related to user rather, a relationship
                $key = array_search('follows', $arrUsers);
                if (false !== $key) {
                    unset($arrUsers[$key]);
                }

                foreach ($arrUsers as $strName){
                    $unserInsert['user_name'] = $strName;
                    User::firstOrCreate($unserInsert);
                }
                $this->line('User Added Successfully');
            }

        }
        catch(\Exception $e){
            return $e->getMessage();

        }
    }
}
