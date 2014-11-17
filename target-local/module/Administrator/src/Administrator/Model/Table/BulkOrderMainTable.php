<?php
namespace Administrator\Model\Table;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;

class BulkOrderMainTable  extends TableGateway
{
    protected $table = 'bulk_purchase_order_main';
    public function __construct(){
        $this->adapter = GlobalAdapterFeature::getStaticAdapter();
        $this->initialize();
    }
}
?>