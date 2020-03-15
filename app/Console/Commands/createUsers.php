<?php

namespace App\Console\Commands;

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
                return false;
            }
            $header = null;
            $data = array();
            $content = File::get(public_path('users.txt'));

            foreach (explode("\n", $content) as $key=>$line){
                $array[$key] = explode(',', $line);
            }
            dd($content);
            if (($handle = fopen($CSVFile,'r')) !== false){
                while (($row = fgetcsv($handle, 1000, ',')) !==false){
                    if (!$header)
                        $header = $row;
                    else
                        $data[] = array_combine($header, $row);
                }
                fclose($handle);
            }

            $dataCount = count($data);
            for ($i = 0; $i < $dataCount; $i ++){
                User::firstOrCreate($data[$i]);
            }
            echo "Products data added successfully"."\n";


        }
        catch(\Exception $e){
            return $e->getMessage();

        }



    }
}
