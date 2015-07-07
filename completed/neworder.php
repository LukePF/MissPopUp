<?php
//session_id($_GET['sn']); 


session_start();


 /* if(isset($_POST['code'])) {  
    if($_POST['code'] == $_SESSION['code']){
         
    }else{  
         $_SESSION['code'] =$_POST['code']; 
    }  */    //check resubmiting

require_once('./config.php');
  require 'phpmailer/class.phpmailer.php';
  $token = $_POST['stripeToken'];

echo $_POST["email1"];

  echo '<h1>Successfully charged !</h1>';
  $mysql_server_name="localhost:3306"; 
    $mysql_username="lemonk_uta"; 
    $mysql_password="T1a2m3"; 
    $mysql_database="lemonk_beta"; 
	$e_time = time()+60*60*24;
	
	$guest = $_POST['email1'];

		//$guest = $_SESSION['username'];
	$datet = $_POST["date"];
	$email1 = $_POST["email1"];
	    $event_name = $_POST["item_name"];  	
		$num = $_POST["quantity"];
		$price = $num * $_POST["price"];
  		$hoster = $_POST["owner"];
		$price_sent = $price * 100;
		$conn=mysql_connect($mysql_server_name,$mysql_username, $mysql_password);
		$id = $_POST['id1'];
		$strsql2 = "select checked from user where username = '$guest'";
					$result2=mysql_db_query($mysql_database, $strsql2, $conn);
      $row2=mysql_fetch_row($result2);
	  
	  $strsql3 = "select Location,table_left from popup where PopUpid = '$id'";
	  $result3=mysql_db_query($mysql_database, $strsql3, $conn);
      $row3=mysql_fetch_row($result3);
	  
	  $table_l = $row3[1];
	  $strsql6 = "select email from user where username = '$hoster'";
	  $result6=mysql_db_query($mysql_database, $strsql6, $conn);
      $row6=mysql_fetch_row($result6);
	  $url  =  "http://beta.misspopup.com/Lu/introduction.php?id=".$id."" ;    
	  
	  
	  
	 if(1){
		 if($event_name == "" || $num == "" || $price == ""||$price <= 0 ||$num > $table_l)  
        {  
		echo "event_name=".$event_name."  num = ".$num." price = ".$price." host =".$hoster."table= ".$table_l." id = ".$id;
            echo "<script>alert('Something wrong with the data!');</script>"   ;

echo " <   script   language = 'javascript'    
  
type = 'text/javascript' > ";    
  
echo " window.location.href = '$url' ";    
  
echo " <  /script > ";    ;  
			exit;}
	else
	{
		try {
$charge = \Stripe\Charge::create(array(
  "amount" => $price_sent, 
  "currency" => "EUR",
  "source" => $token,
  "description" => "$email1 for $event_name",
  "receipt_email" => "$email1")
);
} catch(\Stripe\Error\Card $e) {
 
}
		
		
		
		
		$sql_insert="INSERT INTO event(guest,Create_Time,hostname,event_name,price) values('".mysql_real_escape_string($guest)."','".mysql_real_escape_string($e_time)."','".mysql_real_escape_string($hoster)."','".mysql_real_escape_string($event_name)."','".mysql_real_escape_string($price)."')";
		$res_insert = mysql_query($sql_insert);  
		
		 if($res_insert)  
                    {  
					/*$strsql = "select email from user where username = '$guest'";
					$result1=mysql_db_query($mysql_database, $strsql, $conn);
					
      $row1=mysql_fetch_row($result1);*/
					
$table_l = $table_l - $num;
$sql_insert2="UPDATE popup SET table_left =".mysql_real_escape_string($table_l)." WHERE Popupid = '$id'";
$result7=mysql_db_query($mysql_database, $sql_insert2, $conn);

$subject1 = 'Reservation Confirmation';
$email1 = '<div id="mailContentContainer" class="qmbox qm_con_body_content">Dear '.$guest.'<br/><br/>Thank you very much for booking with us. Here we provide you with the <br/>following information:<br/><br/>&nbsp;&nbsp;&nbsp;&nbsp; '.$event_name.'<br/>&nbsp;&nbsp;&nbsp;&nbsp; '.$row3[0].', at '.date("d.m.Y, H:i",$datet).'<br/><br/>&nbsp;&nbsp;&nbsp;&nbsp;<br/>
		 <div class="moz-signature">-- <br  />
        <big><big><b><font face="Brain Flower"><big>Best Regards<br  />
                  The MissPopUp Team</big></font></b></big></big><br  />
        <img src="images/fd4958133a6b6399e1173da74d036e30.png" border="0" height="145" width="145"  /></div>
      <br  />
    </div>
    <br  />';
$subject2 = 'Host notification of booking';
$email2 = ' <font face="Helvetica, Arial, sans-serif">Dear '.$hoster.'<br  />
        <br  />
        We have just received a booking from '.$guest.' to '.$event_name.' for '.$num.' people <br  />
        <br  />
        There are now '.$table_l.' places left for the event.<br  />
        <br  />
        Thank you very much for your patience. <br  />
        Enjoy The MissPopUp Experience!</font><br  />
      <div class="moz-signature">-- <br  />
        <big><big><b><font face="Brain Flower"><big>Best Regards<br  />
                  The MissPopUp Team</big></font></b></big></big><br  />
        <img src="images/fd4958133a6b6399e1173da74d036e30.png" border="0" height="145" width="145"  /></div>
      <br  />
    </div>';
	
# smtp服务器地址, 如smtp.qq.com
$host = 'mail.misspopup.com';

# 发件人名称
$fromname = 'noreply@misspopup.com';

# 发件人地址和收件人地址填你的邮箱
$from = 'noreply@misspopup.com';
$to = $guest;
$to_host = $row6[0];
//$from;

# 你邮箱账号
$username1 = $from;
$passwd = 'turpa0';

$mailer = new PHPMailer(true);
$mailer->IsHTML(true);
$mailer->IsSMTP(true);
#$mailer->SMTPDebug = true;
$mailer->CharSet = 'UTF-8';
$mailer->Encoding = 'base64';
$mailer->FromName = $fromname;
$mailer->Host = $host;
$mailer->AddAddress($to);
$mailer->From = $from;
$mailer->Subject = $subject1;
$mailer->MsgHTML($email1);
$mailer->SMTPAuth = true;
$mailer->Username = $username1;
$mailer->Password = $passwd;
try{
    $mailer->Send();
} catch (phpmailerException $e) {
    // 发送失败, 处理你的异常
}
$mailer->AddAddress($to_host);
$mailer->Subject = $subject2;
$mailer->MsgHTML($email2);
try{
    $mailer->Send();
} catch (phpmailerException $e) {
    // 发送失败, 处理你的异常
}
 mysql_close($conn);  
                       
					}
		}
		 echo "<script>alert('Your order has been paid successfully!'); </script>
		 ";
		 echo " <   script   language = 'javascript'    
  
type = 'text/javascript' > ";    
  
echo " window.location.href = 'http://beta.misspopup.com/Lu/index.php' ";    
  
echo " <  /script > ";      
	 }
	 else 
	 {echo "<script>alert('Your account has not been verified'); history.go(-1);</script>"; exit;}
  
  

  
 ?>
