<?php
namespace Application\Model;
use Application\Model\Table\ItemFlavorTable;

class Carousel{
	public function __construct(){
		$this->if_db = new ItemFlavorTable();
	}
    public function get($id,$server_url){
   		try {
   			$select = $this->if_db->getSql()->select();
   			$select->join('item_main','item_main.im_id = item_flavor.im_id',array('im_name'));
   			$select->join('item_cate_rel','item_main.im_id = item_cate_rel.im_id',array());
   			$select->join('item_category','item_category.ic_id = item_cate_rel.ic_id',array());
   			if( $id == '-1'){
   				$select->where('item_category.ic_type = 1');
   			}else if( $id == '-2'){
   				$select->where('item_category.ic_type = 2');
   			}else{
	   			$select->where('item_category.ic_id ='.$id);
   			}	
   			$select->where('item_flavor.if_status=1');
   			$select->where('item_flavor.if_seq=1');
   			
	   		$select->columns(array('if_id','if_cover'));

           	$if_id_array = $this->if_db->selectWith($select)->toArray();
	   		$result_row = array();
   			foreach ( $if_id_array as $value ){
   				$value['if_cover'] = $server_url.$_SERVER['REDIRECT_BASE'].'images/item_flavor_cover/'.$value['if_cover'];
           	    array_push($result_row, $value);
   			}
   			$result['success'] = true ;
   			$result['rows'] = $result_row;
   			return $result;

        }catch (\Exception $e){
            return array('success'=>false , 'msg'=> $e->getMessage() );
        }
    }
}
?>