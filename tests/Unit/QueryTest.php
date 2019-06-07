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
    public function testMaxCost()
    {
        $this->assertEquals("select max('cost') from products", (new DbQuery)->select('products', ['column'=>['cost'],
            'aggregatemax'=>['max']]));
    }
    public function testMaxWithGroupBy()
    {
        $this->assertEquals("select max('cost') from products group by cost", (new DbQuery)->select('products', ['column'=>['cost'],
            'aggregate'=>['max','group by']]));
    }
    public function testUniqueByDistinct()
    {
        $this->assertEquals("select DISTINCT 'name' from products", (new DbQuery)->select('products', ['column'=>['name'],
            'uniqueby'=>['DISTINCT']]));
    }
    public function testTableJoin()
    {
        $this->assertEquals("select * from products as p join categories as c on p.category_id=c.id", (new DbQuery)->select(['joinTables'=>['products','categories']], ['column'=>['category_id','id']]));
    }
    public function testInsertData()
    {
        $this->assertEquals('INSERT INTO products("id", "name", "cost", "color") VALUES(1, "apple", 100, "red")', (new DbQuery)->insert('products', ["id","name","cost","color"], [[1, "apple", 100, "red"]]));
    }
    public function testInsertMultipleData()
    {
        $this->assertEquals('INSERT INTO products("id", "name", "cost", "color") VALUES(1, "apple", 100, "red"), (2, "orange", 50, "orange")', (new DbQuery)->insert('products', ["id","name","cost","color"], [[1, "apple", 100, "red"], [2, "orange", 50, "orange"]]));
    }
    public function testUpdateData()
    {
        $this->assertEquals('UPDATE products SET cost = 200 WHERE name = "apple"', (new DbQuery)->update('products', ["set"=>['cost'=>200] ,"where" => ['name'=>"apple"]]));
    }
    public function testUpdateColor()
    {
        $this->assertEquals('UPDATE products SET color = "black" WHERE color = "red"', (new DbQuery)->update('products', ["set"=>['color'=>'black'] ,"where" => ['color'=>"red"]]));
    }
    public function testUpdateCost()
    {
        $this->assertEquals('UPDATE products SET cost = DEFAULT WHERE cost = 100', (new DbQuery)->update('products', ["set"=>['cost'=>T_DEFAULT] ,"where" => ['cost'=>100]]));
    }
    public function testUpdateAllColor()
    {
        $this->assertEquals('UPDATE products SET color = "pink"', (new DbQuery)->update('products', ["set"=>['color'=>"pink"]]));
    }
    public function testDeleteProduct()
    {
        $this->assertEquals('DELETE FROM products WHERE name = "abc"', (new DbQuery)->delete('products', ["where"=>['name'=>"abc"], "condition"=>[' = ']]));
    }
    public function testDeleteGreaterThanProduct()
    {
        $this->assertEquals('DELETE FROM products WHERE cost > 500', (new DbQuery)->delete('products', ["where"=>['cost'=>500], "condition"=>[' > ']]));
    }
    public function testDeleteAllProduct()
    {
        $this->assertEquals('DELETE FROM products', (new DbQuery)->delete('products'));
    }

}