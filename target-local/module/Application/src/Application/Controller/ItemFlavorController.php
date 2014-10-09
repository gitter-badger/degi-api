<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel ;
use Application\Model\ItemFlavor;

class ItemFlavorController extends AbstractRestfulController
{
	public function getList(){
		$response = $this->getResponse();
		$response->setStatusCode(200);
		$db = new ItemFlavor();
		return new JsonModel($db->selectAll($this->params()->fromQuery()));
	}
	public function get($id){
		$response = $this->getResponse();
		$response->setStatusCode(200);
		$db = new ItemFlavor();		
		return new JsonModel($db->get($id));
	}
}
?>