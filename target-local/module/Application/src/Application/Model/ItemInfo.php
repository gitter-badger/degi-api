<?php
namespace Application\Model;

use Application\Model\Table\ItemFlavorTable;

class ItemInfo{
	public function __construct(){
		$this->if_db = new ItemFlavorTable();
	}
	public function get($id){
		try {
			
			$select = $this->if_db->getSql()->select();
			$select->where('item_flavor.if_id='.$id);
			$select->join('item_main','item_main.im_id = item_flavor.im_id',array('im_id','im_name','im_description','im_delivery_method','im_spec'));
			$select->columns(array('if_id','if_name','if_cover','if_unit_price'));
			$current_info = $this->if_db->selectWith($select)->toArray();
			
			$select = $this->if_db->getSql()->select();
			$where = new \Zend\Db\Sql\Where();
			$where->EqualTo('item_flavor.im_id',$current_info[0]['im_id']);
			$where->and;
			$where->notEqualTo('item_flavor.if_id', $id);
			$select->where($where);
			$select->columns(array('if_id','if_name','if_cover','if_unit_price'));
			$rel_info = $this->if_db->selectWith($select)->toArray();
			
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