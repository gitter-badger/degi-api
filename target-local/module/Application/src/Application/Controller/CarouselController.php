<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel ;
use Application\Model\Carousel;

class CarouselController extends AbstractRestfulController
{
	public function get($id){
		$response = $this->getResponse();
		$response->setStatusCode(200);
		$db = new Carousel();
		$server_url = $this->getRequest()->getUri()->getScheme() . '://' . $this->getRequest()->getUri()->getHost();
		return new JsonModel($db->get($id,$server_url));
	}
	public function options(){
		$response = $this->getResponse();
		$response->getHeaders()->addHeaderLine('Allow','GET');
		return $response;
	}
}
?>