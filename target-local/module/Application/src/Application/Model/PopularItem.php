<?php
namespace Application\Model;

use Application\Model\Table\PopularItemTable;
class PopularItem{
	
	public function __construct(){
		$this->db = new PopularItemTable();
	}
	public function get($id,$server_url,$query){
		try {
			$select = $this->db->getSql()->select();
			$select->where('pi_type='.$id);
			$select->join('item_flavor','item_flavor.im_id = popular_item.im_id',array('if_id'));
			$select->where('item_flavor.if_seq=1');	
			$select->where('item_flavor.if_status=1');
			$select->order('popular_item.pi_seq ASC');
			$select->columns(array('pi_id','pi_type','pi_image','pi_title','pi_description','pi_seq'));
			if(!empty($query['limit'])){ 
				$select->limit((int)$query['limit']);
			}
			$result_array = array();
			foreach ( $this->db->selectWith($select)->toArray() as $value ){
				$value['pi_image'] = $server_url.$_SERVER['REDIRECT_BASE'].'images/item_flavor_cover/'.$value['pi_image'];
				array_push($result_array,$value);
			}
				
			$result['success'] = true ;
			$result['rows'] = $result_array;
			return $result;
		}catch (\Exception $e){
			return array('success'=>false , 'msg'=> $e->getMessage() );
		}
	}
}
?>