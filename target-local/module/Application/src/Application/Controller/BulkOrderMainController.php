<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel ;
use Application\Model\Tool\InputCheck ;
use Application\Model\BulkOrder;

class BulkOrderMainController extends AbstractRestfulController
{
    //resource
    //post
    public function create($data){
    	$response = $this->getResponse();
    	$response->setStatusCode(200);
    	if( ! InputCheck::checkRequire(array('cm_id', 'cmp_id', 'bpom_delivery_year', 'bpom_delivery_month', 'bpom_delivery_day', 'bpom_delivery_hour','bpom_subtotal', 'bpom_shipping_fee', 'bpom_total'),$data) ){
    		return new JsonModel(array('success'=>false ,'msg'=>'遺漏參數'));
    	}
    	$db = new BulkOrder();
    	return new JsonModel($db->insert($data));
    }  
    public function getList(){
    	$response = $this->getResponse();
    	$response->setStatusCode(200);
    	$db = new BulkOrder();
    	$query = $this->params()->fromQuery();
    	return new JsonModel($db->selectAll($query));
    } 
    //entity
    //get 
    public function get($bpom_order_number){
        $response = $this->getResponse();
        $response->setStatusCode(200);   
        $db = new BulkOrder();
        return new JsonModel($db->get($bpom_order_number,$this->params()->fromQuery()));
    }  

    public function delete($cm_id){
    	$response = $this->getResponse();
    	$response->setStatusCode(200);
    	$db = new BulkOrder();
    	return new JsonModel($db->date_array($cm_id));
    }
    public function options(){
        $response = $this->getResponse();
        $response->getHeaders()->addHeaderLine('Allow','GET,POST,PUT,DELETE');
        return $response;
    }    
}
?>