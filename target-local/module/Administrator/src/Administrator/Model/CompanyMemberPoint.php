<?php
namespace Administrator\Model;

use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\DbSelect;
use Administrator\Model\Table\CompanyMemberPointTable;
use Zend\Debug\Debug;

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
    public function selectAll($query){ // $query['cm_id']
   	 	try {
    		$select = $this->db->getSql()->select();
    		$select->where->equalTo('cm_id',$query['cm_id']);
    
    		$cmp = $this->db->selectWith($select)->toArray();
    		//Debug::dump($cmp);
    		//Debug::dump(Json_encode($cmp));
//         	foreach ( $this->db->selectWith($select)->toArray() as $value){
// 	        	$value['is_pic'] = $server_url.$_SERVER['REDIRECT_BASE'].'images/index_slide_pic/'.$value['is_pic'];
//         		$value['nm_id'] = $news[0]['nm_id'];
//         		$value['nm_title'] = $news[0]['nm_title'];
//         		$value['nm_cover'] = $server_url.$_SERVER['REDIRECT_BASE'].'images/news_main_cover/'.$news[0]['nm_cover'];
//         		$value['nm_publish_date'] = $news[0]['nm_publish_date'];
// 	        	array_push($result_row, $value);
//         	}
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