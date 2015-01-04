<?php
namespace Test\Model;

use Test\Model\Table\WorkRestTable;
use Test\Model\Table\AlarmTable;
class Alarm{
	public $db = null ;
	public function __construct(){
		$this->db = new AlarmTable();
	}
    public function selectAll($query){ 
   	 	try {
   	 		if( $query['put'] == 'true'){
   	 			$data = array();
   	 			$data['a_id'] = $query['a_id'];
   	 			$data['al_button'] = 1;
   	 			$data['al_created'] = date('Y-m-d H:i:s');
   	 			$this->db->insert($data);
   	 			return array('success'=>true , 'rows'=> $data );
   	 		}else{
	   	 		$message='';
	   	 		$result['alarm'] = false ;
				// 瓦斯濃度過高 
	   	 		/*  待在浴室過久 用過去統計 40%正 */	   	 		
	   	 		$indoor_location = new IndoorLocation();
	   	 		$query = array();
	   	 		$query['put'] = false;
	   	 		$query['a_id'] = 1; 
	   	 		$im_array = $indoor_location->selectAll($query);
	   	 		if( $im_array['now']['location'] == 'Bathroom' ){
	   	 			$wr_db = new WorkRestTable();
		   	 		$select = $wr_db->getSql()->select();
		   	 		$select->where('`wr_location`=\'Bathroom\' && `wr_title_no_location`=\'shower\'');
		   	 		$select->where('a_id='.$query['a_id']);
		   	 		$select->columns(array('avg'=> new  \Zend\Db\Sql\Expression('AVG(wr_time_diff)')));
		   	 		$shower_avg = $wr_db->selectWith($select)->toArray()[0]['avg'];
		   	 		//Debug::dump($im_array['now']['timeDiff']);
	   	 			if( $im_array['now']['timeDiff'] > (float)$shower_avg * (1.4) ){
	   	 				$message .= '警告! 已待在浴室 '.$im_array['now']['timeDiff'].'分鐘 , 超過平常洗澡時間平均值四成!';
		   	 			$result['alarm'] = true ;
		   	 			$result['msg'] = $message;
		   	 			$data = array();
		   	 			$data['a_id'] = $query['a_id'];
		   	 			$data['al_msg'] = $message;
		   	 			$data['al_created'] = date('Y-m-d H:i:s');
		   	 			$this->db->insert($data);
		   	 			return $result;
	   	 			}
	   	 		}
	   	 		/*按下求救按鈕 10分鐘內 已跳出視窗的會關掉 */
   	 			$select = $this->db->getSql()->select();
	   	 		$select->where('`al_button`=1 && `al_created` > DATE_SUB(now(), INTERVAL 10 MINUTE)');
	   	 		$select->where('a_id='.$query['a_id']);
	   	 		$select->limit(1);
	   	 		if( count($this->db->selectWith($select)->toArray()) != 0 ){
		   	 		$start = strtotime($this->db->selectWith($select)->toArray()[0]['al_created']);
		   	 		$end = strtotime(date('Y-m-d H:i:s'));
	   		 		$timeDiff = $end - $start;
	   	 			$message .= '警告! 在'.floor($timeDiff).'秒鐘前用戶按下緊急按鈕!';
	   	 			$data = array();
	   	 			$data['al_button'] = 0;
	   	 			$data['al_msg'] = $message;
	   	 			$this->db->update($data,array('al_id' => $this->db->selectWith($select)->toArray()[0]['al_id']));		
	   	 			$result['alarm'] = true ;
	   	 			$result['msg'] = $message;
	   	 			return $result;
	   	 		}
	   	 		return $result;
   	 		}
    	}catch (\Exception $e){
    		return array('success'=>false , 'msg'=> $e->getMessage() );
    	}
    }
}
    
?>