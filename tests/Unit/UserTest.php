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
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testValidateFirst()
    {
        $data= array("name"=>"mdmmmm",
        "email"=>"gg@mmdmm.com",
        "password"=>"@@@@@@"
        );
        $this->assertArrayHasKey('email', $data); 
        $this->assertArrayHasKey('name', $data);
		$this->assertArrayHasKey('password', $data);       
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
    public function testCreateProduct($user_id)
    {   
        $pdata= array("user_id"=>$user_id,
        "name"=>"Productname",
        "description"=>"example",       
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
    public function testC($a,$c)
    {
       $this->assertEquals($c, $a+$a);

    }
    /**
     * @dataProvider UrlProvider
     */
    public function testUrl($url)
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
    public function UrlProvider()
    {
        return array(
          array('//invalid-url.com'),
          array('s//example.com')
        );
    }
}