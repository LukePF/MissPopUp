<?php
session_start();
    require 'phpmailer/class.phpmailer.php';
  $mysql_server_name="localhost:3306"; 
    $mysql_username="lemonk_uta"; 
    $mysql_password="T1a2m3"; 
    $mysql_database="lemonk_beta"; 
if($_POST["choose"]=="L"){
  if(isset($_POST["submit"]) && $_POST["submit"] == "Login")  
  { 
		/*session_register("name");
		if(isset($_session["nameid"]))
		{
			session_unregister("nameid");}*/
        $user = $_POST["username"];  
        $psw = $_POST["password"];  
        if($user == "" || $psw == "")  
        {  
            echo "<script>alert('Please input your username and password！'); history.go(-1);</script>";  
        }  
        else  
        {  
		$password_hashed = md5($psw);
	
            mysql_connect($mysql_server_name,$mysql_username,$mysql_password);  
            mysql_select_db($mysql_database);  
           // mysql_query("set names 'gbk'");  
            $sql =  "SELECT username,password,checked FROM `user` WHERE `username` = '".mysql_real_escape_string($user)."' AND `password` = '".mysql_real_escape_string($password_hashed)."';";
            $result = mysql_query($sql);  
            $num = mysql_num_rows($result); 
	       echo $user;
           echo $psw;
            if($num)  
            {  
                $row = mysql_fetch_array($result);  //将数据以索引方式储存在数组中  
            //    echo "$row[0] welcome! <br>"; 
			//	$name = mysql_result($result, 0, 'username');	
			$name = $row[0];
			$checked = $row[2];
				$_SESSION['username'] = $name;
				$_SESSION['checked'] = $checked;
				
		if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
		//	echo $_SESSION['username'];
			$sn = session_id(); 
		//	echo $sn;
					echo '<script> window.location.assign("index.php");</script>';	
				//	header("location:index.php");
				} else {
					 echo "<script>alert('Failed to log in!'); history.go(-1);</script>";  
				}


            }  
            else  
            {  
                echo "<script>alert('Username or password incorrect！');history.go(-1);</script>";  
            }  
        }  
	}
    else  
    {  

        echo "<script>alert('Submit failed!'); history.go(-1);</script>";  
  }

}

if ($_POST["choose"]=="R") {
$user = $_POST["username"];  
        $psw = $_POST["password"];  
        $psw_cfm = $_POST["pswcfm"]; 
        $fullname = $_POST["fullname"];   
        $email = $_POST["email"];  
    
   if($user == "" || $psw == "" || $fullname == ""||$email ==""||$psw_cfm=="")  
        {  
            echo "<script>alert('Please check your information's integrity！'); history.go(-1);</script>";  
        }  
          else{
              if($psw != $psw_cfm)
              {  
                echo "<script>alert('Password different！'); history.go(-1);</script>";  
            }  
             else 
            {  
            
                $conn=mysql_connect($mysql_server_name,$mysql_username, $mysql_password);
                $sql1="select username from user where username = '$user'";
                $sql2="select email from user where email = '$email'";
                $result1=mysql_db_query($mysql_database, $sql1, $conn);
                $result2=mysql_db_query($mysql_database, $sql2, $conn);
                $num1 = mysql_num_rows($result1);
                $num2 = mysql_num_rows($result2);
    if($num1){
        echo "<script>alert('Username existed!'); history.go(-1);</script>"; 
        }
        else if($num2)
        {
            echo "<script>alert('Email address existed!'); history.go(-1);</script>"; 
            }
        else{
            
            $password_hashed = md5($psw);
            $regtime = time(); 
        $token = md5($user.$psw.$regtime); 
        $token_exptime = time()+60*60*24;
            $sql_insert="INSERT INTO user(username,password,email,token,token_exptime,fullname) values('".mysql_real_escape_string($user)."','".mysql_real_escape_string($password_hashed)."','".mysql_real_escape_string($email)."','".mysql_real_escape_string($token)."','".mysql_real_escape_string($token_exptime)."','".mysql_real_escape_string($fullname)."')";
                
//           $sql_insert = "insert into user (username,password,email,fullname) value('$user','$_POST[password]','$email','$fullname')";  
                    $res_insert = mysql_query($sql_insert);  
                    //$num_insert = mysql_num_rows($res_insert);  
                    if($res_insert)  
                    {  
                    
                    

$subject = 'Account Verification';
$email1 = '<font face="Helvetica, Arial, sans-serif">Dear '.$fullname.' <br  />
        <br  />
        Thank you for registering with MissPopUp.com, there is only one
        step remaining to complete your account.<br  />
        Please copy this code and use it as verification on the website
        to confirm your account.<br  />
        Here is your account information <br />
    Username : '.$user.'
    Password : '.$psw.'
        <br  />
       
    <a href="http://beta.misspopup.com/htdocs/register/active.php?verify='.$token.'" target= 
"_blank">http://beta.misspopup.com/register/active.php?verify='.$token.'</a><br/> 
        <br  />
        Thank you very much for your patience. <br  />
        Enjoy The MissPopUp Experience!</font><br  />
      <div class="moz-signature">-- <br  />
        <big><big><b><font face="Brain Flower"><big>Best Regards<br  />
                  The MissPopUp Team</big></font></b></big></big><br  />
        <img src="images/fd4958133a6b6399e1173da74d036e30.png" border="0" height="145" width="145"  /></div>
      <br  />
    </div>
    <br  />';
    
# smtp服务器地址, 如smtp.qq.com
$host = 'mail.misspopup.com';

# 发件人名称
$fromname = 'noreply@misspopup.com';

# 发件人地址和收件人地址填你的邮箱
$from = 'noreply@misspopup.com';
$to = $email;
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
$mailer->Subject = $subject;
$mailer->MsgHTML($email1);
$mailer->SMTPAuth = true;
$mailer->Username = $username1;
$mailer->Password = $passwd;
try{
   // $mailer->Send();
} catch (phpmailerException $e) {
    // 发送失败, 处理你的异常
}
                    
    // 关闭连接
    mysql_close($conn);  
                        echo "<script>alert('Succeed！'); history.go(-1);</script>";  
                    }  
                    else  
                    {  
    // 关闭连接
    mysql_close($conn);  
                        echo "<script>alert('Server is busy, please try again！'); history.go(-1);</script>";
                    exit;
                    }  
               }  
            }  
          }
      
}

if ($_POST["choose"]=="P"){
    
$uptypes=array(  
    'image/jpg',  
    'image/jpeg',  
    'image/png',  
    'image/pjpeg',  
    'image/gif',  
    'image/bmp',  
    'image/x-png'  
);  
  
$max_file_size=2000000;     //上传文件大小限制, 单位BYTE  
$destination_folder="image/"; //上传文件路径  
$watermark=0;      //是否附加水印(1为加水印,其他为不加水印);  
$watertype=1;      //水印类型(1为文字,2为图片)  
$waterposition=1;     //水印位置(1为左下角,2为右下角,3为左上角,4为右上角,5为居中);  
$waterstring="http://www.misspopup.com/";  //水印字符串  
$waterimg="xplore.gif";    //水印图片  
$imgpreview=1;      //是否生成预览图(1为生成,其他为不生成);  
$imgpreviewsize=1/2;   //缩略图比例  

        $pop_name = $_POST["pop_name"];  
        $pop_info = $_POST["pop_info"];  
        $location = $_POST["location"];   
        //$contact = $_POST["contact"];
        $city = $_POST["city"];
        $price = (float)$_POST["price"];
        $typee = $_POST["typee"];
        $style = $_POST["style"];
        $size_min = $_POST["size_min"];
        $size_max = $_POST["size_max"];
        $owner = $_POST["owner"];
    $date = $_POST["date"];
    $time = $_POST["time"];
 $av_time = "$date $time";
    $check_p = 1;
    $table_l = $size_max;

        if($pop_name == ""  || $location == ""||$size_max<$size_min||$price ==""||$size_min ==""||$size_max ==""||$city == "" ||$size_min<0||$size_max<=0||!isset($_POST['pop_name']))  
        {  
            echo "<script>alert('Please check your information's integrity!'); history.go(-1);</script>";  
        }  
else
{
    $conn=mysql_connect($mysql_server_name,$mysql_username, $mysql_password);
    mysql_select_db($mysql_database);
    echo $av_time;
    $year1=((int)substr($av_time,6,4));
$month1=((int)substr($av_time,0,2));
$day1=((int)substr($av_time,3,2));
 $year=((int)substr($av_time,0,4));
$month=((int)substr($av_time,5,2));
$day=((int)substr($av_time,8,2));
$hour = ((int)substr($av_time,11,2));
$minute = ((int)substr($av_time,14,2));
$second = ((int)substr($av_time,17,2));
    $a_time = mktime($hour,$minute,$second,$month1,$day1,$year1);
    $adres = $location.', '.$city;
    
             $sql_insert = "Insert into popup (Pop_Name,Pop_info,Location,Price,desk,style,typee,size_min,Available_time,Owner,table_left) value('".mysql_real_escape_string($pop_name)."','".mysql_real_escape_string($pop_info)."','".mysql_real_escape_string($adres)."','".mysql_real_escape_string($price)."','".mysql_real_escape_string($size_max)."','".mysql_real_escape_string($style)."','".mysql_real_escape_string($typee)."','".mysql_real_escape_string($size_min)."','".mysql_real_escape_string($a_time)."','".mysql_real_escape_string($owner)."','".mysql_real_escape_string($table_l)."')";  


if($_SERVER['REQUEST_METHOD'] == 'POST'){
if (!is_uploaded_file($_FILES["upfile"][tmp_name]))  
    //是否存在文件  
    {  
          echo '<script>alert("Image does not exist!"); history.go(-1);</script>';
          exit;
    }  
    $file = $_FILES["upfile"];  
//   $filepath = 'image/'.$file['name'];
//   move_uploaded_file($upfile['tmp_name'],$filepath);
    if($max_file_size < $file["size"])  
    //检查文件大小  
    {  
    echo "<script>alert('Image is too large!'); history.go(-1);</script>";
    exit;
 
    }  
  
    if(!in_array($file["type"], $uptypes))  
    //检查文件类型  
    {  
    echo "<script>alert('Wrong image type!!'); history.go(-1);</script>";
    exit;
    }  
  
    if(!file_exists($destination_folder))  
    {  
        mkdir($destination_folder);  
    }  
  
    $filename=$file["tmp_name"];  
    $image_size = getimagesize($filename);  
    $pinfo=pathinfo($file["name"]);  
    $ftype=$pinfo['extension'];  
    $destination = $destination_folder.time().".".$ftype;  
    if (file_exists($destination) && $overwrite != true)  
    {  
        echo "<script>alert('Same image name!!'); history.go(-1);</script>";
        exit;
    }  
 
    if(!move_uploaded_file ($filename, $destination))  
    {  
    echo "<script>alert('Something wrong with moving image!'); history.go(-1);</script>";
    exit;
    }  
  
    $pinfo=pathinfo($destination);  
    $fname=$pinfo[basename];  
   // echo " <font color=red>Your image has been uploaded successfully</font><br>Filename:  <font color=blue>".$destination_folder.$fname."</font><br>";  
   // echo " width:".$image_size[0];  
   // echo " length:".$image_size[1];  
   // echo "<br> size:".$file["size"]." bytes";  

}



                    $res_insert = mysql_query($sql_insert);

                    if($res_insert)  
                    { 

        $sql_check="SELECT PopUpid FROM `popup` where Pop_Name like '%$pop_name%' and Available_time like '$a_time'";

        $result=mysql_db_query($mysql_database, $sql_check, $conn);
  mysql_data_seek($result, 0);
     $rowz=mysql_fetch_row($result);
     $newname = "image/$rowz[0].jpg";
        rename("image/$fname","$newname");
    
                  echo '<script language="javascript">
    alert("Succeed!");window.location.href="index.php"; </script>';
                        
                    }  
                    else  
                      {
                        unlink("image/$fname");
                        echo "<script>alert('Server is busy, please try again!');history.go(-1);</script>";  
                      }  
                      } 
                  
}

?>  
