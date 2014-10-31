<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel ;
use Application\Model\ContactUs;
use Application\Model\Tool\InputCheck;

class ContactUsController extends AbstractRestfulController
{
    //post
    public function create($data){
    	$response = $this->getResponse();
    	$response->setStatusCode(200);
    	if( ! InputCheck::checkRequire(array('name', 'phone', 'mail','content','check','re_check'),$data) ){
    		return new JsonModel(array('success'=>false ,'msg'=>'遺漏參數'));
    	}
    	$contact = new ContactUs();
    	return new JsonModel($contact->insert($data));
    }   
	public function options(){
		$response = $this->getResponse();
		$response->getHeaders()->addHeaderLine('Allow','POST');
		return $response;
	}
}
?>