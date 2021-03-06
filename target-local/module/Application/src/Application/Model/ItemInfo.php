<?php
namespace Application\Model;

use Application\Model\Table\ItemFlavorTable;

class ItemInfo{
	public function __construct(){
		$this->if_db = new ItemFlavorTable();
	}
	public function get($id,$server_url){
		try {
			
			$select = $this->if_db->getSql()->select();
			$select->where('item_flavor.if_id='.$id);
			$select->where('item_flavor.if_status=1');
			$select->join('item_main','item_main.im_id = item_flavor.im_id',array('im_id','im_name','im_description','im_delivery_method','im_spec'));
			$select->columns(array('if_id','if_name','if_cover','if_unit_price'));
			$current_info = array();
			foreach ( $this->if_db->selectWith($select)->toArray() as $value ){
				$value['if_cover'] = $server_url.$_SERVER['REDIRECT_BASE'].'images/item_flavor_cover/'.$value['if_cover'];
				array_push($current_info,$value);
			}
			
			$select = $this->if_db->getSql()->select();
			$where = new \Zend\Db\Sql\Where();
			$where->EqualTo('item_flavor.im_id',$current_info[0]['im_id']);
			$where->and;
			$where->EqualTo('item_flavor.if_status','1');
			$where->and;
			$where->notEqualTo('item_flavor.if_id', $id);
			$select->where($where);
			$select->order('item_flavor.if_seq ASC');				
			$select->columns(array('if_id','if_name','if_cover','if_unit_price'));
			$rel_info = array();
			foreach ( $this->if_db->selectWith($select)->toArray() as $value ){
				$value['if_cover'] = $server_url.$_SERVER['REDIRECT_BASE'].'images/item_flavor_cover/'.$value['if_cover'];
				array_push($rel_info,$value);
			}
			
			unset($current_info[0]['im_id']);
			$result['success'] = true ;
			$result['rows']['current'] = $current_info[0];
			$result['rows']['relate'] = $rel_info;
			return $result;
		}catch (\Exception $e){
			return array('success'=>false , 'msg'=> $e->getMessage() );
		}
	}
}
?>