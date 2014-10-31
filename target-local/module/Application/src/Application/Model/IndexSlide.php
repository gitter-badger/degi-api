<?php
namespace Application\Model;
use Application\Model\Table\IndexSlideTable;
use Application\Model\Table\NewsMainTable;

class IndexSlide{
	
	public function __construct(){
		$this->db = new IndexSlideTable();
	}
    public function selectAll($server_url,$query){
    	try{ 
    		$select_nm_db = new NewsMainTable();
    		$select_nm = $select_nm_db->getSql()->select();
    		$select_nm->order('nm_publish_date DESC');
    		$select_nm->limit(1);
    		$news = $select_nm_db->selectWith($select_nm)->toArray();
    		
        	$select = $this->db->getSql()->select();
        	$select->order('is_seq ASC');
        	$select->columns(array('is_id','is_pic','is_url','is_seq'));
        	$result_row = array();
        	foreach ($this->db->selectWith($select)->toArray() as $value){
	        	$value['is_pic'] = $server_url.$_SERVER['REDIRECT_BASE'].'images/index_slide_pic/'.$value['is_pic'];
        		$value['nm_id'] = $news[0]['nm_id'];
        		$value['nm_title'] = $news[0]['nm_title'];
        		$value['nm_cover'] = $server_url.$_SERVER['REDIRECT_BASE'].'images/news_main_cover/'.$news[0]['nm_cover'];
        		$value['nm_publish_date'] = $news[0]['nm_publish_date'];
	        	array_push($result_row, $value);
        	}
            $result['success'] = true;
            $result['rows'] = $result_row;
            return $result;
        }catch (\Exception $e){
        	return array('success'=>false , 'msg'=> $e->getMessage() );
        }
    }
}
?>