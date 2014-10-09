<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel ;
use Application\Model\ItemMain;

class ItemMainController extends AbstractRestfulController
{
	public function getList(){
		$response = $this->getResponse();
		$response->setStatusCode(200);
		$db = new ItemMain();
		return new JsonModel($db->selectAll($this->params()->fromQuery()));
	}
	public function get($id){
		$response = $this->getResponse();
		$response->setStatusCode(200);
		$db = new ItemMain();
		return new JsonModel($db->get($id));
	}
}
?>