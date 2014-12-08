<?php
namespace Application\Model;
use Application\Model\Table\OrderMainTable;
use Application\Model\Table\ItemFlavorTable;
use Application\Model\Table\MemberPointTable;
use Application\Model\Table\ItemMainTable;
use Zend\Db\Sql\Expression;

class Order{
	public $db = null ;
	public function __construct(){
		$this->db = new OrderMainTable();
	}
	public function update($data , $mm_id){//data{'om_id,access_token'} id:{mm_id}
		try {
			//Debug::dump($data);
			$member = new Member();
			if( !$member->InternalCheckLogin($data['access_token']) ){
				return array('success'=>false , 'msg'=> '未通過登入認證，請重新登入!' );
			}
			$member_point_db = new MemberPointTable();
			$select = $member_point_db->getSql()->select();
			$select->where('om_id='.(int)$data['om_id']);
			if( !empty($member_point_db->selectWith($select)->toArray())){
				return array('success'=>false , 'msg'=> '此訂單已經有綁定的會員，無法重複綁定' );
			}
			
			$select = $member_point_db->getSql()->select();
			$select->where('mm_id='.$mm_id);
			$select->where->greaterThanOrEqualTo("mrp_reward_deadline", date('Y-m-d'));
			$select->order('mrp_created ASC');
			$select->columns(array('total'=>new Expression("SUM(`mrp_used_check`)")));			
			$member_last_order = $member_point_db->selectWith($select)->toArray();
			$member_last_amount = !empty($member_last_order[0]['total'])?$member_last_order[0]['total']:0;
			
			$select = $this->db->getSql()->select();
			$select->where('om_id='.(int)$data['om_id']);
			$om = $this->db->selectWith($select)->toArray();
			
			$data_mpr = array();
			$data_mpr['mm_id'] = $mm_id;
			$data_mpr['om_id'] = $data['om_id'];
			$data_mpr['mrp_last_amount'] = $member_last_amount;
			$data_mpr['mrp_use_reward'] = 0;
			$data_mpr['mrp_get_reward'] = (int)$om[0]['om_get_point'];
			$data_mpr['mrp_used_check'] = $data_mpr['mrp_get_reward'];
			$data_mpr['mrp_now_amount'] = $data_mpr['mrp_last_amount'] - $data_mpr['mrp_use_reward'] + $data_mpr['mrp_get_reward'];
			
			$date = new \DateTime(date('Y-m-d'));
			$date->add(new \DateInterval('P1Y'));			
			$data_mpr['mrp_reward_deadline'] = $date->format('Y-m-d');
			
			$data_mpr['mrp_created'] = date('Y-m-d H:i:s');
			$member_point_db->insert($data_mpr);
			$data_mpr['mrp_id'] = $member_point_db->getLastInsertValue() ;
			
			$data_om = array();
			$data_om['mm_id'] = $mm_id; 
			$this->db->update($data_om , array('om_id'=>$data['om_id']));
			
			return array('success'=>true , 'data'=> $data_mpr );
		}catch (\Exception $e){
			return array('success'=>false , 'msg'=> $e->getMessage() );
		}
	}
	public function get($om_id,$query){//id:om_id,query{access_token}
		if( !empty($query['access_token'])){
			$access_token = $query['access_token'];
			$member = new Member();
			$mm_id = $member->InternalCheckLogin($access_token);
			if( !$mm_id ){
				return array('success'=>false , 'msg'=> '未通過登入認證，請重新登入!' );
			}
			try {
				$select = $this->db->getSql()->select();
				$select->where('om_id='.(int)$om_id);
				$select->where('mm_id='.(int)$mm_id);
				$result_row = $this->db->selectWith($select)->toArray();
				if(!count($result_row)){
					return array('success'=>false , 'msg'=> '此登入帳號不具此訂單權限' );
				}else{
					$result['success'] = true ;
					$result['rows'] = $result_row;
					return $result;
				}
			}catch (\Exception $e){
				return array('success'=>false , 'msg'=> $e->getMessage() );
			}
		}else{
			try {
				$select = $this->db->getSql()->select();
				$select->where('om_id='.(int)$om_id);
				$result_row = $this->db->selectWith($select)->toArray();
				if($result_row[0]['mm_id']!='0'){
					return array('success'=>false , 'msg'=> '不具此訂單權限' );
				}else{
					$result['success'] = true ;
					$result['rows'] = $result_row;
					return $result;
				}
			}catch (\Exception $e){
				return array('success'=>false , 'msg'=> $e->getMessage() );
			}
		}
	}
	public function selectAll($query){//query{mm_id,access_token}
		
// 		$group = array();
// 		$group[0]['bpi_id'] = 1;
// 		$group[0]['ic_id'] = 1;
// 		$group[0]['bpi_category'] = '甜點';
// 		$group[0]['im_id'] = 1;
// 		$group[0]['bpi_name'] = '養生桂圓蛋糕';
// 		$group[0]['bpi_flavor'] = '大蒜';
// 		$group[0]['bpi_sprice'] = 100;
// 		$group[0]['count'] = 2;
// 		$group[1]['bpi_id'] = 2;
// 		$group[1]['ic_id'] = 1;
// 		$group[1]['bpi_category'] = '甜點';
// 		$group[1]['im_id'] = 1;
// 		$group[1]['bpi_name'] = '養生桂圓蛋糕';
// 		$group[1]['bpi_flavor'] = '原味';
// 		$group[1]['bpi_sprice'] = 120;		
// 		$group[1]['count'] = 0;
// 		$group[2]['bpi_id'] = 3;
// 		$group[2]['ic_id'] = 2;
// 		$group[2]['bpi_category'] = '麵包';
// 		$group[2]['im_id'] = 1;
// 		$group[2]['bpi_name'] = '養生桂圓蛋糕';
// 		$group[2]['bpi_flavor'] = '大蒜';
// 		$group[2]['bpi_sprice'] = 140;
// 		$group[2]['count'] = 1;
		
// 		$group_json = json_encode($group);
// 		Debug::dump($group_json);
		
		try{
			$mm_id = $query['mm_id'];
			$access_token = $query['access_token'];
			$member = new Member();
			if( !$member->InternalCheckLogin($access_token) ){
				return array('success'=>false , 'msg'=> '未通過登入認證，請重新登入!' );
			}
			$select = $this->db->getSql()->select();
			$select->join('member_reward_point','member_reward_point.om_id = order_main.om_id',array('mrp_now_amount'));		
			$select->where('order_main.mm_id='.$mm_id);				
			$select->order('order_main.om_created DESC');
			$result_row = array();
			foreach ( $this->db->selectWith($select)->toArray() as $value){
				$output = array();
				$output['om_created'] = substr(str_replace('-', '/', $value['om_created']),0,-9);
				$output['om_internal_id'] = $value['om_internal_id'];
				$output['om_id'] = $value['om_id'];
				$output['om_status'] = $value['om_status'];
				$output['om_total'] = $value['om_total'];
				$output['om_use_point'] = $value['om_use_point'];
				$output['om_get_point'] = $value['om_get_point'];
				$output['mrp_now_amount'] = $value['mrp_now_amount'];
				array_push($result_row, $output);
			}
			
			$result['success'] = true;
			
			$member_point_db = new MemberPointTable();				
			$select = $member_point_db->getSql()->select();
			$select->where('mm_id='.$mm_id);
			$select->where->greaterThanOrEqualTo("mrp_reward_deadline", date('Y-m-d'));
			$select->order('mrp_created ASC');
			$select->columns(array('total'=>new Expression("SUM(`mrp_used_check`)")));			
			$member_last_order = $member_point_db->selectWith($select)->toArray();
			$result['mrp_now_amount'] = $member_last_order[0]['total'];
			
			$result['data'] = $result_row;
			return $result;
		}catch (\Exception $e){
			return array('success'=>false , 'msg'=> $e->getMessage() );
		}
	}
	/*
	 	$group = array();
		$group[0]['id'] = 1;
		$group[0]['name'] = '德記爸爸';
		$group[0]['sub'][0]['im_name'] = '養生桂圓蛋糕';
		$group[0]['sub'][0]['if_name'] = '原味';
		$group[0]['sub'][0]['if_unit_price'] = 120;
		$group[0]['sub'][0]['if_count'] = 2;
		$group[0]['sub'][0]['if_subtotal'] = 240;
		
		$group[0]['sub'][1]['im_name'] = '銅鑼燒';
		$group[0]['sub'][1]['if_name'] = '辣味';
		$group[0]['sub'][1]['if_unit_price'] = 150;
		$group[0]['sub'][1]['if_count'] = 3;
		$group[0]['sub'][1]['if_subtotal'] = 450;
		
		$group[1]['id'] = 2;
		$group[1]['name'] = '德記媽媽';
		$group[1]['sub'][0]['im_name'] = '養生桂圓蛋糕';
		$group[1]['sub'][0]['if_name'] = '原味';
		$group[1]['sub'][0]['if_unit_price'] = 120;
		$group[1]['sub'][0]['if_count'] = 2;
		$group[1]['sub'][0]['if_subtotal'] = 240;
		
		$group_json = json_encode($group);
		Debug::dump($group_json);
	*/
	public function insert($data,$server_url){	
		try {		
			$item_flavor_db = new ItemFlavorTable();
			$item_main_db = new ItemMainTable();
			$sv = new SystemVariable();
			$sv_hypothermia_shipping_fee = $sv->GetValueByKey('hypothermia_shipping_fee');
			$sv_room_temperature_shipping_fee = $sv->GetValueByKey('room_temperature_shipping_fee');
			$sv_less_one_box_base_calculation_price = $sv->GetValueByKey('less_one_box_base_calculation_price');
			$sv_less_one_box_base_calculation_lower_price = $sv->GetValueByKey('less_one_box_base_calculation_lower_price');
			$sv_less_one_box_base_calculation_upper_price = $sv->GetValueByKey('less_one_box_base_calculation_upper_price');		
				
			$data['om_content_json'] = json_decode($data['om_content_json']);
			$data['om_subtotal'] = 0;
			$data['om_freight_fee'] = 0;
			$data['om_subtotal_add_fee'] = 0;
			$data['om_total'] = 0;
			$data['om_get_point'] = 0;
			$freight_fee_delivery_method = 0;
			$freight_fee_unfull_tmp = 0;
			$data['om_full_box'] = 0;
			$data['om_unfull_box'] = 0;
			foreach ($data['om_content_json'] as $items){
				//if_subtotal
				$select = $item_flavor_db->getSql()->select();
				$select->join('item_main','item_main.im_id = item_flavor.im_id',array('im_box_number','im_delivery_method','im_name'));				
				$select->where('item_flavor.if_id='.$items->if_id );
				$item_flavor = $item_flavor_db->selectWith($select)->toArray();
				if($item_flavor[0]['im_delivery_method']==1){ 
					$freight_fee_delivery_method = 1;
				}
				$data['om_full_box'] += (int)((int)$items->if_count / (int)$item_flavor[0]['im_box_number']);
				$freight_fee_unfull_tmp += ((int)$items->if_count % (int)$item_flavor[0]['im_box_number']) * (int)$item_flavor[0]['if_unit_price'];
				
				$items->if_cover = $server_url.$_SERVER['REDIRECT_BASE'].'images/item_flavor_cover/'.$item_flavor[0]['if_cover'];
				$items->im_name = $item_flavor[0]['im_name'];
				$items->if_name = $item_flavor[0]['if_name'];
				$items->if_unit_price = $item_flavor[0]['if_unit_price'];
				$items->if_subtotal = (int)$item_flavor[0]['if_unit_price'] * (int)$items->if_count;
				
				$data['om_subtotal'] += $items->if_subtotal;
			}
			$data['om_full_box'] += (int)((int)$freight_fee_unfull_tmp / (int)$sv_less_one_box_base_calculation_price);
			$freight_fee_unfull_tmp = (int)$freight_fee_unfull_tmp % (int)$sv_less_one_box_base_calculation_price;
			if($freight_fee_unfull_tmp>=50 && $freight_fee_unfull_tmp<=1750){
				$data['om_unfull_box'] = 1;
				$data['om_freight_fee'] = $freight_fee_delivery_method == 1 ? $sv_hypothermia_shipping_fee : $sv_room_temperature_shipping_fee; 
			}
			if($freight_fee_unfull_tmp>1750){
				$data['om_full_box'] ++;
			}
			$data['om_subtotal_add_fee'] = $data['om_subtotal']+$data['om_freight_fee'];
			$data['om_total'] = $data['om_subtotal_add_fee'];
			$data['om_get_point'] = (int)($data['om_total'] * 0.03);
			
			//member_login
			if(!empty($data['mm_id'])){
				$member = new Member();
				if(empty($data['access_token'])){
					return array('success'=>false , 'msg'=> '未輸入認證碼!' );
				}
				if( !$member->InternalCheckLogin($data['access_token']) ){
					return array('success'=>false , 'msg'=> '未通過登入認證，請重新登入!' );
				}
				$member_point_db = new MemberPointTable();
				$select = $member_point_db->getSql()->select();
				$select->where('mm_id='.$data['mm_id']);
				$select->where->greaterThanOrEqualTo("mrp_reward_deadline", date('Y-m-d'));
				$select->order('mrp_created ASC');
				$select->columns(array('mrp_id','mrp_used_check'));
				$member_last_order = $member_point_db->selectWith($select)->toArray();
				$member_last_amount = 0;
				foreach( $member_last_order as $value){
					$member_last_amount += $value['mrp_used_check'];
				}
				$data['mrp_last_amount'] = $member_last_amount;
				
				if(!empty($data['om_want_use_point'])){
					$data['om_use_point'] = $data['om_want_use_point'] > $member_last_amount ? $member_last_amount : $data['om_want_use_point'];
					$record_want_use_point = $data['om_use_point'];
					foreach( $member_last_order as $value){
						if( $value['mrp_used_check'] >= $record_want_use_point ){
							$value['mrp_used_check'] -= $record_want_use_point ;
							$record_want_use_point = 0;
						}else{
							$record_want_use_point -= $value['mrp_used_check'];
							$value['mrp_used_check'] = 0;
						}
						$member_point_db->update($value , array('mrp_id'=>$value['mrp_id']));						
						if($record_want_use_point == 0) break;
					}
 					$data['om_total'] -= $data['om_use_point'];	
				}else{
					$data['om_want_use_point']= 0;
					$data['om_use_point'] = 0;
				}
			}
			$data['om_content_json'] = json_encode($data['om_content_json']);
			
			//step4 create order 			
			if($data['step']==4){
				$data_order = $data;
				unset($data_order['step']);
				unset($data_order['om_subtotal_add_fee']);
				if( !empty($data['mm_id']) ){
					$mrp_last_amount = (int)$data_order['mrp_last_amount'];
				}
				unset($data_order['mrp_last_amount']);
				unset($data_order['om_want_use_point']);
				unset($data_order['access_token']);
								
				$data_order['om_internal_id'] = '';
				$select = $this->db->getSql()->select();
				$select->where('date(`om_created`) ='.date('Ymd'));
				$select->order('om_created DESC');
				$order_number = $this->db->selectWith($select)->toArray();
				if( !empty($order_number)){
					$data_order['om_internal_id'] = 'TG'.(string)((int)(substr($order_number[0]['om_internal_id'],2,12))+1);
				}else{
					$data_order['om_internal_id'] = 'TG'.(string)(date('Ymd').'0001');
				}
				$data_order['om_created'] = date('Y-m-d H:i:s');
				$data_order['om_payment_status'] = 2;
				$data_order['om_status'] = 1;
				$this->db->insert($data_order);
				$data['om_internal_id'] = $data_order['om_internal_id'];
				$data['om_id'] = $this->db->getLastInsertValue() ;
				$data['om_content_json'] = json_decode($data['om_content_json']);
				
				//create member reward point for new order 
				if(!empty($data['mm_id'])){
					$member_point_db = new MemberPointTable();
					$data_mpr = array();
					$data_mpr['mm_id'] = $data['mm_id'];
					$data_mpr['om_id'] = $data['om_id'];
					$data_mpr['mrp_last_amount'] = $mrp_last_amount;
					$data_mpr['mrp_use_reward'] = (int)$data['om_use_point'];
					$data_mpr['mrp_get_reward'] = (int)$data['om_get_point'];
					$data_mpr['mrp_used_check'] = $data_mpr['mrp_get_reward'];
					$data_mpr['mrp_now_amount'] = $data_mpr['mrp_last_amount'] - $data_mpr['mrp_use_reward'] + $data_mpr['mrp_get_reward'];				
					$data['mrp_now_amount'] = $data_mpr['mrp_now_amount'];
					
					$date = new \DateTime(date('Y-m-d'));
					$date->add(new \DateInterval('P1Y'));
					$data_mpr['mrp_reward_deadline'] = $date->format('Y-m-d');
					
					$data_mpr['mrp_created'] = date('Y-m-d H:i:s');
					$member_point_db->insert($data_mpr);
					$data['mrp_id'] = $member_point_db->getLastInsertValue() ;
				}
			}
			return array('success'=>true , 'data'=> $data);
		}catch (\Exception $e){
			return array('success'=>false , 'msg'=> $e->getMessage() );
		}
	}
}
?>