<?php
namespace Tests\Unit;
use App\Components\DbQuery;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
class QueryTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testSelectAllColumns()
    {
        $this->assertEquals('select * from users', (new DbQuery)->select('users'));
    }
    
    public function testSpecificColumns()
    {
        $this->assertEquals('select id, name from users', (new DbQuery)->select('users',['column'=>['id', 'name']]));
    }
   public function testOrderByColumns()
    {
        $this->assertEquals('select id, name from users order by id desc', (new DbQuery)->select('users',
        	['column'=>['id', 'name'],
        	'orderby'=>['id', 'desc']]));
    }
    public function testAllColoumsOrderByMulitpleColumns()
    {
    	$this->assertEquals('SELECT id, name FROM users ORDER BY id DESC', (new DbQuery)->select('users',
        	['column'=>['id', 'name'],
        	'orderbycap'=>['id', 'DESC']]));
	}
	public function testLimit()
    {
    	$this->assertEquals('select * from products limit 10', (new DbQuery)->select('products',
        	['limit'=>10]));
	}
    public function testLimitAndOffset()
    {
        $this->assertEquals('select * from products limit 6 offset 5', (new DbQuery)->select('products',
            ['limitandoffset'=>[6, 5]]));
    }
    public function testCount()
    {
        $this->assertEquals('select *, count("id") from products', (new DbQuery)->select('products',
            ['count'=>'id']));
    }
}