<?php
namespace Application\Model;
use Application\Model\Table\CompanyMemberPointTable;
use Application\Model\Table\CompanyMemberTable;
use Application\Model\Table\BulkOrderMainTable;

class CompanyMemberPoint{
	public function __construct(){
		$this->db = new CompanyMemberPointTable();
	}
    public function get($id,$query){ // query['year'] , query['month']
   		try {
   			$member = new CompanyMember();
   			if( !$member->InternalCheckLogin($query['access_token']) ){
   				return array('success'=>false , 'msg'=> '未通過登入認證，請重新登入!' );
   			}
   			$db_cmp_main = new CompanyMemberTable();
   			$db_bulk_order = new BulkOrderMainTable();
   			
   					
   			$result['success'] = true ;
   			$result['cm_title'] = $db_cmp_main->select(array('cm_id'=>$id))->current()->cm_title;   			
   			$result['cm_consumption_amount'] = $db_cmp_main->select(array('cm_id'=>$id))->current()->cm_consumption_amount;
   			
   			$select = $this->db->getSql()->select();
   			$select->where('cm_id='.$id);
        	$select->columns(array('cmp_id','cm_id','cmp_name','cmp_address','cmp_shipping_fee'));
        	$result_row = $this->db->selectWith($select)->toArray();   			
   			$result['cm_point'] = $result_row;
   			
   			return $result;

        }catch (\Exception $e){
            return array('success'=>false , 'msg'=> $e->getMessage() );
        }
    }
}
?>