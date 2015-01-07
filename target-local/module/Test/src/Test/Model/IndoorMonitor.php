<?php
namespace Test\Model;
use Test\Model\Table\IndoorMonitorTable;
class IndoorMonitor{
	public $db = null ;
	public function __construct(){
		$this->db = new IndoorMonitorTable();
	}
	public function update($data , $id){
		try {
			$this->db->update($data , array('il_id'=>$id));
			return array('success'=>true , 'data'=> $data );
		}catch (\Exception $e){
			return array('success'=>false , 'msg'=> $e->getMessage() );
		}
	}
    public function delete($id){
        $this->db->delete('il_id =' . (int) $id);
        return array('success'=>true  );
    }
    
    public function get($id){
        return array('success'=>true , 'data'=> $this->db->select(array('il_id'=>$id))->current());
    }
    
    public function selectAll($query){ // $query['minute'] , $query['put']
   	 	try {
   	 		if( $query['put'] == 'true'){
   	 			$data = array();
				//`il_location`, `il_serial`, `im_temperature`, `im_humidity`, `im_gas`, `im_created`   	 			
				$data['a_id'] = $query['a_id'];
   	 			$data['il_location'] = $query['location'];
   	 			$data['il_serial'] = $query['serial'];
   	 			if( !empty($query['temperature'])){ $data['im_temperature'] = $query['temperature']; }
   	 			if( !empty($query['humidity'])){ $data['im_humidity'] = $query['humidity']; }
   	 			if( !empty($query['gas'])){ $data['im_gas'] = $query['gas']; }
   	 			$data['im_created'] = date('Y-m-d H:i:s',(time()+42237));
   	 			$this->db->insert($data);
   	 			return array('success'=>true , 'rows'=> $data );
   	 		}else{
   	 			
   	 			if(empty( $query['monitor'])){
   	 				$select = $this->db->getSql()->select();
   	 				$select->where('il_location="Bathroom"');
   	 				$select->where('a_id='.$query['a_id']);
   	 				$select->order('im_created DESC');
   	 				$select->limit(1);
   	 				$result['success'] = true;
   	 				$result['rows']['temperature'] = $this->db->selectWith($select)->toArray()[0]['im_temperature'];
   	 				$result['rows']['humidity'] = $this->db->selectWith($select)->toArray()[0]['im_humidity'];
   	 				$select = $this->db->getSql()->select();
   	 				$select->where('il_location="Kitchen"');
   	 				$select->where('a_id='.$query['a_id']);
   	 				$select->order('im_created DESC');
   	 				$select->limit(1);
   	 				$result['rows']['gas'] = $this->db->selectWith($select)->toArray()[0]['im_gas'];
   	 				 
   	 				return $result;
   	 			}
   	 			$select = $this->db->getSql()->select();
   	 			$select->where('`im_created`  >  DATE_SUB(now()+INTERVAL 42237 SECOND, INTERVAL 24 HOUR)');
   	 			$select->where('a_id='.$query['a_id']);
   	 			
   	 			if( $query['monitor'] == 'temperature' ){ 
   	 				$select->where('il_location="Bathroom"');
   	 				$select->columns(array('period'=>'im_created','temperature'=>'im_temperature'));
   	 			}
   	 			if( $query['monitor'] == 'humidity'){
   	 				$select->where('il_location="Bathroom"');
   	 				$select->columns(array('period'=>'im_created','humidity'=>'im_humidity'));
   	 			}
   	 			if( $query['monitor'] == 'gas' ){ 
   	 				$select->where('il_location="Kitchen"'); 
   	 				$select->columns(array('period'=>'im_created','gas'=>'im_gas'));
   	 			}

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