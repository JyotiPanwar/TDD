<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\User;
use App\Model\Products;
use Validator;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use WithFaker;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $this->assertTrue(true);
    }
    public function testValidateFirst() //Q1,Q2
    {
        $data= array("name"=>$this->faker->name(),
        "email"=>$this->faker->email(),
        "password"=>$this->faker->numerify('secret##')
        );
        $this->assertArrayHasKey('email', $data);  
        $validator = User::validateUser($data);
        $this->assertTrue($validator);
        return $data;
    }
   
    /**
     * @depends testValidateFirst
     */
    public function testUserCreate($data)
    {        
        $user = factory(User::class)->create($data);
        $this->assertInstanceOf(User::class, $user);
        return $user->id;
    }
    /**
     * @depends testUserCreate
     */
    public function testCreateProduct($user_id) //Q3
    {   
        $pdata= array("user_id"=>$user_id,
        "name"=>$this->faker->name(),
        "description"=>$this->faker->paragraph(),       
        );     
        $validator = Products::validateProduct($pdata);
        $this->assertTrue($validator);
        $product = factory(Products::class)->create($pdata);
        $this->assertInstanceOf(Products::class, $product);
        return $product->id;
    }
    /**
     * @dataProvider ABProvider
     */
    public function testA($a, $b, $c)
    {
       $this->assertEquals($a, $b);
       return $a;
    }
    /**
     * @dataProvider ABProvider
     */
    public function testB($a, $b, $c)
    {
       $this->assertEquals($a, $b);
       return $c;
    }

    public function ABProvider() 
    {
        return array(
          array(0, 0, 0),
          array(1, 1, 2),
          array(2, 2, 4),
        );
    }
    /**
     * @depends testA
     * @depends testB
     */
    public function testC($a,$c) //Q5
    {
       $this->assertEquals($c, $a+$a);

    }
    /**
     * @dataProvider urlProvider
     */
    public function testUrl($url) //Q6
    {
        $url = [
            'url'=>$url
        ];
        $rule = [
            'url'=>'required|url'
        ];

        $validator = Validator::make($url, $rule);
        $this->assertEquals('The url format is invalid.', $validator->errors()->first());

    }
    public function urlProvider()
    {
        return array(
          array('//invalid-url.com'),
          array('s//example.com')
        );
    }
    public function dependCheck()
    {
        return 20;
    }    
     /**
     * @depends dependCheck
     * @dataProvider checkProvider
     */
    public function testProviderDepend($a, $b): void
    {
       $this->assertEquals($a, $b);
    }
    public function checkProvider() //Q9 depend and provider does't work together
    {
        return array(
          array(30),
          array(40),
          array(20),
        );
    }
    public function testTenth(): void  //Q10
    {
        $a = [1, 2, 3];
        
        $this->assertCount(3, $a);
    }
}