<?php
namespace Test\Model;

use Test\Model\Table\WorkRestTable;
use Test\Model\Table\TimeRecordTable;
use Test\Model\Table\AccelerationTable;
use Test\Model\Table\IndoorMonitorTable;

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
    public function insert($query){			
    	$data = array();
   	 	//`wr_title`, `wr_start`, `wr_end`, `wr_created`, 
   	 	$data['a_id'] = $query['a_id'];
   	 	$data['wr_title'] = $query['title'];
   	 	$data['wr_title_no_location'] = $query['title_no_location'];
   	 	$data['wr_location'] = $query['location'];
   	 	$data['wr_start'] = $query['start'];
   	 	$data['wr_end'] = $query['end'];
   	 	$data['wr_time_diff'] = $query['time_diff'];
   	 	$data['wr_created'] = date('Y-m-d H:i:s');
   	 	$this->db->insert($data);
   	 	return $data;
    }
    public function CreateWorkRest($query){
    	//`tr_id`, `a_id`, `tr_start`, `tr_end`
    	$tr_db = new TimeRecordTable();
    	$indoor_location = new IndoorLocation();
    	$work_rest = array();
    	
    	$select = $tr_db->getSql()->select();
    	$select->where('`tr_end` < now()');
    	$select->order('tr_created DESC');    	
    	$select->where('a_id='.$query['a_id']);
		$select->limit(1);   
		$start_time = "2015-01-01 00:00:00";
		$end_time = date('Y-m-d H:i:s');
		if(count($tr_db->selectWith($select)->toArray()) != 0){
			$start_time = $tr_db->selectWith($select)->toArray()[0]['tr_end'];
		}

		// time_record_table update
		$time_record_data = array();
		$time_record_data['a_id'] = $query['a_id'];
		$time_record_data['tr_start'] = $start_time;
		$time_record_data['tr_end'] = $end_time;
		$time_record_data['tr_created'] = date('Y-m-d H:i:s');
		$id = $tr_db->insert($time_record_data);
		if (! (boolean) $id) {
			return false;
		}
		
		//Debug::dump($start_time);
		$work_rest = $indoor_location->WorkRestRowData($query['a_id'], 0, $start_time);
    	if( count($work_rest) > 1 ){	
    		for( $i=0 ; $i< count($work_rest)-1 ; $i++){
    			$flag = 1;
    			if($work_rest[$i]['location'] == 'Bedroom'){
    				//  睡覺 bedroom 10分鐘 加速度 此段時間內 std<1
    				if( $work_rest[$i]['timeDiff'] > 10){
	    				$accelerate_db = new AccelerationTable();
	    				//SELECT std(`ac_acceleration_z`) FROM acceleration WHERE 
	    				//`ac_created`> '2014-12-27 04:57:07' AND `ac_created` < '2014-12-27 05:31:52'
	    				$select = $accelerate_db->getSql()->select();
	    				$select->where('`ac_created` < \''.$work_rest[$i]['end'].'\' AND `ac_created` > \''.$work_rest[$i]['start'].'\'');
	    				$select->where('a_id='.$query['a_id']);
	    				$select->columns(array('std'=> new  \Zend\Db\Sql\Expression('std(ac_acceleration_z)')));    				
	    				if( $accelerate_db->selectWith($select)->toArray()[0]['std'] != null && $accelerate_db->selectWith($select)->toArray()[0]['std'] < 1){
	    					$data = array();
	    					$data['a_id'] = $query['a_id'];
	    					$data['title'] = 'sleep @ bedroom('.$work_rest[$i]['serial'].')';
	    					$data['title_no_location'] = 'sleep';
	    					$data['location'] = $work_rest[$i]['location'];
	    					$data['start'] = $work_rest[$i]['start'];
	    					$data['end'] = $work_rest[$i]['end'];
	    					$data['time_diff'] = $work_rest[$i]['timeDiff'];
	    					$this->insert($data);
	    					$flag = 0;
	    				}
    				}
    			}else if( $work_rest[$i]['location'] == 'Bathroom'){
    				// 洗澡 bathroom 3分鐘 濕度 90%以上
    				if( $work_rest[$i]['timeDiff'] > 3){
    					$indoor_monitor_db = new IndoorMonitorTable();
    					$select = $indoor_monitor_db->getSql()->select();
    					$select->where('`im_created` < \''.$work_rest[$i]['end'].'\' AND `im_created` > \''.$work_rest[$i]['start'].'\'');
    					$select->where('a_id='.$query['a_id']);
    					$select->columns(array('avg'=> new  \Zend\Db\Sql\Expression('avg(im_humidity)')));
    					//Debug::dump($indoor_monitor_db->selectWith($select)->toArray()[0]['avg']);
    					if( $indoor_monitor_db->selectWith($select)->toArray()[0]['avg'] != null && $indoor_monitor_db->selectWith($select)->toArray()[0]['avg'] > 90){
    						$data = array();
    						$data['a_id'] = $query['a_id'];
    						$data['title'] = 'shower @ bathroom('.$work_rest[$i]['serial'].')';
    						$data['title_no_location'] = 'shower';
    						$data['location'] = $work_rest[$i]['location'];
    						$data['start'] = $work_rest[$i]['start'];
    						$data['end'] = $work_rest[$i]['end'];
    						$data['time_diff'] = $work_rest[$i]['timeDiff'];
    						$this->insert($data);
    						$flag = 0;
    					}
    				}
    			}else if( $work_rest[$i]['location'] == 'Kitchen'){
    				// 煮飯 kitchen 10分鐘
    				if( $work_rest[$i]['timeDiff'] > 10){
    					$data = array();
    					$data['a_id'] = $query['a_id'];
    					$data['title'] = 'cook @ kitchen('.$work_rest[$i]['serial'].')';
    					$data['title_no_location'] = 'cook';
    					$data['location'] = $work_rest[$i]['location'];
    					$data['start'] = $work_rest[$i]['start'];
    					$data['end'] = $work_rest[$i]['end'];
    					$data['time_diff'] = $work_rest[$i]['timeDiff'];
    					$this->insert($data);    
    					$flag = 0;
    				}
    			}else if( $work_rest[$i]['location'] == 'Livingroom'){
    				// living room 15分鐘 加速度不動 
    				if( $work_rest[$i]['timeDiff'] > 15){
    					$accelerate_db = new AccelerationTable();
    					//SELECT std(`ac_acceleration_z`) FROM acceleration WHERE
    					//`ac_created`> '2014-12-27 04:57:07' AND `ac_created` < '2014-12-27 05:31:52'
    					$select = $accelerate_db->getSql()->select();
    					$select->where('`ac_created` < \''.$work_rest[$i]['end'].'\' AND `ac_created` > \''.$work_rest[$i]['start'].'\'');
    					$select->where('a_id='.$query['a_id']);
    					$select->columns(array('std'=> new  \Zend\Db\Sql\Expression('std(ac_acceleration_z)')));
    					if( $accelerate_db->selectWith($select)->toArray()[0]['std'] != null && $accelerate_db->selectWith($select)->toArray()[0]['std'] < 1){
    						$data = array();
    						$data['a_id'] = $query['a_id'];
    						$data['title'] = 'watch tv @ livingroom('.$work_rest[$i]['serial'].')';
    						$data['title_no_location'] = 'watch tv';
    						$data['location'] = $work_rest[$i]['location'];
    						$data['start'] = $work_rest[$i]['start'];
    						$data['end'] = $work_rest[$i]['end'];
    						$data['time_diff'] = $work_rest[$i]['timeDiff'];
    						$this->insert($data);
    						$flag = 0;
    					}
    				}
    			}else if( $work_rest[$i]['location'] == 'Diningroom'){
    				// dining room 5分鐘 
    				if( $work_rest[$i]['timeDiff'] > 5){
    					$data = array();
    					$data['a_id'] = $query['a_id'];
    					$data['title'] = 'eat @ diningroom('.$work_rest[$i]['serial'].')';
    					$data['title_no_location'] = 'eat';
    					$data['location'] = $work_rest[$i]['location'];
    					$data['start'] = $work_rest[$i]['start'];
    					$data['end'] = $work_rest[$i]['end'];
    					$data['time_diff'] = $work_rest[$i]['timeDiff'];
    					$this->insert($data);    
    					$flag = 0;
    				}
    			}else{
    				$data = array();
    				$data['a_id'] = $query['a_id'];
    				$data['title'] = 'outdoor';
    				$data['title_no_location'] = 'outdoor';
    				$data['location'] = '';
    				$data['start'] = $work_rest[$i]['start'];
    				$data['end'] = $work_rest[$i]['end'];
    				$data['time_diff'] = $work_rest[$i]['timeDiff'];
    				$this->insert($data);
    				$flag = 0;
    			}
    			if( $flag ){
    				$data = array();
    				$data['a_id'] = $query['a_id'];
    				$data['title'] = '@ '.$work_rest[$i]['location'].'('.$work_rest[$i]['serial'].')';
    				$data['title_no_location'] = '';
    				$data['location'] = $work_rest[$i]['location'];
    				$data['start'] = $work_rest[$i]['start'];
    				$data['end'] = $work_rest[$i]['end'];
    				$data['time_diff'] = $work_rest[$i]['timeDiff'];
    				$this->insert($data);	
    			}
    		}    	
    		$end_time = $work_rest[count($work_rest)-2]['end'];
    	}
    	$data = array();
    	$data['tr_end'] = $end_time;
    	$tr_db->update($data,array('tr_id' => $tr_db->lastInsertValue));
    	return true;
    }
    public function selectAll($query){
   	 		if( $query['put'] == 'true'){
   	 			try {
   	 				$data = $this->insert($query);
   	 				return array('success'=>true , 'rows'=> $data );
   	 			}catch (\Exception $e){
   	 				return array('success'=>false , 'msg'=> $e->getMessage() );
   	 			}
   	 		}else{
   	 			try {
   	 				$this->CreateWorkRest($query);
	   	 			$select = $this->db->getSql()->select();
	   	 			$select->where('`wr_created` > DATE_SUB(now(), INTERVAL 12 MONTH)');
	   	 			$select->where('a_id='.$query['a_id']);
	   	 			$select->columns(array('title'=>'wr_title','start'=>'wr_start','end'=>'wr_end'));
	   	 			$result['success'] = true ;
	   	 			$result['rows'] = $this->db->selectWith($select)->toArray();			   	 			
   	 				return $result;
   	 			}catch (\Exception $e){
   	 				$select = $this->db->getSql()->select();
   	 				$select->where('`wr_created` > DATE_SUB(now(), INTERVAL 12 MONTH)');
   	 				$select->where('a_id='.$query['a_id']);
   	 				$select->columns(array('title'=>'wr_title','start'=>'wr_start','end'=>'wr_end'));
   	 				$result['success'] = true ;
   	 				$result['rows'] = $this->db->selectWith($select)->toArray();
   	 				return $result;
   	 			}
   	 		}
    }
}
    
?>