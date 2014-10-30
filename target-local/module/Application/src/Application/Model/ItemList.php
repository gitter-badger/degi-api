<?php
namespace Application\Model;
use Application\Model\Table\ItemFlavorTable;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\DbSelect;

class ItemList{
	public function __construct(){
		$this->if_db = new ItemFlavorTable();
	}
    public function get($id,$server_url,$query){
   		try {
   			$select = $this->if_db->getSql()->select();
   			$select->join('item_main','item_main.im_id = item_flavor.im_id',array('im_name','im_spec'));
   			$select->join('item_cate_rel','item_main.im_id = item_cate_rel.im_id',array());
   			$select->join('item_category','item_category.ic_id = item_cate_rel.ic_id',array('ic_id'));
   			if( $id == '-1'){
   				$select->where('item_category.ic_type = 1');
   			}else if( $id == '-2'){
   				$select->where('item_category.ic_type = 2');
   			}else{
	   			$select->where('item_category.ic_id ='.$id);
   			}	
   			$select->where('item_flavor.if_status=1');
   			$select->order('item_category.ic_seq ASC');
   			$select->order('item_cate_rel.icr_seq ASC');
   			$select->order('item_flavor.if_seq ASC');   			
	   		$select->columns(array('if_id','if_name','if_cover','if_unit_price'));

   			$paginator = new Paginator(new DbSelect($select, $this->if_db->adapter));
   			$paginator->setItemCountPerPage($query['limit'])->setCurrentPageNumber($query['page']);
   			$result_row = array();
   			foreach ( $paginator->getCurrentItems()->toArray() as $value ){
   				$value['if_cover'] = $server_url.$_SERVER['REDIRECT_BASE'].'images/item_flavor_cover/'.$value['if_cover'];
           	    array_push($result_row, $value);
   			}
   			$result['success'] = true ;
   			$result['total'] = $paginator->getTotalItemCount();
   			$result['rows'] = $result_row;
   			return $result;

        }catch (\Exception $e){
            return array('success'=>false , 'msg'=> $e->getMessage() );
        }
    }
}
?>