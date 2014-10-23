<?php 
namespace Application\Model;

use Zend\Mail\Message ;
use Zend\Mail\Transport\Sendmail ;

class MessagePlugin {
    
	public function sendmail($to,$subject,$body,$bcc = true,$file = false){
        $mail = new Message();
        $mail->setFrom('ausir@finpo.com.tw', 'ausir');
        foreach ($to as $t){
            $mail->addTo($t['to'], $t['name']);
        }
        $mail->setSubject($subject);
        $mail->setBody($body);
        $transport = new Sendmail();
        $transport->send($mail);
        return true ;
    }
}

?>