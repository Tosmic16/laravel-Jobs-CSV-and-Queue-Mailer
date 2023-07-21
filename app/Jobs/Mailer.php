<?php

namespace App\Jobs;

use Exception;
use App\Mail\ComputanEmail;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class Mailer implements ShouldQueue
{
    use Batchable,Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    public $maxExceptions = 3;
    public $data;
    public $message;
    public $subject;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data, $message, $subject)
    {
        $this->data = $data;
        $this->message = $message;
        $this->subject = $subject;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach($this->data as $datum){
            try{
            $email = new ComputanEmail($this->message, $this->subject, 'task-tosin@computan.com');
            Mail::to($datum['email'])->send($email);
            } catch(Exception $e){
    
               $email = new ComputanEmail("Error Message: ". $e->getMessage() . "     File: ". $e->getFile()."      Line: ". $e->getLine(), 'An Exception Message', 'exception@computan.com');
             Mail::to('tech@computan.com')->send($email);
            
            
            }
        }
    }
}
