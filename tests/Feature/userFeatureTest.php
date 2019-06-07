<?php

namespace Tests\Feature;

use Tests\ParentTestClass;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class userFeatureTest extends ParentTestClass
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    public function testUserSignUp()
    {
        $data = [
            'name'=>'test',
            'email'=>'www@gmail.com',
            'password'=>'@@@@@@',
            'confirm_password'=>'@@@@@@'
        ];
        $response = $this->post('/signup',$data);
        $response->assertStatus(201);
        return $data;
    }
    /**
     * @depends testUserSignUp
     */
   /* public function testUserWithDuplicateEmail($user)
    {
        $response = $this->post('/signup',$user);
        $response->assertStatus(201);
       
    }*/
}
