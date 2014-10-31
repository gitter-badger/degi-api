<?php
namespace Application\Model;
use Application\Model\Table\NewsMainTable;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\DbSelect;

class NewsMain{
	
	public function __construct(){
		$this->db = new NewsMainTable();
	}
    public function selectAll($server_url,$query){
    try {
   			$select = $this->db->getSql()->select();
   			$select->order('nm_publish_date DESC');   	
    		$select->where->lessThanOrEqualTo("nm_publish_date", date('Y-m-d'));  	
//    		$select->where->greaterThan("nm_publish_date", '2014-09-29'	);// 2014-10-31		
	   		$select->columns(array('nm_id','nm_cover','nm_title','nm_body','nm_publish_date'));

   			$paginator = new Paginator(new DbSelect($select, $this->db->adapter));
   			$paginator->setItemCountPerPage($query['limit'])->setCurrentPageNumber($query['page']);
   			$result_row = array();
   			foreach ( $paginator->getCurrentItems()->toArray() as $value ){
   				$value['nm_cover'] = $server_url.$_SERVER['REDIRECT_BASE'].'images/news_main_cover/'.$value['nm_cover'];
           	    array_push($result_row, $value);
   			}
   			$result['success'] = true ;
   			$result['total'] = $paginator->getTotalItemCount();
   			$result['rows'] = $result_row;
   			return $result;

        }catch (\Exception $e){
            return array('success'=>false , 'msg'=> $e->getMessage() );
        }
    }
}
?>