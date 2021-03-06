<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel ;
use Application\Model\StoreLocation;

class StoreLocationController extends AbstractRestfulController
{
	public function getList(){
		$response = $this->getResponse();
		$response->setStatusCode(200);
		$db = new StoreLocation();
		$server_url = $this->getRequest()->getUri()->getScheme() . '://' . $this->getRequest()->getUri()->getHost();
		return new JsonModel($db->selectAll($server_url));
	}
	public function options(){
		$response = $this->getResponse();
		$response->getHeaders()->addHeaderLine('Allow','GET');
		return $response;
	}
}
?>