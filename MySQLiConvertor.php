<?php
/**
 *
 * @author Daeus Tang 
 * @version Alpha
 *
 */

class SqliConvertor{

    private $db;
    private $query;

	public function __construct($host, $username, $password, $db_name){

		$this->db = new mysqli($host, $username, $password, $db_name);
		if ($this->db->connect_errno) {
			throw Exception("Failed to connect: {$this->db->connect_error}");
		}   
	}   

    public function real_escape_string($q)
    {
        return $this->db->real_escape_string($q);
    }

    public function escape_string($q)
    {
        return $this->db->real_escape_string($q);
    }

	public function escape($q, $quote = false)
	{
        if($quote)
        {
            return "'" . $this->db->real_escape_string($q) . "'";
        }
        else
        {
            return $this->db->real_escape_string($q);
        }
    }

    public function query($sql)
    {
        $this->query = $this->db->query($sql);
        return $this->query;
    }

    public function error()
    {
        return $this->db->error;
    }

    public function numrows(&$query = NULL)
    {
        return $this->num_rows($query);
    }

    public function num_rows(&$query = NULL)
    {
        if($query !== NULL)
        {
            $this->query = $query;
        }
        return $this->query->num_rows;
    }

    public function fetch_array(&$query = NULL)
    {
        if($query !== NULL)
        {
            $this->query = $query;
        }
        return $this->query->fetch_array(); 
    }

    public function fetch_object(&$query, $className = 'stdClass', $params = NULL)
    {
        $this->query = $query;
        if($params === NULL)
        {
            return $query->fetch_object($className);
        } 
        else 
        {
            return $query->fetch_object($className, $params);
        }
    }

    public function result(&$query, $row, $field = 0)
    {
        $this->query = $query;

        //seek to row
        $query->data_seek($row);

        //seek field
        if(is_integer($field))
        {
            $row = $query->fetch_row();
            $row->field_seek($field);
            return $result->fetch_field();
        } 
        else
        {
            $row = $query->fetch_assoc();
            return $row[$field];
        }

    }

    public function insert_id(){
        return $this->db->insert_id;    
    }

    /**
     * Self-defined function
     */
    public function result_array($sql, $params = NULL, $field_name = NULL)
    {
        $sql = $this->build_sql($sql, $params);
        $query = $this->db->query($sql);
        if( !$query )
        {
            //throw new Exception("result_array error. Please check your SQL: " . $sql);
        }
        $result = ''; 
        if($field_name === NULL){
            while($row = $query->fetch_assoc())
            {
                $result[] = $row;
            }
        }else{
            while($row = $query->fetch_assoc())
            {
                $result[] = $row[$field_name];
            }
        
        }
        return $result;
    }   

    public function run_query($sql, $params = NULL)
    {
        $sql = $this->build_sql($sql, $params);
        $query = $this->query($sql);
        if( !$query )
        {
            //throw new Exception("run_query error. Please check your SQL: " . $sql);
        }
        return $query;
    }

    public function insert($sql, $params = NULL)
    {
        $sql = $this->build_sql($sql, $params);
        $this->query = $this->db->query($sql);
        if( !$this->query )
        {
            //throw new Exception("insert error. Please check your SQL: " . $sql);
        }
        return $this->db->insert_id;
    }   

    public function row_array($sql, $params = NULL, $field_name = NULL)
    {
        $sql = $this->build_sql($sql, $params);
        $this->query = $this->db->query($sql);
        if( !$this->query )
        {
            //throw new Exception("result_row error. Please check your SQL: " . $sql);
        }
        $row = $this->query->fetch_assoc();
        if( !$field_name == NULL)
        {
            return $row[$field_name];
        }
        else
        {
            return $row;
        }
    }   

    public function build_sql($sql, $params = NULL)
    {
        if( !$params == NULL )
        {
            $sql = str_replace('?', '%s', $sql);
            if( is_array($params) )
            {
                foreach($params as &$p)
                {
                    $p = "'" . $this->db->real_escape_string($p) . "'";
                }
				return vsprintf($sql, $params);

            } else {
                $params = "'" . $this->db->real_escape_string($params) . "'";
				return sprintf($sql, $params);
            }
        }
        return $sql;
    }

}

?>
