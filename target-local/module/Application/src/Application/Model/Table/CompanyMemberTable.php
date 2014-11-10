<?php
namespace Application\Model\Table;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;

class CompanyMemberTable  extends TableGateway
{
    protected $table = 'company_member';
    public function __construct(){
        $this->adapter = GlobalAdapterFeature::getStaticAdapter();
        $this->initialize();
    }
}
?>