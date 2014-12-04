<?php
namespace Administrator\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel ;
use Administrator\Model\Tool\InputCheck ;
use Administrator\Model\ItemCategory;

class ItemCategoryController extends AbstractRestfulController
{
    //resource
    //post
    public function create($data){
    	$response = $this->getResponse();
    	$response->setStatusCode(200);
    	
    	if( ! InputCheck::checkRequire(array('ic_type', 'ic_name', 'ic_seq', 'ic_status'),$data) ){
    		return new JsonModel(array('success'=>false ,'msg'=>'遺漏參數'));
    	}
    	
    	$ic = new ItemCategory();    	
    	return new JsonModel($ic->insert($data));
    }
    
    //get
    public function getList(){
        $response = $this->getResponse();
        $response->setStatusCode(200);
        
        $ic = new ItemCategory();
        return new JsonModel($ic->selectAll($this->params()->fromQuery()));
    }
     
    //entity    
    //get 
    public function get($id){
        $response = $this->getResponse();
        $response->setStatusCode(200);
        
        $ic = new ItemCategory();

        return new JsonModel($ic->get($id));
    }
    
    //put
    public function update($id , $data){
        $response = $this->getResponse();
        $response->setStatusCode(200);
        
        $ic = new ItemCategory();
        
        return new JsonModel($ic->update($data,$id) );
    }
    
    //delete
    public function delete($id){
        $response = $this->getResponse();
        $response->setStatusCode(200);
        
        $ic = new ItemCategory();

        return new JsonModel($ic->delete($id));
    }
    
    public function options(){
        $response = $this->getResponse();
        $response->getHeaders()->addHeaderLine('Allow','GET,POST,PUT,DELETE');
        return $response;
    }   
}
?>