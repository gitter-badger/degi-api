<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel ;
use Application\Model\CompanyMemberPoint;

class CompanyMemberPointController extends AbstractRestfulController
{
	public function get($id){
		$response = $this->getResponse();
		$response->setStatusCode(200);
		$db = new CompanyMemberPoint();
		return new JsonModel($db->get($id,$this->params()->fromQuery()));
	}
	public function options(){
		$response = $this->getResponse();
		$response->getHeaders()->addHeaderLine('Allow','GET');
		return $response;
	}
}
?>