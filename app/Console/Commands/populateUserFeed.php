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
            if ($check === "ASCII") {
                //ignore all the empty lines
                $content = array_filter(array_map("trim", file(public_path('tweets.txt'), FILE_SKIP_EMPTY_LINES)), "strlen");
                if (count($content) > 0) {
                    $arrData = [];
                    foreach ($content as $key => $line) {
                        $currentArray = explode(' ', $line);
                        array_push($arrData, $currentArray);
                    }

                    $dataCount = count($arrData);
                    $users = [];
                    if ($dataCount > 0) {
                        foreach ($arrData as $userindex => $objUser) {
                            foreach ($objUser as $user_name) {
                                array_push($users, $user_name);
                            }

                        }
                        //insert to DB
                        $arrUsers = array_unique($users);
                        $insertInsert = [];

                        // remove follows as it in sot related to user rather, a relationship
                        $key = array_search('follows', $arrUsers);
                        if (false !== $key) {
                            unset($arrUsers[$key]);
                        }
                        foreach ($arrUsers as $objUserName) {
                            $insertInsert['user_name'] = $objUserName;
                            User::firstOrCreate($insertInsert);
                        }
                        //update user ids

                        foreach ($arrData as $data) {
                            //get all the user names before the word follows
                            $current_output = array_slice($data, 0, 1);
                            $currentUser = User::where('user_name', $current_output[0])->first();

                            //start after the keyword follows to get users who follow the current user added/created
                            $output = array_slice($data, 2);
                            $arrUserFollowsIds = [];
                            foreach ($output as $objUserFollows) {
                                $userfollowIds = User::where('user_name', $objUserFollows)->first();
                                array_push($arrUserFollowsIds, $userfollowIds->id);
                            }

                            $insertFollowIds = implode('|', $arrUserFollowsIds);
                            $insert = User::find($currentUser->id);
                            $insert->user_ids = $insertFollowIds;
                            $insert->save();
                        }

                        $this->alert('Users created successfully');
                    }
                } else {
                    $this->info('File is empty...');
                }

            } else {
                $this->error('Incorrect character set in the file');
            }


        } catch (\Exception $e) {
            return $e->getMessage();

        }
    }
}
