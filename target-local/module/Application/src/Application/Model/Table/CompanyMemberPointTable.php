<?php
namespace Application\Model\Table;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;

class CompanyMemberPointTable  extends TableGateway
{
    protected $table = 'company_member_point';
    public function __construct(){
        $this->adapter = GlobalAdapterFeature::getStaticAdapter();
        $this->initialize();
    }
}
?>