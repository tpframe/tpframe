<?php
namespace tpfcore\util;
use tpfcore\mail\PHPMailer;
class MailHandle{
	private $host;
	private $port;
	private $username;
	private $password;
	public function __construct($host="",$port=0,$username="",$password=""){
		$this->host=$host;
		$this->port=$port;
		$this->username=$username;
		$this->password=$password;
	}
	/**
	 * 系统邮件发送函数
	 * @param string $tomail 接收邮件者邮箱
	 * @param string $name 接收邮件者名称
	 * @param string $subject 邮件主题
	 * @param string $body 邮件内容
	 * @param string $attachment 附件列表
	 * @param boolean $is_ssl_validate 是否ssl安全验证 默认false
	 * @return boolean
	 * @author yaoyihong <510974211@qq.com>
	 */
	function sendMail($tomail, $toname, $subject = '', $body = '', $attachment = null , $is_ssl_validate = false) {
	    $mail = new PHPMailer();           //实例化PHPMailer对象
	    $mail->CharSet = 'UTF-8';           //设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码
	    $mail->IsSMTP();                    // 设定使用SMTP服务
	    $mail->SMTPDebug = 0;               // SMTP调试功能 0=关闭 1 = 错误和消息 2 = 消息
	    $mail->SMTPAuth = true;             // 启用 SMTP 验证功能
	    if($is_ssl_validate) $mail->SMTPSecure = 'ssl';          // 使用安全协议
	    $mail->Host = $this->host; 			// SMTP 服务器		smtp.exmail.qq.com
	    $mail->Port = $this->port;                  // SMTP服务器的端口号		465		发送邮件服务器：smtp.exmail.qq.com (端口 25)，使用SSL，端口号465或587
	    $mail->Username = $this->username;    // SMTP服务器用户名
	    $mail->Password = $this->password;     // SMTP服务器密码
	    $mail->SetFrom($this->username, 'tpframe 官网(www.tpframe.com)');
	    $replyEmail = $this->username;      //留空则为发件人EMAIL
	    $replyName = '';                    //回复名称（留空则为发件人名称）
	    $mail->AddReplyTo($replyEmail, $replyName);
	    $mail->Subject = $subject;
	    $mail->MsgHTML($body);
	    $mail->AddAddress($tomail, $toname);
	    if (is_array($attachment)) { // 添加附件
	        foreach ($attachment as $file) {
	            is_file($file) && $mail->AddAttachment($file);
	        }
	    }
	    return $mail->Send() ? true : $mail->ErrorInfo;
	}
	/**
     * 测试发送邮件
     * @param
     * @author yaoyihong <510974211@qq.com>
     * @return mixed
     */
    public function email() {
        $toemail='static7@qq.com';
        $name='static7';
        $subject='QQ邮件发送测试';
        $content='恭喜你，邮件测试成功。';
        dump($this->send_mail($toemail,$name,$subject,$content));
    }
}
?>