<?php

namespace Tests\Feature;

use Tests\ParentTestClass;
use App\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class userFeatureTest extends ParentTestClass
{
    use WithFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUserVisit()
    {
        $response = $this->get('/');
        $response->assertSee("Hello Ucreate");
    }
    public function testRegisterationForm()
    {
        $response = $this->get('/register');
        $response->assertSee("Register");
        $response->assertStatus(200);
    }
    public function setData()
    {
        $user_data = [
            'name' => 'Jyoti',
            'email' => 'jyoti@ucreate.co.in',
            'password'=>'11111111',
            'confirm_password' => '11111111'
        ];
        return $user_data;
    }    
    public function testEmailValidation()
    {
        $user_data=$this->setData();
        $user_data['email']='jyoti';
        $data = $this->post('/signup', $user_data);
        $data->assertRedirect('/register');
        $data->assertSessionHasErrors('email');
    }
    public function testNameValidation()
    {
        $user_data=$this->setData();
        $user_data['name']='';
        $data = $this->post('/signup', $user_data);
        $data->assertRedirect('/register');
        $data->assertSessionHasErrors('name');
    }
    public function testPasswordValidation()
    {
        $user_data=$this->setData();
        $user_data['password']='111';
        $data = $this->post('/signup', $user_data);
        $data->assertRedirect('/register');
        $data->assertSessionHasErrors('password');
    }
    public function testUserSignUp()
    {
        $response = $this->post('/signup',$this->setData());
        $this->assertTrue(true);
    }
    public function testLoginForm()
    {
        $response = $this->get('/login');
        $response->assertSee("Login");
        $response->assertStatus(200);
    }
    public function testUserLogin()
    {   
        $user= factory(User::class)->create([
            'id' => random_int(1, 100),
            'password' => bcrypt($password = '11111111'),
        ]);        
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $password,
            'remember' => 'on',
        ]);
        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($user);
    }
}
