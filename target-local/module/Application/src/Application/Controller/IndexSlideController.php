<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel ;
use Application\Model\IndexSlide;

class IndexSlideController extends AbstractRestfulController
{
	public function getList(){
		$response = $this->getResponse();
		$response->setStatusCode(200);
		$db = new IndexSlide();
		$server_url = $this->getRequest()->getUri()->getScheme() . '://' . $this->getRequest()->getUri()->getHost();
		return new JsonModel($db->selectAll($server_url,$this->params()->fromQuery()));
	}
	public function options(){
		$response = $this->getResponse();
		$response->getHeaders()->addHeaderLine('Allow','GET');
		return $response;
	}
}
?>