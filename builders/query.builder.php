<?php
namespace Builders;

require_once ("./helpers/database.helper.php");

use Helpers;

class QueryBuilder
{
  private $stmt = null;
  private $types = null;
  private $bindings = array();
  private $result_bindings = array();
  
  public $parse_html = false;

  public $parse_html_entity_list = array();

  public function __construct($query, $connection=null)
  { 
    if($connection == null)
      $connection = Helpers\DatabaseHelper::GetDefaultConnection();


    if($connection != null)
      $this->stmt = $connection->prepare($query);   
  }
   
  public function BindParam($type, &$value)
  {
    $this->types     .= $type;
	$this->bindings[] = &$value;
  }
  
  private function Bind()
	{

	 if (!empty($this->types) && count($this->bindings) > 0)
	   \call_user_func_array(array($this->stmt, 'bind_param'), \array_merge(array($this->types), $this->bindings));
	}
	
	public function LastId()
	{
		return $this->stmt->insert_id;
	}
  
  public function Execute()
  { 
      $this->Bind();
  
      if (!$this->stmt->execute())
			{
				\trigger_error("[QueryBuilder] Execute failed: ".$this->stmt->error);
				return false;
			}
      
      if (!$this->stmt->store_result())
			{
				\trigger_error("[QueryBuilder] store result failed: ".$this->statement->error);
				return false;
			}
      
      return true;
  }
  
  public function BindResult(&$field)
  {
    $this->result_bindings[] = $field;  
  }
  
  public function GetFetchedArray()
  {
    $results = null;
    $meta = $this->stmt->result_metadata();  
     
    while ( $field = $meta->fetch_field() ) {  
       $parameters[] = &$row[$field->name];  
    }  
    \call_user_func_array(array($this->stmt, 'bind_result'), $parameters);
    while ( $this->stmt->fetch() ) {  
       $x = array();  
       foreach( $row as $key => $val ) {  

					if(!is_string($val))
					{
						$x[$key] = $val;
					}
					else
					{					  
						$found = false; 
						if(count($this->parse_html_entity_list>0))
					  {
							foreach($this->parse_html_entity_list as $entity)
							{							
								if($entity == $key)
								{
									$found = true;
									break;								
								}							
							}
						}
					  
						if($this->parse_html || $found)
						{
					  	$x[$key] = \html_entity_decode($val, ENT_QUOTES | ENT_IGNORE, "UTF-8");
						}
					  else
					  {
					  	$x[$key] = \htmlentities($val, ENT_QUOTES, "UTF-8", true);
						}
					} 									  
       }  
       $results[] = $x;  
    }  
    return $results; 
  }
  
  public function Select()
	{
		\call_user_func_array(array($this->stmt, 'bind_result'), $this->Fields());
		return $this->stmt->fetch();
	}
  
  public function Close()
  {
    @$this->stmt->close();
  }  
}

 
 /*
 require_once "builders/query.builder.php";
 $query_builder = new QueryBuilder("SELECT * FROM type");
 $query_builder->Execute();
 var_dump($query_builder->GetFetchedArray()); 
 $query_builder->Close();
 */
?>