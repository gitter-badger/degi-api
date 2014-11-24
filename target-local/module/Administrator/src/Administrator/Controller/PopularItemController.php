<?php
namespace Administrator\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel ;
use Administrator\Model\Tool\InputCheck ;
use Administrator\Model\PopularItem;
use Zend\Debug\Debug;

class PopularItemController extends AbstractRestfulController
{
    //resource
    //post
    public function create($data){
    	$response = $this->getResponse();
    	$response->setStatusCode(200);
    	 
    	if( ! InputCheck::checkRequire(array('pi_type', 'im_id', 'pi_title', 'pi_description', 'pi_seq'),$data) ){
    		return new JsonModel(array('success'=>false ,'msg'=>'遺漏參數'));
    	}
    	$db = new PopularItem();
    	return new JsonModel($db->insert($data));
    }
    
    //get
    public function getList(){
        $response = $this->getResponse();
        $response->setStatusCode(200);
        
        $db = new PopularItem();
        return new JsonModel($db->selectAll($this->params()->fromQuery()));
    }
     
    //entity    
    //get 
    public function get($id){
        $response = $this->getResponse();
        $response->setStatusCode(200);
        
        $db = new PopularItem();
        return new JsonModel($db->get($id));
    }
    
    //put
    public function update($id , $data){
        $response = $this->getResponse();
        $response->setStatusCode(200);
        
        $db = new PopularItem();   
        return new JsonModel(array('success'=>true , 'data'=> $db->update($data,$id) ));
    }
    
    //delete
    public function delete($id){
        $response = $this->getResponse();
        $response->setStatusCode(200);
        
        $db = new PopularItem();
        return new JsonModel($db->delete($id));
    }
    
    public function options(){
        $response = $this->getResponse();
        $response->getHeaders()->addHeaderLine('Allow','GET,POST,PUT,DELETE');
        return $response;
    }   
}
?>