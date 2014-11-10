<?php
namespace Application\Model;

use Application\Model\Table\StoreLocationTable;
class StoreLocation{
	
	public function __construct(){
		$this->db = new StoreLocationTable();
	}
    public function selectAll($server_url){
        try{ 
        	$select = $this->db->getSql()->select();
        	$select->order('sl_seq ASC');
        	$result_row = array();
        	foreach ($this->db->selectWith($select)->toArray() as $value){
	        	$value['sl_cover'] = $server_url.$_SERVER['REDIRECT_BASE'].'images/store_location_cover/'.$value['sl_cover'];
        		array_push($result_row, $value);
        	}
            $result['success'] = true;
            $result['rows'] = $result_row;
            return $result;
        }catch (\Exception $e){
        	return array('success'=>false , 'msg'=> $e->getMessage() );
        }
    } 
}
?>