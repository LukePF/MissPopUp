<?php
session_start();
$id=$_GET['id'];
if($_POST['email_i'] && $_POST['email_i']!="")
$id=$_POST['id'];


// $searchs = $_POST['search'];
   $mysql_server_name="localhost:3306"; 
    $mysql_username="lemonk_uta"; 
    $mysql_password="T1a2m3"; 
    $mysql_database="lemonk_beta"; 
    $checke=0; 
   $code = mt_rand(0,1000000);
	 $conn=mysql_connect($mysql_server_name,$mysql_username, $mysql_password);
$strsql="SELECT * FROM `popup` where PopUpid like '%$id%'";
if(isset($_SESSION['username']) && $_SESSION['username']!=""){$use = $_SESSION['username'];
$sql1 = "SELECT email FROM `user` where username like '$use'";
$result1=mysql_db_query($mysql_database, $sql1, $conn);
  
    $row1=mysql_fetch_row($result1);
	$em=$row1[0];
	$checke=11;}
	else if(isset($_POST['email_i']) && $_POST['email_i']!="")
	{$em=$_POST['email_i'];
	$checke=11;}
	$result=mysql_db_query($mysql_database, $strsql, $conn);

    $row=mysql_fetch_row($result);
	$address = $row[4];// Google HQ  
	
$pre_add = mb_convert_encoding($address,"ISO-8859-1",mb_detect_encoding($address));
$prepAddr = str_replace(' ','+',$pre_add);  
$geocode=file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');  
  
$output= json_decode($geocode);  
  
$lat = $output->results[0]->geometry->location->lat;  
$lng = $output->results[0]->geometry->location->lng;

$table_l = $row[16];
?>



<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Miss Pup Op, makes everyday a restaurant day!</title>

<link href="styles/style.css" rel="stylesheet" type="text/css">
<link href="styles/introduction.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?libraries=places&sensor=true_or_false"></script>
<script type="text/javascript" src="jQueryAssets/intro.js"></script>
<!--The following script tag downloads a font from the Adobe Edge Web Fonts server for use within the web page. We recommend that you do not modify it.-->
<script>var __adobewebfontsappname__="dreamweaver"</script>
<script src="http://use.edgefonts.net/open-sans:n3:default.js" type="text/javascript"></script>

</head>

<body onLoad="initialize(<?php echo $lat;?>,<?php echo $lng;?>)">
  <header><!-- This is the header content. It contains Logo and links -->
    <div id="logo"></div>
  <div id="headerLinks">
    <ul>
         <a href="index.php" title="Search"><img src="images/ic_search.png" width="24" height="24" alt=""/></a>
        <!-- <li><a href="NewPopup.html" title="POPUP">POPUP</a></li> -->
       <li>
       <?php if (isset($_SESSION['username']) && !empty($_SESSION['username']))
       {echo '<a title="POPUP" ng-click="newpopup()" ng-dialog-controller="NewpopupCtrl">
        POPUP'; }
        else {echo '<a title="Register" ng-click="register()" ng-dialog-controller="RegisterCtrl">
        Register';     
        }?>
        </a></li>
        <li>
        <a title="LOGIN" ng-click="login()" ng-dialog-controller="LoginCtrl">
        LOGIN
        </a></li>
      </ul>
    </div>
  </header>
  
  <div id="afterheader">
    <form id="result_search_form" method= "GET" class="form" action="result.php">
     <div id="search_bar"><input type="search" name="searchbar" placeholder="Tampere"></div>
     <!--<div id="date_from"><input name="date_from" type="readonly"></div>
		<script>
        $( "#dateorder" ).datepicker({
            inline: true
        });
          // Hover states on the static widgets
        $( "#dialog-link, #icons li" ).hover(
            function() {
                $( this ).addClass( "ui-state-hover" );
            },
            function() {
                $( this ).removeClass( "ui-state-hover" );
            }
        );
        </script>
     <div id="date_to"><input name="date_to"></div>
     <div id="price_bar"><input name="price_bar"></div>-->
     <div id="search_button"><input type="submit" value="SEARCH"></div>
    </form>
  </div>

  <div id="intro_wrapper" class="wrapper">
    <div id="intro_title">
      <h1 style="width: auto"><?php echo $row[1];?></h1>
      <div id="event_pricetag">€ <?php echo $row[12]; ?></div>
      <p style="width: 100%;">Hosted by - <?php echo $row[9]; ?> </p>
      
      <div style="clear:both"></div>
    </div>
    
    <div id="intro_left">
    
      <div id="intro_main_pic">
      <?php
    if(file_exists("image/$id.jpg")){
       
     echo '<img src="image/'.$id.'.jpg" width="440" height="320" style="box-shadow: 3px 2px 2px #aaaaaa" alt="Event Picture"/>';}
	  else
	  {echo '<img src="images/foodexample.png" width="440" height="320" style="box-shadow: 3px 2px 2px #aaaaaa" alt="Event Picture"/>';}
	   ?>  </div>
      <div id="intro_location">
        <h2 style="width: auto">Location : </h2>
        <div id="intro_loca_map"></div>
      </div>
    </div>
    
    <div id="intro_right">
      <div id="intro_desc" class="intro_block">
        <h2 style="width: auto">Popup description : </h2>
        <p><?php echo $row[2]; ?></p>
      </div>
      <div id="intro_info" class="intro_block">
        <h2 style="width:auto">Important information : </h2>
        <div><p class="info_type">Date</p><p><?php echo date("d.m.Y",$row[7]);?></p></div>
        <div><p class="info_type">Time</p><p><?php echo date("H:i",$row[7]); ?></p></div>
        <div><p class="info_type">People</p><p><?php echo $row[14]." to ".$row[5]; ?></p></div>
        <div><p class="info_type">Style</p><p><?php echo $row[13]; ?></p></div>
        <div><p class="info_type">Type</p><p><?php echo $row[15]; ?></p></div>
      
        <div style="clear:both"></div>
      </div>
      <div id="intro_gues" class="intro_block">
        <h2 style="width:auto">Booking :</h2>
         <form id="bp_form" action="introduction.php" method="POST">
         <?php if($checke==11)
		{ echo '<input id="bp_email" type="text" placeholder="E-mail" name="email_ii" value="'.$em.'" disabled>'; 
		echo ' <input type="hidden"   name="email_i" value="'.$em.'" />';}
		else{
			echo '<input id="bp_email" type="text" placeholder="E-mail" name="email_i">';}?>
         
           <div style="clear:both"></div>
        <div id="guests_select">
          <span id="sleBG">
          <span id="sleHid">
           
          
          <input type="hidden" <?php echo 'value="'.$id.'"'; ?>  name="id" />
          <select id="guests_number" class="select" name="gn" <?php if (isset($_POST['gn']) && is_numeric($_POST['gn']))
		  echo 'value="'.$_POST['gn'].'"';
		  if(!is_numeric($_POST['gn']))
		  echo "<script>alert('Wrong information!'); history.go(-1);</script>";  ?>>
            <?php if(isset($_POST['gn']) && is_numeric($_POST['gn']))
			$check2=1;
			else echo '<option selected="selected">Guests</option>';?>
            <?php 
			for ($az=1; $az<=$row[5];$az++)
			{echo '<option value='.$az.'>'.$az.'</option>';} 
			?>
          </select>
    
          </span>
          </span>
        </div>
        <input id="bp_update_button" type="submit" value="Update">
        
        <div style="clear:both"></div>
        </form>
      </div>
      <div id="intro_summ" class="intro_block">
        <h2 style="width:auto">Popup summary :</h2>
        <div><p class="summ_type"><?php echo $row[1]; ?></p><p>€ <?php echo $row[12]; ?></p></div>
        <div><p class="summ_type">GUESTS</p><p><?php if (isset($_POST['gn'])&& is_numeric($_POST['gn']))
		  echo $_POST['gn']; 
		  else echo "3"; ?></p></div>
        <div style="border-top: 1px solid #DDDDDD"><p class="summ_type">TOTAL PRICE</p><p>€ <?php  if(isset($_POST['gn']))
		$quan = $_POST['gn'];
		else $quan = 3; 
		$f_price = $row[12] * $quan ;
		$amount = $f_price *100;
		echo $f_price;?> </p></div>
        <div style="clear:both"></div>
      </div>
      <div id="pay" class="intro_block">
        <!--<h2 style="width:auto">Payment options :</h2>
        <div id="pay_select">
          <form action="" method="get">
			<label><input name="Fruit" type="radio" value="" /><img src="images/search.png" width="60" height="25" alt=""/></label>
			<label><input name="Fruit" type="radio" value="" /><img src="images/search.png" width="60" height="25" alt=""/> </label>
			<label><input name="Fruit" type="radio" value="" /><img src="images/search.png" width="60" height="25" alt=""/> </label>
          </form>
        </div>-->
      </div>
      <div id="intro_book_button" class="intro_block">
      <form action="completed/neworder.php" method="POST">
        <input type="hidden" <?php echo 'value="'.$row[1].'"'; ?>  name="item_name" />
       <input type="hidden" <?php echo 'value="'.$row[12].'"'; ?>  name="price" />
        <input type="hidden" <?php echo 'value="'.$row[9].'"'; ?>  name="owner" />
         <input type="hidden" <?php echo 'value="'.$em.'"'; ?>  name="email1" />
         <input type="hidden" <?php echo 'value="'.$quan.'"';
		 ?>  name="quantity" />
         <input type="hidden" name="code" value="<?php echo $code;?>">
         <input type="hidden" value="<?php echo $id ;?>" name="id1" />
         <input type="hidden" value="<?php echo $row[7] ;?>" name="date" />
        <script 
                src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                data-key="pk_test_JEvbFGh6wv6oYAPl560imzq3"
                data-amount="<?php echo $amount; ?>"
                
    data-name="<?php echo $row[1];?>"
    data-description="<?php echo $row[1]." with ".$quan." tables ( €".$f_price." )"; ?> "
    data-image="http://beta.misspopup.com/sss/image/<?php echo $id.".jpg"; ?>"
	data-currency="EUR"
	data-email="<?php echo $em; ?>">
            </script>
            </form>
      </div>
    </div>
  </div>


  <footer>© MISSPOPUP 2015<a href="Info.html" title="ABOUT MISSPOPUP">ABOUT US</a></footer>
</body>
</html>
