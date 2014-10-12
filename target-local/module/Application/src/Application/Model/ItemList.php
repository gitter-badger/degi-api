<?php
namespace Application\Model;
use Application\Model\Table\ItemFlavorTable;
use Application\Model\Table\ItemCateRelTable;

class ItemList{
	public function __construct(){
		$this->if_db = new ItemFlavorTable();
		$this->icr_db = new ItemCateRelTable();
	}
    public function get($id){
   		try {
   			$result_row = array();
   			$ic_array = array();
   			
            if((int)$id == -1){
		    	$ic = new ItemCategory();
		    	$ic_id_1 = $ic->selectItemByType(1);
		    	foreach( $ic_id_1 as $value){
		    		array_push($ic_array, (int)$value['ic_id']);
		    	}
            }else if((int)$id == -2){
            	$ic = new ItemCategory();
            	$ic_id_2 = $ic->selectItemByType(2);
            	foreach( $ic_id_2 as $value){
            		array_push($ic_array, (int)$value['ic_id']);
            	}        	
            }
            array_push($ic_array,$id);
            foreach( $ic_array as $ic_id ){
            	$select = $this->icr_db->getSql()->select();
           		$select->columns(array('im_id'));
           		$select->where('ic_id='.$ic_id);
           		$im_id_array = $this->icr_db->selectWith($select)->toArray();
           		foreach($im_id_array as $im_id_value){
           			$im_id = $im_id_value['im_id'];
         			$select = $this->if_db->getSql()->select();
         			$select->where('item_flavor.im_id='.$im_id);
         			
           			$select->join('item_main','item_main.im_id = item_flavor.im_id',array('im_name'));
           			$select->columns(array('if_id','if_name','if_cover','if_unit_price'));
           			$if_id_array = $this->if_db->selectWith($select)->toArray();
           			foreach( $if_id_array as $if_id ){
           				array_push($result_row, $if_id);
           			}
           		} 
            
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