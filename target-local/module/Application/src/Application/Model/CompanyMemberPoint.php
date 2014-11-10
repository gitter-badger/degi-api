<?php
namespace Application\Model;
use Application\Model\Table\CompanyMemberPointTable;
use Application\Model\Table\CompanyMemberTable;
use Application\Model\Table\BulkOrderMainTable;
use Zend\Db\Sql\Expression;

class CompanyMemberPoint{
	public function __construct(){
		$this->db = new CompanyMemberPointTable();
	}
    public function get($id){
   		try {
   			$db_cmp_main = new CompanyMemberTable();
   			$db_bulk_order = new BulkOrderMainTable();
   			
   			$result['success'] = true ;
   			$result['cm_title'] = $db_cmp_main->select(array('cm_id'=>$id))->current()->cm_title;   			
   			$result['cm_consumption_amount'] = $db_cmp_main->select(array('cm_id'=>$id))->current()->cm_consumption_amount;
   			
   			$select = $db_bulk_order->getSql()->select();
   			$select->columns(array('total'=>new Expression("SUM(`bpom_total`)")));
   			$select->where('cm_id='.$id);
   			$result_of_bulk = $db_bulk_order->selectWith($select)->toArray();
   			$result['cm_consumption_amount_current'] = $result_of_bulk[0]['total'];
   			
   			$select = $this->db->getSql()->select();
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