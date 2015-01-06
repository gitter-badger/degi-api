<?php
namespace Test\Model;

use Test\Model\Table\GPSTable;

class GPS{
	public $db = null ;
	public function __construct(){
		$this->db = new GPSTable();
	}
	public function update($data , $id){
		try {
			$this->db->update($data , array('g_id'=>$id));
			return array('success'=>true , 'data'=> $data );
		}catch (\Exception $e){
			return array('success'=>false , 'msg'=> $e->getMessage() );
		}
	}
    public function delete($id){
        $this->db->delete('g_id =' . (int) $id);
        return array('success'=>true  );
    }
    
    public function get($id){
        return array('success'=>true , 'data'=> $this->db->select(array('g_id'=>$id))->current());
    }
    
    public function selectAll($query){ // $query['minute'] , $query['put'] , 
   	 	try {
   	 		if( $query['put'] == 'true'){
   	 			$data = array();
   	 			//`g_id`, `a_id`, `g_Lat`, `g_Lng`
   	 			$data['a_id'] = $query['a_id'];
   	 			$data['g_Lat'] = $query['Lat'];
   	 			$data['g_Lng'] = $query['Lng'];
   	 			$data['g_status'] = $query['status'];
   	 			$data['g_created'] = date('Y-m-d H:i:s',(time()+8*3600));
   	 			$this->db->insert($data);
   	 			return array('success'=>true , 'rows'=> $data );
   	 		}else if( $query['put'] == 'false'){
   	 			$select = $this->db->getSql()->select();
   	 			$select->where('`g_created` > DATE_SUB(now(), INTERVAL '. $query['minute'] .' MINUTE)');
   	 			// > DATE_SUB(now(), INTERVAL 5 MONTH)
   	 			$select->where('a_id='.$query['a_id']);
   	 			$select->order('g_created DESC');
   	 			$result['success'] = true ;
   	 			$result['rows'] = $this->db->selectWith($select)->toArray();			
   	 			return $result;
   	 		}else{
   	 			$tmp = array();
   	 			$tmp['rain'] = '30%';
   	 			$result['success'] = true ;
   	 			$result['rows'] = $tmp;
   	 			return $result;
   	 		}		
    	}catch (\Exception $e){
    		return array('success'=>false , 'msg'=> $e->getMessage() );
    	}
    }
}
    
?>