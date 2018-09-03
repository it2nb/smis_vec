<?php
class siccsms
{
	private $sms_user="";//username สำหรับ sms
	private $sms_pass="";//password สำหรับ sms
	private $sms_sender="";//ชื่อผู้ส่ง sms
	public $sms_from="จาก วก.สอง";//ชื่อแนบท้ายข้อความ SMS
	private $API_url="http://smsmkt.piesoft.net:8999/SMSLink/SendMsg/index.php";
	private $getcreditAPI_url="http://smsmkt.piesoft.net:8999/SMSLink/GetCredit/index.php";
    
	public function sendsms($phone,$txt){
		$txt=iconv("UTF-8","WINDOWS-874",$txt);
		$parameter="User=$this->sms_user&Password=$this->sms_pass&Msnlist=$phone&Msg=$txt&Sender=$this->sms_sender";
	
		$ch=curl_init();
		curl_setopt($ch,CURLOPT_URL,$this->API_url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch,CURLOPT_POST,1);
		curl_setopt($ch,CURLOPT_POSTFIELDS,$parameter);
	
		$result = curl_exec($ch);
		curl_close($ch);
		return $result;
	}
    public function getCredit(){
        $parameter="User=$this->sms_user&Password=$this->sms_pass";
        $ch=curl_init();
        curl_setopt($ch,CURLOPT_URL,$this->getcreditAPI_url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$parameter);
    
        $result = curl_exec($ch);
        curl_close($ch);
        //list($status,$result) = split(',',$result);
        list($status,$detail,$result) = split('=',$result);
        return $result;
    }
}
?>