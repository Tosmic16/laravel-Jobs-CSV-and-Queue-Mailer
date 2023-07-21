<?php

namespace App\Jobs;

use Exception;
use App\Models\CSV;
use App\Mail\ComputanEmail;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class CsvProcessor implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $data;
    public $key;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($chunk, $header)
    {
        $this->data = $chunk;
        $this->key = $header;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //for each element of the associative array, create a record
        foreach($this->data as $datum){
        try{
           
                CSV::create(array_combine($this->key,$datum));
            }
        catch(Exception $e){
            
            //get the error message, the file and line as the eamil body
            //computanEmail mailable takes three augument the body, the subject and sender
           $email = new ComputanEmail("Error Message: ". $e->getMessage() . "     File: ". $e->getFile()."      Line: ". $e->getLine(), 'An Exception Message', 'exception@computan.com');
         Mail::to('tech@computan.com')->send($email);
        }
        
        }
        
    }
}
