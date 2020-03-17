<?php

namespace App\Console\Commands;

use App\User;
use App\UserFeeds;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class populateUserFeed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:feed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add feed data to the database';

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
        try {
            $files = File::exists(public_path('tweets.txt'));
            if (!$files) {
                $this->error('File Not Found');
            }

            //check encoding...
            $check = mb_detect_encoding(public_path('tweets.txt'), 'ASCII', true);
            $isError = false;
            if ($check === "ASCII") {
                //ignore all the empty lines
                $content = array_filter(array_map("trim", file(public_path('tweets.txt'), FILE_SKIP_EMPTY_LINES)), "strlen");
                if (count($content) > 0) {
                    $arrData = [];
                    $data = [];
                    //processing the file into readable array
                    foreach ($content as $key => $line) {
                        $currentArray             = explode(' ', $line);
                        $data['created_at']       = implode(' ', array_slice($currentArray, 0, 2));
                        $data['user_name']        = implode('', str_replace('>', '', array_slice($currentArray, 2, 1)));
                        $data['tweet']            = implode(' ', array_slice($currentArray, 3));

                        array_push($arrData, $data);
                    }

                    if (count($arrData) > 0) {

                        foreach ($arrData as $arrUserFeed) {
                            //get user id
                            try{
                                $objUser = User::where('user_name', $arrUserFeed['user_name'])->first();
                                if($objUser){
                                    unset($arrUserFeed['user_name']);

                                    //check for duplicate messages by user, if found skip that row
                                    $found = UserFeeds::where('tweet',$arrUserFeed['tweet'])->where('user_id', $objUser->id)->count();
                                    if($found == 0){
                                        $arrUserFeed['user_id'] = $objUser->id;
                                        UserFeeds::create($arrUserFeed);
                                    }
                                }
                                else{
                                    $isError = true;
                                }

                            }
                            catch (\Exception $ex){
                                $this->error($ex->getMessage());
                            }

                        }
                        if($isError){
                            $this->error("No users found");
                        }
                        else{
                            $this->alert('Feed created successfully');
                        }
                    }
                }
                else {
                    $this->info('File is empty...');
                }
            }
            else {
                $this->error('Incorrect character set in the file');
            }

        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
