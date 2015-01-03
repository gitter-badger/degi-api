<?php
namespace Test\Model;

use Test\Model\Table\WorkRestTable;

class WorkRest {
	public $db = null ;
	public function __construct(){
		$this->db = new WorkRestTable();
	}
	public function update($data , $id){
		try {
			$this->db->update($data , array('wr_id'=>$id));
			return array('success'=>true , 'data'=> $data );
		}catch (\Exception $e){
			return array('success'=>false , 'msg'=> $e->getMessage() );
		}
	}
    public function delete($id){
        $this->db->delete('wr_id =' . (int) $id);
        return array('success'=>true  );
    }
    
    public function get($id){
        return array('success'=>true , 'data'=> $this->db->select(array('wr_id'=>$id))->current());
    }
    public function insert($data){			
    	$this->db->insert($data);
   	 	return array('success'=>true , 'rows'=> $data );    
    }
    public function selectAll($query){
   	 	try {
   	 		if( $query['put'] == 'true'){
   	 			$data = array();
   	 			//`wr_title`, `wr_start`, `wr_end`, `wr_created`, 
   	 			$data['a_id'] = $query['a_id'];
   	 			$data['wr_title'] = $query['title'];
   	 			$data['wr_start'] = $query['start'];
   	 			$data['wr_end'] = $query['end'];
   	 			$data['wr_created'] = date('Y-m-d H:i:s');
   	 			$this->db->insert($data);
   	 			return array('success'=>true , 'rows'=> $data );
   	 		}else{
   	 			$select = $this->db->getSql()->select();
   	 			$select->where('`wr_created` > DATE_SUB(now(), INTERVAL 12 MONTH)');
   	 			// > DATE_SUB(now(), INTERVAL 5 MONTH)
   	 			$select->where('a_id='.$query['a_id']);
   	 			$select->columns(array('title'=>'wr_title','start'=>'wr_start','end'=>'wr_end','allDay'=>'wr_all_day'));
   	 			$result['success'] = true ;
   	 			$result['rows'] = $this->db->selectWith($select)->toArray();			
   	 			return $result;
   	 		}
    	}catch (\Exception $e){
    		return array('success'=>false , 'msg'=> $e->getMessage() );
    	}
    }
}
    
?>