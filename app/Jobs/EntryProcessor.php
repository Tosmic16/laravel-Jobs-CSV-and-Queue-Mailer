<?php

namespace App\Jobs;

use Exception;
use App\Models\Entry;
use App\Mail\ComputanEmail;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class EntryProcessor implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $chunk;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($chunk)
    {
           $this->chunk = $chunk;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
      foreach($this->chunk as $record){
        try{  
            Entry::create($record);
            }
              catch(Exception $e){
                ///$err =  json_encode($e->getMessage());
    
               $email = new ComputanEmail("Error Message: ". $e->getMessage() . "     File: ". $e->getFile()."      Line: ". $e->getLine(), 'An Exception Message', 'exception@computan.com');
             Mail::to('tech@computan.com')->send($email);
            
            
            }
           }
      }
    
}
