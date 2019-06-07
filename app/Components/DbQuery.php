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
      if (!empty($data['aggregatemax'])) {
          return "select max('".$fields."') from $table";
      }
      if (!empty($data['aggregate'])) {
          return "select ".$data['aggregate'][0]."('".$fields."') from $table ".$data['aggregate'][1]." ".$fields;
      }
      if (!empty($data['uniqueby'])) {
          return "select ".$data['uniqueby'][0]." '".$fields."' from $table";
      }
      if (!empty($table['joinTables'])) {
          return "select * from ".$table['joinTables'][0]." as p join ".$table['joinTables'][1]." as c on p.".$data['column'][0]."=c.".$data['column'][1];
      } 
      return "select $fields from $table";
    }
    public function insert($table, array $column = [], array $value = []) {
        $columns = '';
        $values = '';

        if (!empty($column)) {
            foreach ($column as $key => $col) {
                $columns .= ($key!= 0)?', ':'';
                $columns .= '"'.$col.'"';
            }
        }
        foreach ($value as $rkey => $row) {
            $values .= ($rkey!= 0)?', ':'';
            $values .= '(';
                foreach ($row as $key => $val) {
                    $values .= ($key!= 0)?', ':'';
                    $values .= is_numeric($val)?$val:'"'.$val.'"';
                }
            $values .= ')';
        }
      
        return 'INSERT INTO '.$table.'('.$columns.') VALUES'.$values;
    }
    public function update($table, array $data = []) {

        $set = '';
        $where = '';

        if (!empty($data['set'])) {
            foreach ($data['set'] as $key => $val) {
                $set .= $key." = ";
                $set .= is_numeric($val)?$val:'"'.$val.'"';
            }
        }
        if (!empty($data['where'])) {
          $where .=' WHERE ';
            foreach ($data['where'] as $key => $val) {
                $where .= $key." = ";
                $where .= is_numeric($val)?$val:'"'.$val.'"';
            }
        }
        return 'UPDATE '.$table.' SET '.$set.$where;
    }
    public function delete($table, array $data = []) {
        $where = '';

        if (!empty($data['where'])) {
          $where .=' WHERE ';
            foreach ($data['where'] as $key => $val) {
                $where .= $key.$data['condition'][0];
                $where .= is_numeric($val)?$val:'"'.$val.'"';
            }
        }
        return 'DELETE FROM '.$table.''.$where;
    }
}