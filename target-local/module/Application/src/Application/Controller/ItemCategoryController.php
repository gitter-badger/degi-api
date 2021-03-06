<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel ;
use Application\Model\ItemCategory;

class ItemCategoryController extends AbstractRestfulController
{
	public function getList(){
		$response = $this->getResponse();
		$response->setStatusCode(200);
		$db = new ItemCategory();
		return new JsonModel($db->selectAll($this->params()->fromQuery()));
	}
	public function options(){
		$response = $this->getResponse();
		$response->getHeaders()->addHeaderLine('Allow','GET');
		return $response;
	}
}
?>