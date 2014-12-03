<?php
namespace Administrator\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel ;
use Administrator\Model\CompanyMemberPoint;

class CompanyMemberPointController extends AbstractRestfulController
{
    //resource 
	public function create($data){
		$response = $this->getResponse();
		$response->setStatusCode(200);
		 
		$member = new CompanyMemberPoint();
		 
		return new JsonModel($member->insert($data));
	}
    //get
    public function getList(){
        $response = $this->getResponse();
        $response->setStatusCode(200);

        $member = new CompanyMemberPoint();
        return new JsonModel($member->selectAll($this->params()->fromQuery()));        
    }  
    //entity
    //get 
    public function get($id){
        $response = $this->getResponse();
        $response->setStatusCode(200);
        
        $member = new CompanyMemberPoint();

        return new JsonModel($member->get($id));
    }  
    //put
    public function update($id , $data){
    	$response = $this->getResponse();
    	$response->setStatusCode(200);
    
    	$member = new CompanyMemberPoint();

        return new JsonModel($member->update($data,$id));
    }
    //delete
    public function delete($id){
        $response = $this->getResponse();
        $response->setStatusCode(200);
        
        $member = new CompanyMemberPoint();

        return new JsonModel($member->delete($id));
    } 
    public function options(){
        $response = $this->getResponse();
        $response->getHeaders()->addHeaderLine('Allow','GET,PUT,DELETE,POST');
        return $response;
    }    
}
?>