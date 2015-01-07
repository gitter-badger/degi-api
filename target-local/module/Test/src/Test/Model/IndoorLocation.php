<?php
namespace Test\Model;
use Test\Model\Table\IndoorLocationTable;
class IndoorLocation{
	public $db = null ;
	public function __construct(){
		$this->db = new IndoorLocationTable();
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
    public function WorkRestRowData($a_id,$time_interval,$start_time){
    	$select = $this->db->getSql()->select();
    	if( $time_interval != 0 ){
    		$select->where('`il_created` > DATE_SUB(now()+INTERVAL 42237 SECOND, INTERVAL '.$time_interval.' HOUR)');
    	}else{
    		$select->where('`il_created` > \''.$start_time.'\'');
    	}
    	$select->order('il_created ASC');
    	$select->where('a_id='.$a_id);
    	$work_rest = array();
    	
    	$indoor_location_rawdata = $this->db->selectWith($select)->toArray();
    	
    	if( count( $indoor_location_rawdata ) == 0 ){
    		$select = $this->db->getSql()->select();
    		$select->where('a_id='.$a_id);
    		$select->order('il_created DESC');
    		$select->limit(1);
    		
    		$object = array();
    		$object['location'] = 'Outdoor';
    		$object['start'] = $this->db->selectWith($select)->toArray()[0]['il_created'];
    		$object['end'] = date('Y-m-d H:i:s',(time()+42237));
    		$start = strtotime($object['start']);
    		$end = strtotime($object['end']);
    		$timeDiff = $end - $start;
    		$object['timeDiff'] = floor($timeDiff / 60);
    		array_push($work_rest, $object);
    	}else{ 
	    	$tmp_location = $indoor_location_rawdata[0]['il_location'];
	    	$tmp_serial = $indoor_location_rawdata[0]['il_serial'];
	    	
	    	$startTime = $indoor_location_rawdata[0]['il_created'];
	    	$endTime = $indoor_location_rawdata[0]['il_created'];
	
	    	foreach ( $indoor_location_rawdata as $index => $value ){
	   	    		
	    		if( $tmp_serial != $value['il_serial']){
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
	    			if($index == sizeof($indoor_location_rawdata)-1){
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
	    		}else{
	    			if( strtotime($value['il_created']) - strtotime($endTime) > 3600){
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
	    			}
		    		if($index == sizeof($indoor_location_rawdata)-1){
		    			$start = strtotime($startTime);
		    			$end = strtotime($value['il_created']);
		    			$timeDiff = $end - $start;
		    			$input = array();
		    			$input['location'] = $tmp_location;
		    			$input['serial'] = $tmp_serial;
		    			$input['start'] = $startTime;
		    			$input['end'] = $value['il_created'];
		    			$input['timeDiff'] = floor($timeDiff / 60);
		    			array_push($work_rest, $input);	    		
	    			}
	    		}
	    		$endTime = $value['il_created'];
	    		$tmp_location = $value['il_location'];
	    		$tmp_serial = $value['il_serial'];
	    	}
	    	$flag = 0;
	    	while ( $flag <= count($work_rest)-1 ){
	    		if( $flag == count($work_rest)-1){
	    			if((strtotime(date('Y-m-d H:i:s',(time()+42237))) - strtotime($work_rest[$flag]['end']) > 300)){
	    				$object = array();
	    				$object['location'] = 'Outdoor';
	    				$object['start'] = $work_rest[$flag]['end'];
	    				$object['end'] = date('Y-m-d H:i:s',(time()+42237));
	    				$start = strtotime($object['start']);
	    				$end = strtotime($object['end']);
	    				$timeDiff = $end - $start;
	    				$object['timeDiff'] = floor($timeDiff / 60);
	    				array_push($work_rest, $object);
	    			}
	    		}else{
	    			if(   strtotime($work_rest[$flag+1]['start']) - strtotime($work_rest[$flag]['end']) > 300 ){
	    				$object = array();
	    				$object['location'] = 'Outdoor';
	    				$object['start'] = $work_rest[$flag]['end'];
	    				$object['end'] = $work_rest[$flag+1]['start'];
	    				$start = strtotime($object['start']);
	    				$end = strtotime($object['end']);
	    				$timeDiff = $end - $start;
	    				$object['timeDiff'] = floor($timeDiff / 60);
	    				$offset = $flag+1;
	    				if($offset == 0){
	    					array_unshift($work_rest, $object);
	    				}else{
	    					$a1 = array_slice($work_rest, 0, $offset);
	    					$a2 = array_slice($work_rest, $offset);
	    					array_push($a1, $object);
	    					$work_rest = array_merge($a1, $a2);
	    				}
	    				$flag++;
	    			}
	    		}
	    		$flag++;
	    	}
    	}
    	return $work_rest;
    }
    public function selectAll($query){ // $query['minute'] , $query['put']
   	 	try {
   	 		if( $query['put'] == 'true'){
   	 			$data = array();
				//`a_id`, `il_location`, `il_serial`, `il_created`   	 			
				$data['a_id'] = $query['a_id'];
   	 			$data['il_location'] = $query['location'];
   	 			$data['il_serial'] = $query['serial'];
   	 			$data['il_created'] = date('Y-m-d H:i:s',(time()+42237));
   	 			//$data['il_created'] = date('Y-m-d H:i:s');
   	 			
   	 			$this->db->insert($data);
   	 			return array('success'=>true , 'rows'=> $data );
   	 		}else{
   	 			$work_rest = $this->WorkRestRowData($query['a_id'], 30, null);
   	 			$result['success'] = true ;
   	 			$result['now'] = $work_rest[sizeof($work_rest)-1];
   	 			$result['work_rest'] = $work_rest;			
   	 			return $result;
   	 		}		
    	}catch (\Exception $e){
    		return array('success'=>false , 'msg'=> $e->getMessage() );
    	}
    }
}
?>