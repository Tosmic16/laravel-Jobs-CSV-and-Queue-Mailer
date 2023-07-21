<?php

namespace Tests\Unit;

use Tests\TestCase;
class TaskTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
       $response = $this->get('/allroute');
       $response->assertStatus(200);
       $response = $this->get('/read-dfa');
       $response->assertStatus(200);
       $response = $this->get('/home');
       $response->assertStatus(302);
       $response = $this->get('/mailer');
       $response->assertStatus(200);

       $response = $this->post('/mailer',['subject'=>'tosin',
       'body'=>"vinny"]);
   
           $response->assertStatus(302);
    }
}
