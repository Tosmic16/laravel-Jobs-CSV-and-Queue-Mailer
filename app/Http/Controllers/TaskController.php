<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\CSV;
use App\Jobs\Mailer;
use App\Models\User;
use App\Models\Entry;
use Illuminate\Bus\Batch;
use App\Jobs\CsvProcessor;
use App\Mail\ComputanEmail;
use App\Jobs\EntryProcessor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{

  //Route to read data from https://api.publicapis.org/entries  API
    public function read_dfa(){
    
      //send a get request to https://api.publicapis.org/entries
        $response = Http::acceptJson()->get('https://api.publicapis.org/entries');
       
        //If failed send a mail and redirect to 404
        if($response->failed()){
          $email = new ComputanEmail('Unable to fetch data from https://api.publicapis.org/entries', 'An Exception Message', 'exception@computan.com');
          Mail::to('tech@computan.com')->send($email);           
           abort(404);
        }
        else
        {
          //get the body of the response
            $data = $response->getBody()->getContents();
           $data =  json_decode($data,true);
          $data = $data['entries'];
      
        //chunk the array into sizes of 300(s)
          $chunks = array_chunk($data,300);
          
          //dispatch an empty batch
          $batch = Bus::batch([])->dispatch();

          //create a job and add it to the batch for every chunk of 300
         foreach($chunks as $chunk){
          
                $batch->add(new EntryProcessor($chunk));
         }
         //redirect to batch info page with batch id
           return redirect('/batchinfo?id='.$batch->id);
        }
        
       }


       //return Batch Info Page
       public function batchinfo(Request $request){
        echo "<a href='/all'>Go home</a><br>";
        $data = $request->id;

            return Bus::findBatch($data);
       }

       //Csv upload processor
       public function csvupload(){

        //validate if the file uploaded is csv
        $formfields  = Validator::make(request()->all(), [
          'csv' => 'mimes:csv,txt',
        ]);
        
        
                 if($formfields->fails()){
                  //return this if validation fails
          return "Invalid File Format, File extension should be csv <a href='/home'>try agin</>";
         }
  
        if(request()->has('csv')){

          //convert the csv file into an array
          $csv = array_map("str_getcsv",file(request()->csv));
          
          // get the header which will serve as the key, change the value of the first element to record  id 
          //and remove it from the array
          $header = $csv[0];
          $header[0]= 'record_id';
        
          unset($csv[0]);
            
          //dispatch batch

          $chunks = array_chunk($csv,300);
          
          $batch = Bus::batch([])->dispatch();
         foreach($chunks as $chunk){
          
                $batch->add(new CsvProcessor($chunk,$header));
         }

         return redirect('/batchinfo?id='.$batch->id);
        }
        return "You didn't select a file <a href='/home'>try agin</>";

       }
       
       public function mailer(){
        // check if body and subject fields have value
        if(!(request()->has('body') && request()->has('subject'))){
            return "Both fields are required <a  href='/mailer'>try again</>";
        }
     
        $body = request()->body;
     $subject = request()->subject;
        
     //send mail to all user with value 1 as is_active
        $users =  User::where('is_active',1)->get(['email'])->toArray();
       
        $chunks = array_chunk($users,300);
          
        $batch = Bus::batch([])->dispatch();
       foreach($chunks as $chunk){
      //   foreach($chunk as $datum){
       
      //     $email = new ComputanEmail;
      //    Mail::to($datum['email'])->send($email);
      // }
              $batch->add(new Mailer($chunk,$body, $subject));
       }
         return redirect('/batchinfo?id='.$batch->id);
       }

    //returm mailer page
       public function showMailer(){
          return view('email.show');
       }
}
