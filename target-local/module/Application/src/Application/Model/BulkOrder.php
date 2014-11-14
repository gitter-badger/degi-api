<?php
namespace Application\Model;

use Application\Model\Table\BulkOrderMainTable;
use Zend\Db\Sql\Expression;
use Application\Model\Table\BulkItemTable;
use Zend\Debug\Debug;

class BulkOrder{
	
	public $db = null ;
	public function __construct(){
		$this->db = new BulkOrderMainTable();
	}
	public function get($bpom_order_number,$query){//query{access_token}
		try {
			$member = new CompanyMember();
			if( !$member->InternalCheckLogin($query['access_token']) ){
				return array('success'=>false , 'msg'=> '未通過登入認證，請重新登入!' );
			}
			Debug::dump($bpom_order_number);
   			$select = $this->db->getSql()->select();
   			$select->join('company_member_point','company_member_point.cmp_id = bulk_purchase_order_main.cmp_id',array('cmp_name','cmp_address'));   			
        	$select->where('bulk_purchase_order_main.bpom_order_number='.$bpom_order_number);
   			$select->columns(array('bpom_order_number','bpom_content_json','bpom_delivery_year', 'bpom_delivery_month', 'bpom_delivery_day', 'bpom_delivery_hour','bpom_subtotal', 'bpom_shipping_fee','bpom_total','bpom_status'));
        	$result_row = $this->db->selectWith($select)->toArray();  
        	$result['success'] = true ;
   			$result['rows'] = $result_row;
   			
   			return $result;
        }catch (\Exception $e){
            return array('success'=>false , 'msg'=> $e->getMessage() );
        }
	}
	public function selectAll($query){
		try{
			$cm_id = $query['cm_id'];
			$query_y = $query['year'];
			$query_m = $query['month'];
			
			$member = new CompanyMember();
			if( !$member->InternalCheckLogin($query['access_token']) ){
				return array('success'=>false , 'msg'=> '未通過登入認證，請重新登入!' );
			}
			
			$select = $this->db->getSql()->select();
			$select->join('company_member_point','company_member_point.cmp_id = bulk_purchase_order_main.cmp_id',array('cmp_name'));		
			$select->where('bulk_purchase_order_main.cm_id='.$cm_id);
			$select->where('YEAR(bpom_created)='.$query_y);
			$select->where('MONTH(bpom_created)='.$query_m);
			$select->order('bpom_created DESC');
			//$select->columns(array('bpom_order_number','bpom_delivery_year', 'bpom_delivery_month', 'bpom_delivery_day', 'bpom_delivery_hour','bpom_subtotal', 'bpom_shipping_fee', 'bpom_total'));
			$result_row = array();
			foreach ( $this->db->selectWith($select)->toArray() as $value){
				$output = array();
				$output['bpom_order_number'] = $value['bpom_order_number'];
				$output['bpom_created_time'] = substr(str_replace('-', '/', $value['bpom_created']),0,-3);
				$output['bpom_delivery_time'] = $value['bpom_delivery_year'].'/'.$value['bpom_delivery_month'].'/'.$value['bpom_delivery_day'].' '.$value['bpom_delivery_hour'];
				$output['cmp_name'] = $value['cmp_name'];
				$output['bpom_subtotal'] = $value['bpom_subtotal'];
				$output['bpom_shipping_fee'] = $value['bpom_shipping_fee'];
				$output['bpom_status'] = $value['bpom_status'];
				array_push($result_row, $output);
			}
			$result['success'] = true;
			$result['rows'] = $result_row;
			return $result;
		}catch (\Exception $e){
			return array('success'=>false , 'msg'=> $e->getMessage() );
		}
	}
	public function insert($data){
		
		try {		
			$member = new CompanyMember();
			if( !$member->InternalCheckLogin($data['access_token']) ){
				return array('success'=>false , 'msg'=> '未通過登入認證，請重新登入!' );
			}

			//"ic_id","bpi_category","im_id","bpi_name","bpi_flavor","bpi_sprice"
			$bulk_item_db = new BulkItemTable();
			$data['bpom_content_json'] = json_decode($data['bpom_content_json']);
			$bpom_subtotal_check = 0;
			foreach ($data['bpom_content_json'] as $items){
				$select = $bulk_item_db->getSql()->select();
				$select->where('bpi_id='.$items->bpi_id);
				$result_row = $bulk_item_db->selectWith($select)->toArray();
				$bpom_subtotal_check += $result_row[0]['bpi_sprice'] * $items->count;
			}
			$data['bpom_content_json'] = json_encode($data['bpom_content_json']);
			$data['bpom_subtotal'] = $bpom_subtotal_check;
			$data['bpom_total'] = $data['bpom_subtotal'] + $data['bpom_shipping_fee'];
			$select = $this->db->getSql()->select();
			$select->where('date(`bpom_created`) ='.date('Ymd'));
			$select->order('bpom_created DESC');
			$order_number = $this->db->selectWith($select)->toArray();
			//Debug::dump($order_number);
			if( !empty($order_number)){
				$data['bpom_order_number'] = (int)($order_number[0]['bpom_order_number'])+1;
			}else{
				$data['bpom_order_number'] = (int)(date('Ymd').'001');
			}
			$data['bpom_created']=date('Y-m-d H:i:s');
			unset($data['access_token']);
			$data['bpom_status'] = 1; 
			$this->db->insert($data);				
			$data['bpom_id'] = $this->db->getLastInsertValue() ;
			$data['bpom_content_json'] = json_decode($data['bpom_content_json']);
				
			return array('success'=>true , 'data'=> $data);
		}catch (\Exception $e){
			return array('success'=>false , 'msg'=> $e->getMessage() );
		}
	}
	public function date_array($cm_id){
		try {
			$select = $this->db->getSql()->select();
			$select->columns(array('year'=> new Expression('year(bpom_created)'), 'month'=> new Expression('month(bpom_created)')));
			$select->group(array('year'=> new Expression('year(bpom_created)'), 'month'=> new Expression('month(bpom_created)')));
			$select->order('bpom_created DESC');
			$order_number = $this->db->selectWith($select)->toArray();
								
 			$data = array();
			foreach( $order_number as $value ){
				array_push($data, $value);
			}
			return array('success'=>true , 'data'=> $data);
		}catch (\Exception $e){
			return array('success'=>false , 'msg'=> $e->getMessage() );
		}
	}
}
?>