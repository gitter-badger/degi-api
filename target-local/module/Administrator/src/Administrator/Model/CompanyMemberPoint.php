<?php
namespace Administrator\Model;

use Administrator\Model\Table\CompanyMemberPointTable;

class CompanyMemberPoint{
	public $db = null ;
	public function __construct(){
		$this->db = new CompanyMemberPointTable();
	}
	public function update($data , $id){
		try {
			$this->db->update($data , array('cmp_id'=>$id));
			return array('success'=>true , 'data'=> $data );
		}catch (\Exception $e){
			return array('success'=>false , 'msg'=> $e->getMessage() );
		}
	}
    public function delete($id){
        $this->db->delete('cmp_id =' . (int) $id);
        return array('success'=>true  );
    }
    //cmp_id
    public function get($id){
        return array('success'=>true , 'data'=> $this->db->select(array('cmp_id'=>$id))->current());
    }
    public function insert($data){
    	$data['cmp_created'] = date('Y-m-d H:i:s');
    	$this->db->insert($data);
    	$data['cmp_id'] = $this->db->getLastInsertValue();
    	return array('success'=>true , 'data'=>$data);
    }
    public function selectAll($query){
   	 	try {
    		$select = $this->db->getSql()->select();
    		$select->where->equalTo('cm_id',$query['cm_id']);
    
    		$cmp = $this->db->selectWith($select)->toArray();
            $result['success'] = true;
            $result['rows'] = Json_encode($cmp);
            return $result;
    
    		return $result;
    	}catch (\Exception $e){
    		return array('success'=>false , 'msg'=> $e->getMessage() );
    	}
    }
}
    
?>