<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel ;
use Application\Model\ItemInfo;

class ItemInfoController extends AbstractRestfulController
{
	public function get($id){
		$response = $this->getResponse();
		$response->setStatusCode(200);
		$db = new ItemInfo();
		return new JsonModel($db->get($id));
	}
}

?>