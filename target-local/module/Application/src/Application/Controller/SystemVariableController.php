<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel ;
use Application\Model\SystemVariable;

class SystemVariableController extends AbstractRestfulController
{
	public function getList(){
		$response = $this->getResponse();
		$response->setStatusCode(200);
		$db = new SystemVariable();
		return new JsonModel($db->selectAll());
	}
	public function options(){
		$response = $this->getResponse();
		$response->getHeaders()->addHeaderLine('Allow','GET');
		return $response;
	}
}
?>