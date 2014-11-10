<?php
namespace Application\Model;

use Application\Model\Table\BulkOrderMainTable;
use Zend\Db\Sql\Expression;

class BulkOrder{
	
	public $db = null ;
	public function __construct(){
		$this->db = new BulkOrderMainTable();
	}
	public function get($bpom_order_number){
		try {
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
			$data['bpom_content_json'] = $data['sub'];
			unset($data['sub']);
			$data['bpom_status'] = 1; 
			$this->db->insert($data);				
			$data['bpom_id'] = $this->db->getLastInsertValue() ;
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