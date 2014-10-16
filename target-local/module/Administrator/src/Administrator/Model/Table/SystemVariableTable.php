<?php
namespace Administrator\Model\Table;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;

class SystemVariableTable  extends TableGateway
{
    protected $table = 'system_variable';
    public function __construct(){
        $this->adapter = GlobalAdapterFeature::getStaticAdapter();
        $this->initialize();
    }
}
?>