<?php
namespace Administrator\Model;

use Administrator\Model\Table\BulkItemTable;
use Administrator\Model\Table\ItemFlavorTable;

class BulkItem{
	public function __construct(){
		$this->db = new BulkItemTable();
	}
    public function selectAll($query){
   		try {
   			$if_db = new ItemFlavorTable();
   			
   			$select = $if_db->getSql()->select();
   			$select->join('item_main','item_main.im_id = item_flavor.im_id',array('im_id','bpi_name'=>'im_name'));
   			$select->join('item_cate_rel','item_main.im_id = item_cate_rel.im_id',array());
   			$select->join('item_category','item_category.ic_id = item_cate_rel.ic_id',array('ic_id','bpi_category'=>'ic_name'));
   			$select->where('item_category.ic_type = 1');
   			$select->where('item_flavor.if_status=1');
   			$select->order('item_category.ic_seq ASC');
   			$select->order('item_cate_rel.icr_seq ASC');
   			$select->order('item_flavor.if_seq ASC');   			
	   		$select->columns(array('bpi_flavor'=>'if_name','bpi_price'=>'if_unit_price'));
   		
   			$result['success'] = true ;
   			$result['rows'] = $if_db->selectWith($select)->toArray();  
   			return $result;
        }catch (\Exception $e){
            return array('success'=>false , 'msg'=> $e->getMessage() );
        }
    }
    
    public function get($id){ 
    	try {
    		$select = $this->db->getSql()->select();
    		$select->where->equalTo('cm_id',$id);
    		$select->order('ic_id ASC');
    		$cmp = $this->db->selectWith($select)->toArray();
            $result['success'] = true;
            $result['rows'] = Json_encode($cmp);
            return $result;
    	}catch (\Exception $e){
    		return array('success'=>false , 'msg'=> $e->getMessage() );
    	}
    }
    
    public function update($data , $id){
    	try {
    		$this->db->update($data , array('bpi_id'=>$id));
    		return array('success'=>true , 'data'=> $data );
    	}catch (\Exception $e){
    		return array('success'=>false , 'msg'=> $e->getMessage() );
    	}
    }

    public function insert($data){
    	try {
    		
	    	$data_tmp = json_decode($data['id']);
	    	$cm_id = $data['cm_id'];
	    	$insert_data = array();
	    	foreach( $data_tmp as $value){
	    		
	    		$select = $this->db->getSql()->select();
	    		$select->where->equalTo('cm_id',$cm_id)
	    		->equalTo('ic_id',$value->ic_id)
	    						->equalTo('im_id',$value->im_id)
	    						->equalTo('bpi_flavor',$value->bpi_flavor);
	    		if( empty($this->db->selectWith($select)->toArray() )){
	    			$tmp_array = array();
		    		$tmp_array['cm_id'] = $cm_id;
		    		$tmp_array['ic_id'] = $value->ic_id;
		    		$tmp_array['bpi_category'] = $value->bpi_category;
		    		$tmp_array['im_id'] = $value->im_id;
		    		$tmp_array['bpi_name'] = $value->bpi_name;
		    		$tmp_array['bpi_flavor'] = $value->bpi_flavor;
		    		$tmp_array['bpi_price'] = $value->bpi_price;
		    		$tmp_array['bpi_sprice'] = $value->bpi_price;
		    		$tmp_array['bpi_created'] = date('Y-m-d H:i:s');
		    		$this->db->insert($tmp_array);
		    		array_push($insert_data, $tmp_array);
	    		}
	    	}
    	 
    		return array('success'=>true , 'data'=>$insert_data);
    	}catch (\Exception $e){
    		return array('success'=>false , 'msg'=> $e->getMessage() );
    	}
    }
    public function delete($id){
        $this->db->delete('bpi_id =' . (int) $id);
        return array('success'=>true  );
    }
}
?>