<?php
namespace Application\Model;

use Administrator\Model\Table\SystemVariableTable;
use Zend\Mail\Message ;
use Zend\Mail\Transport\Sendmail ;

class ContactUs{
	
	public function insert($data){
		if( $data['check'] != $data['re_check']){
			return array('success'=>false, 'msg'=>'驗證碼錯誤');
		}
		//send hash mail to member
		$system_db = new SystemVariableTable();
		$sv_email = $system_db->select(array('sv_key'=>'site_email'))->current()->sv_value;
		
		$name = $data['name'];
		$phone = $data['phone'];
		$email = $data['mail'];
		$content = $data['content'];
		
		$subject = '網站留言';
		$body =  '

聯絡姓名：'. $name .'
聯絡電話：'. $phone .'
聯絡信箱：'. $email .'
留言內容：
'. $content .'
	
';	
		$mail = new Message();
        $mail->setFrom('ausir@finpo.com.tw', '得記麵包網站');
        $mail->addTo($sv_email, '得記麵包客服信箱');
        
        $mail->setSubject($subject);
        $mail->setBody($body);
        $transport = new Sendmail();
        $transport->send($mail);
		return array('success'=>true);
    }
}
?>