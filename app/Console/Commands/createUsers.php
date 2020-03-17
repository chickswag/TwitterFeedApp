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
               $this->error('File Not Found');
            }

            //check encoding...
            $checkFileEncode    = mb_detect_encoding(public_path('users.txt'),'ASCII', true);
            if($checkFileEncode === "ASCII"){
                //ignore all the empty lines
                $content = array_filter(array_map("trim", file(public_path('users.txt'),FILE_SKIP_EMPTY_LINES)), "strlen");
                if(count($content) > 0)
                {
                    $arrData = [];
                    foreach ( $content as $key=>$line){
                        $currentArray = explode(' ', str_replace(', ', ' ', $line));
                        array_push($arrData,$currentArray);
                    }

                    $dataCount = count($arrData);
                    $users =  [];
                    if($dataCount > 0){
                        foreach ($arrData  as $userindex => $objUser){
                            foreach ($objUser as $user_name){
                                array_push($users,$user_name);
                            }

                        }
                        //insert to DB
                        $arrUsers       = array_unique($users);
                        $insertUsers    = [];

                        // remove follows as it in sot related to user rather, a relationship
                        $key            = array_search('follows', $arrUsers);
                        if (false !== $key) {
                            unset($arrUsers[$key]);
                        }
                        foreach ($arrUsers as $objUserName){
                            $insertUsers['user_name'] = $objUserName;
                            User::firstOrCreate($insertUsers);
                        }
                        //update user ids on the user table for users who follows the original user
                        foreach ($arrData as $data){
                            //get all the user names before the word follows
                            $originalUser       = implode('',array_slice($data, 0, 1));
                            $objUser            = User::where('user_name',$originalUser)->first();

                            //start after the keyword follows to get users who follow the current user added/created
                            $userFollows             = array_slice($data, 2);
                            $arrUserFollowsIds  = [];
                            foreach ($userFollows as $objUserFollows)
                            {
                                //get all users that the original user follows
                                $userfollowIds  = User::where('user_name',$objUserFollows)->first();
                                array_push($arrUserFollowsIds,$userfollowIds->id);
                            }

                            $insertFollowIds = implode('|',$arrUserFollowsIds);
                            $insert = User::find($objUser->id);
                            $insert->user_ids = $insertFollowIds;
                            $insert->save();
                        }

                        $this->alert('Users created successfully');
                    }
                }
                else{
                    $this->info('File is empty...');
                }

            }else{
                $this->error('Incorrect character set in the file');
            }

        }
        catch(\Exception $e){
            $this->error($e->getMessage());
        }
    }
}
