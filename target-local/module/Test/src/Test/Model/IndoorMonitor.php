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
   	 			$data['im_created'] = date('Y-m-d H:i:s');
   	 			$this->db->insert($data);
   	 			return array('success'=>true , 'rows'=> $data );
   	 		}else{
   	 			$select = $this->db->getSql()->select();
   	 			$select->where('`il_created` > DATE_SUB(now(), INTERVAL 24 HOUR)');
   	 			// > DATE_SUB(now(), INTERVAL 5 MONTH)
   	 			$select->where('a_id='.$query['a_id']);
   	 			$work_rest = array();
   	 			$indoor_location_rawdata = $this->db->selectWith($select)->toArray();
				$tmp_location = $indoor_location_rawdata[0]['il_location'];
				$tmp_serial = $indoor_location_rawdata[0]['il_serial'];
				
				$startTime = $indoor_location_rawdata[0]['il_created'];
				$endTime = $indoor_location_rawdata[0]['il_created'];
				
   	 			foreach ( $indoor_location_rawdata as $index => $value ){
   	 				if( $tmp_serial != $value['il_serial'] || $index == sizeof($indoor_location_rawdata)-1){
   	 					$start = strtotime($startTime);
   	 					$end = strtotime($endTime);
   	 					$timeDiff = $end - $start;
   	 					$input = array();
   	 					$input['location'] = $tmp_location;
   	 					$input['serial'] = $tmp_serial;
   	 					$input['start'] = $startTime;
   	 					$input['end'] = $endTime;
   	 					$input['timeDiff'] = floor($timeDiff / 60);
   	 					array_push($work_rest, $input);
   	 					$startTime = $value['il_created'];	
   	 					if( $index == sizeof($indoor_location_rawdata)-1 && $tmp_serial != $value['il_serial']){
   	 						$start = strtotime($startTime);
   	 						$end = strtotime($startTime);
   	 						$timeDiff = $end - $start;
   	 						$input = array();
   	 						$input['location'] = $value['il_location'];
   	 						$input['serial'] = $value['il_serial'];
   	 						$input['start'] = $startTime;
   	 						$input['end'] = $startTime;
   	 						$input['timeDiff'] = floor($timeDiff / 60);
   	 						array_push($work_rest, $input);
   	 					} 
   	 				}
   	 				$endTime = $value['il_created'];
   	 				$tmp_location = $value['il_location'];
   	 				$tmp_serial = $value['il_serial'];
   	 			}
   	 			$result['success'] = true ;
   	 			$result['now'] = $work_rest[sizeof($work_rest)-1];
   	 			if( $result['now']['location'] =='Outdoor' ){
   	 				$tmp = $result['now'];
   	 				$tmp['end'] = date('Y-m-d H:i:s');
   	 				$start = strtotime($tmp['start']);
   	 				$end = strtotime($tmp['end']);
   	 				$timeDiff = $end - $start;
   	 				$tmp['timeDiff'] = floor($timeDiff / 60);
   	 				$result['now'] = $tmp;
   	 			}
   	 			$result['work_rest'] = $work_rest;			
   	 			return $result;
   	 		}		
    	}catch (\Exception $e){
    		return array('success'=>false , 'msg'=> $e->getMessage() );
    	}
    }
}
?>