<?php
namespace Application\Model\Table;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;

class ItemFlavorTable  extends TableGateway
{
    protected $table = 'item_flavor';
    public function __construct(){
        $this->adapter = GlobalAdapterFeature::getStaticAdapter();
        $this->initialize();
    }
}
?>