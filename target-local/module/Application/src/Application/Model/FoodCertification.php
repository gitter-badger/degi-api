<?php
namespace Application\Model;

use Application\Model\Table\FoodCertificationTable;
class FoodCertification{
	
	public function __construct(){
		$this->db = new FoodCertificationTable();
	}
    public function selectAll($server_url){
        try{ 
        	$select = $this->db->getSql()->select();
        	$select->order('fc_seq ASC');
        	$select->columns(array('fc_id','fc_name','fc_image','fc_seq'));
        	$result_row = array();
        	foreach ($this->db->selectWith($select)->toArray() as $value){
	        	$value['fc_image'] = $server_url.$_SERVER['REDIRECT_BASE'].'images/food_certification_image/'.$value['fc_image'];
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