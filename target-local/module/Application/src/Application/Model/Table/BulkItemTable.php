<?php
namespace Application\Model\Table;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;

class BulkItemTable  extends TableGateway
{
    protected $table = 'bulk_purchase_item';
    public function __construct(){
        $this->adapter = GlobalAdapterFeature::getStaticAdapter();
        $this->initialize();
    }
}
?>