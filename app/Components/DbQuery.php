<?php
namespace App\Components;
class DbQuery {    
    public function select($table, array $data = []) {
    	$fields  =  "*";
      if (!empty($data['column'])) {
        $fields = implode(', ', $data['column']);
      }
      if (!empty($data['orderby'])) {   			
      $orderby = implode(' ', $data['orderby']);       		
      return "select $fields from $table order by $orderby";	
      }
    	if (!empty($data['orderbycap'])) {   			
      	$orderby = implode(' ', $data['orderbycap']);       		
      	return "SELECT $fields FROM $table ORDER BY $orderby";	
    	}
	   	if (!empty($data['limit'])) {
	   		return "select $fields from $table limit ".$data['limit'];
	   	}
      if (!empty($data['limitandoffset'])) {
          return "select $fields from $table limit ".$data['limitandoffset'][0]." offset ".$data['limitandoffset'][1];
      }
      if (!empty($data['count'])) {
          return "select $fields, count(".'"'.$data['count'].'"'.") from $table";
      }
      return "select $fields from $table";
    }
}