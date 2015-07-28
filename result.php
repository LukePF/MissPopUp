<?php
//session_id($_GET['sn']); 
session_start();
//echo $_GET['sn'];

$searchs = $_GET['search'];
/*echo '<script>alert("Please check the integrity of your information!"); history.go(-1);</script>'; */

if($searchs=="Search with location, like Tampere" || $searchs=="")
{$searchs="Tampere";}


	?>

<!doctype html>
<html ng-app="missPopup">
<head>
<meta charset="utf-8">
<title>Miss Pup Op, makes everyday a restaurant day!</title>
<link href="styles/style.css" rel="stylesheet" type="text/css">
<link href="styles/result.css" rel="stylesheet" type="text/css">
<link href="styles/datetable.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" type="text/css" href="styles/ngDialog.css">
    <link rel="stylesheet" type="text/css" href="styles/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="styles/popDialog.css">
    <link rel="stylesheet" type="text/css" href="styles/ngDialog-theme-default.css">

  <script type="text/javascript" src="jQueryAssets/angular.min.js"></script>

  <script type="text/javascript" src="jQueryAssets/angular.min.js"></script>
  <script type="text/javascript" src="jQueryAssets/ui-bootstrap-tpls-0.13.0.min.js"></script>
  <script type="text/javascript" src="jQueryAssets/ngDialog.js"></script>
  <script type="text/javascript" src="javascript/homePage.js"></script>


  <script type="text/javascript" src="javascript/app.js"></script>


<script src="jQueryAssets/jquery.js"></script>
<script src="jQueryAssets/jquery-ui.js"></script>
</head>

<body>
  <header><!-- This is the header content. It contains Logo and links -->
    <div id="logo"></div>
  <div id="headerLinks" ng-controller="MainCtrl">
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
    <form id="result_search_form" method= "GET" class="form" action="Result.php">
      <div id="search_bar"><input type="search" name="searchbar" placeholder="Tampere"></div>
     
     <!-- <div id="date_from"><input name="date_from" type="readonly"></div>
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
     <div id="date_to"><input name="date_to"></div> -->

      <div id="date_selection" ng-controller="DatepickerDemoCtrl">
        <div id="date_from">
          <div class="inputBox">
            <input type="text" placeholder="FROM" is-open="openedFrom" ng-model="date_from" datepicker-popup="dd/MMM/yy" ng-required="true" min-date="minDate" name="date_from">
          </div>
          <div class="icon_calendar">
            <button type="button" class="btn btn-default" ng-click="openFrom($event)">
                <i class="glyphicon glyphicon-calendar"></i>
            </button>
          </div>  
        </div>

        <div id="date_to">
          <div class="inputBox">
            <input type="text" placeholder="TO" is-open="openedTo" ng-model="date_to" datepicker-popup="dd/MMM/yy" ng-required="true" min-date="date_from" name="date_to">
          </div>
          <div class="icon_calendar">
              <button type="button" class="btn btn-default" ng-click="openTo($event)">
                  <i class="glyphicon glyphicon-calendar"></i>
              </button>
          </div>
        </div>
      </div>


      <div id="price_bar" class="input-group">
        <input name="price_bar" class="form-control" placeholder="PRICE"> €
      </div>

      <div id="search_button">
        <input type="submit" value="NARROW IT">
      </div>
    </form>
  </div>
  
  
  <div id="result_wrapper" class="wrapper" ng-controller="PaginationCtrl">

<script type="text/javascript">
<?php
    $mysql_server_name="localhost";  
    $mysql_username="lemonk_uta"; 
    $mysql_password="T1a2m3"; 
    $mysql_database="lemonk_beta"; 
   
   
	 $conn=mysql_connect($mysql_server_name,$mysql_username, $mysql_password);
$strsql="SELECT * FROM `popup` where Location like '%$searchs%'";
	$result=mysql_db_query($mysql_database, $strsql, $conn);
	$Anum = mysql_num_rows($result);
      $row=mysql_fetch_row($result);
      mysql_data_seek($result, 0);

   $datalist = '[';
	$eventlist ='var playlist = [';
	$i = 1;
	 while ($row=mysql_fetch_row($result))
    {
		$timen = date("d.m.Y",$row[7]);
		if($i < $Anum)
		{
$eventlist = $eventlist.'
{
  imgid: "'.$row[0].'",
  eventname: "'.$row[1].'",
  time: "'.$timen.'",
  host: "'.$row[9].'",
  price: "'.$row[12].'",
  style: "'.$row[13].'",
},
';}
		if($i == $Anum)
		{
$eventlist = $eventlist.'
{
  imgid: "'.$row[0].'",
  eventname: "'.$row[1].'",
  time: "'.$timen.'",
  host: "'.$row[9].'",
  price: "'.$row[12].'",
  style: "'.$row[13].'",
}
] ';
}
		$i = $i +1 ;
	}
	echo $eventlist;
?>

 /* var playlist = [
    {
      price: 30,
      time: "2015/5/12",
      image:"item1.jpg",
    },  
    {
      price: 40,
      time: "2015/5/13",
      image:"item2.jpg",
    },  
    {
      price: 20,
      time: "2015/5/16",
      image:"item3.jpg",
    },  
    {
      price: 35,
      time:"2015/6/14",
      image:"item4.jpg",
    },  
    {
      price: 25,
      time: "2015/6/12",
      image:"item5.jpg",
    },  
    {
      price: 30,
      time: "2015/6/5",
      image:"item6.jpg",
    },  
    {
      price: 35,
      time: "2015/5/27",
      image:"item7.jpg",
    },  
    {
      price: 40,
      time: "2015/5/27",
      image:"item8.jpg",
    },  
    {
      price: 15,
      time: "2015/5/27",
      image:"item9.jpg",
    },  
    {
      price: 45,
      time: "2015/5/27",
      image:"item10.jpg",
    },  
    {
      price: 35,
      time: "2015/5/27",
      image:"item11.jpg",
    },  
    {
      price: 25,
      time: "2015/5/27",
      image:"item12.jpg",
    },  
    {
      price: 50,
      time: "2015/5/27",
      image:"item13.jpg",
    },  
    {
      price: 30,
      time: "2015/5/27",
      image:"item14.jpg",
    }
  ];*/

  $(document).ready(function(){
    $("#playlist").val(playlist);
  });

</script>
  <input id="playlist" type="hidden" ng-model="playlist">
    <div id="result_title">
      <p style="width:100%">Search results for</p>
      <h1 style="width:160px; line-height: 0pt">TAMPERE</h1>
      <p style="width:480px">FILTERS APPLIED:   PRICE: 30€ - 50€   DATE: <?php echo date("d/m/Y",time()).' - '.date("d/m/Y",strtotime("+1 month")); ?></p>
      <div ng-init="reverse = true">
        <span id="sleBG">
          <span id="sleHid">
          <select id="list_result_order" ng-model="order" class="select">
            <option selected="selected">ORDER BY</option>
            <option value="price" ng-click="reverse = !reverse">PRICE</option>
            <option value="by_distance">DISTANCE</option>
            <option value="time" ng-click="reverse = !reverse">TIME</option>
          </select>
          </span>
        </span>
      </div>
      
      <div style="clear:both"></div>
    </div>
    
    <div id="result_list" >
      <div id="list_border">
        
        <div class="result_event" ng-repeat="item in pagedItems | orderBy:order:reverse">
          <div class="result_event_pic">
            <a href="introduction.php?id={{item.imgid}}"><img  ng-src="image/{{item.imgid}}.jpg" width="300" height="300" alt=""/> </a>
          </div>
          <div class="result_event_info">
            <div class="event_name">{{item.eventname}}</div>


            <div class="event_price"><label>{{item.price}},€</label></div>
            <div class="event_host"><p>hosted by - <label style="font-weight:600">{{item.host}}</label></p></div>
            <div class="event_date_style"><p><label style="font-weight:600">Date:</label>{{item.time}}<br><label style="font-weight:600">Style:</label>{{item.style}}</p></div>
            <div class="event_button"><form type="GET" action="introduction.php" > <input type= "hidden" name= "id" value="{{item.imgid}}"> <input type="submit" value="Join Now"></div>
          </div>
        </div>

        <button class="btn" href="#" ng-hide="nextPageDisabledClass()" ng-click="loadMore()">Load More</button>
        
        <div style="clear:both"></div>
      
      </div>
  
    </div>
  </div>
  
  
  <footer>© MISSPOPUP 2015<a href="Info.html" title="ABOUT MISSPOPUP">ABOUT US</a></footer>


    <script type="text/ng-template" id="loginDialogId">
        
        <div class="login-dialog">

            <div class="login-title">
                <div class="login-title-tip" ng-click="register() ">
                    <span >create an account</span>
                </div>
                <div class="login-title-heading">
                    <h2>LOGIN</h2>
                </div>
            </div>
            <br>
            <form id="loginForm" action="processing.php" method="post">
                <div class="form-group">
                    <input class="form-control" type="text" placeholder="Username" name="username">
                </div>
                <div class="form-group">
                    <input class="form-control" type="password" name="password" placeholder="Password">
                    <input type="hidden" name="choose" value="L">
                </div>
                <div class="form-group">
                      <div class="checkbox">
                        <label>
                          <input type="checkbox"> Remember me
                        </label>
                       </div>
                </div>
                <div class="form-group">
                    <button id="loginFormButton" class="btn btn-primary btn-lg btn-block" type="submit" name="submit" value="Login"> 
                    Login </button>
                </div>
                    &nbsp;&nbsp; 
                    -------------------------------------------- OR ------------------------------------------- &nbsp;
                    <br>
                <div style="margin:0 auto">
                    <button id="loginWithFacebook" class="btn btn-primary btn-lg btn-block"> Login With Facebook </button>
                </div>
            </form>
        </div>
    </script>

    <script type="text/ng-template" id="registerDialogId">
        <div class="register-dialog">
            <div class="register-title">
                <span>JION MISSPOPUP</span>
            </div>

            <form id="registerForm" action="processing.php" method="post">
                <br>
                <div id="registerFormLeft">
                    <div class="form-group">
                        <span>Username</span>
                        <input class="form-control" type="text" name="username" placeholder="Username">
                    </div>
                    <br>

                    <div class="form-group">
                        <span>Password</span>
                        <input class="form-control" type="password" name="password" placeholder="Password">
                    </div>
                    <br>

                    <div class="form-group" >
                        <span>Password Confirm</span>
                        <input class="form-control" type="password" name="pswcfm" placeholder="Password again">
                        <input type="hidden" name="choose" value="R">
                    </div>
                    <br>

                    <div class="form-group">
                      <div class="checkbox">
                        <label>
                          <input type="checkbox"> Send me updates
                        </label>
                       </div>
                    </div>
                    <div>
                        <a class="register-href" ng-click="login()">Already have an account? Click here to login</a>
                    </div>
                </div>

                <div id="registerFormRight">

                    <div class="form-group" >
                        <span>Fullname</span>
                        <input set-focus class="form-control" type="text" name="fullname" placeholder="Fullname">
                    </div>
                    <br>
                    <div class="form-group" >
                        <span>Email</span>
                        <input class="form-control" type="email" name="email" placeholder="Email">
                    </div>
                    <br>
                    <div class="form-group">
                        <span>Confirm Code</span>
                        <input set-focus class="form-control" type="text" placeholder="confirmCode">
                    </div>

                    <br>

                    <div class="form-group">
                       <button class="btn btn-primary btn-lg btn-block registerButton" type="submit"> Register </button>
                    </div>
                </div>
            </form>
        </div>
    </script>

<?php if (isset($_SESSION['username']) && !empty($_SESSION['username'])){
echo '
    <script type="text/ng-template" id="newpopupDialogId">

        <div class="newpopup-dialog">

            <div class="newpopup-title">
                <span>CREATE NEW POPUP</span>
            </div>

            <br>
            <form id="newpopupForm"  action="processing.php" method="post" enctype="multipart/form-data">
                <div id="newpopupFormDiv">
                    <div>
                        <div id="newpopupFormDivName" class="form-group" >
                            <span>Event name </span>
                            <input class="form-control" type="text" name="pop_name" placeholder="Hotpot">
                        </div>

                        <div id="newpopupFormDivAddress" class="form-group">
                            <span>Address </span>
                            <input class="form-control" type="text" name="location" placeholder="Finninmaenkatu">
                        </div>
                    </div>

                    <div>
                        <div id="newpopupFormDivPrice" class="form-group" >
                            <span>Price </span>
                            <input class="form-control" type="text" name="price" placeholder="30€">
                        </div>

                        <div id="newpopupFormDivCity" class="form-group" >
                            <span>City </span>
                            <input class="form-control" type="text" name="city" placeholder="Tampere">
                        </div>

                        <div id="newpopupFormDivSeatMin" class="form-group">
                            <span>seats </span>
                            <input class="form-control" type="text" name="size_min" placeholder="Min">
                        </div>

                        <div id="newpopupFormDivSeatMax" class="form-group">
                            <br>
                            <input class="form-control" type="text" name="size_max" placeholder="Max">
                            <input  name="owner" type="hidden" value=".$usercheck." />
                        </div>
                    </div>

                    <div ng-controller="DatepickerDemoCtrl">
                        <div id="newpopupFormDivDate" class="form-group">
                            <span>Date </span>
                            <input class="form-control" type="text" placeholder="MM/DD/YYYY"
                                   is-open="opened"
                                   datepicker-popup="MM/dd/yyyy"
                                   ng-model="dt"
                                  
                                   min-date="minDate"
                                   
                                   ng-required="true"
                                   show-weeks="true"
                                   close-text="Close"
                                   name="date"
                                    >
                        </div>

                        <div id="newpopupFormDivDateIcon" class="form-group">
                            <br>
                            <button type="button" class="btn btn-default" ng-click="open($event)">
                                <i class="glyphicon glyphicon-calendar"></i>
                            </button>
                        </div>

                        <div id="newpopupFormDivTime" class="form-group">
                            <span>Time </span>
                            <input class="form-control" type="text" name="time" placeholder="12:00">
                            <input type="hidden" name="choose" value="P">
                        </div>

                        <div id="newpopupFormDivTimeIcon" class="form-group">
                            <br>
                            <button type="button" class="btn btn-default" ng-click="">
                                <i class="glyphicon glyphicon-time"></i>
                            </button>

                        </div>
                    </div>

                    <div >
                        <div id="newpopupFormDivType" class="form-group">
                            <select  class="form-control" name="typee">
                                <option>Type</option>
                                <option>Breakfast</option>
                                <option>Lunch</option>
                                <option>Dinner</option>
                                <option>Snack</option>
                            </select>
                        </div>

                        <div id="newpopupFormDivStyle" class="form-group" name="style" >
                            <select class="form-control">
                                <option>Style</option>
                                <option>Chinese</option>
                                <option>Finnish</option>
                                <option>Japanese</option>
                                <option>Italian</option>
                            </select>

                        </div>

                        <div id="newpopupFormDivImage" class="form-group">
                            <span class="selectPicture"> 
                            Select Picture &nbsp;&nbsp;&nbsp;
                                <i class="glyphicon glyphicon-camera"></i>
                            </span>
                            <input id="newpopupFormDivImageInput" class="form-control" name="upfile" type="file">
                        </div>
                    </div>

                </div>


                <div id="newpopupFormDivDescription">
                    <textarea class="form-control" rows="9"></textarea>

                    <div id="newpopupFormDivButtonDiv" class="form-group">
                        <button id="newpopupFormDivButton" class="btn btn-default" type="submit" name="submit" value="popup"> Launch Popup</button>
                    </div>
                </div>


            </form>
        </div>


    </script>';}
?>
  <!--  <script type="text/ng-template" id="newpopupDialogId">

        <div class="newpopup-dialog">

            <div class="newpopup-title">
                <span>CREATE NEW POPUP</span>
            </div>

            <br>
            <form id="newpopupForm"  action="processing.php" method="post" enctype="multipart/form-data">
                <div id="newpopupFormDiv">
                    <div>
                        <div id="newpopupFormDivName" class="form-group" >
                            <span>Event name </span>
                            <input class="form-control" type="text" name="pop_name" placeholder="Hotpot">
                        </div>

                        <div id="newpopupFormDivAddress" class="form-group">
                            <span>Address </span>
                            <input class="form-control" type="text" name="location" placeholder="Finninmaenkatu">
                        </div>
                    </div>

                    <div>
                        <div id="newpopupFormDivPrice" class="form-group" >
                            <span>Price </span>
                            <input class="form-control" type="text" name="price" placeholder="30€">
                        </div>

                        <div id="newpopupFormDivCity" class="form-group" >
                            <span>City </span>
                            <input class="form-control" type="text" name="city" placeholder="Tampere">
                        </div>

                        <div id="newpopupFormDivSeatMin" class="form-group">
                            <span>seats </span>
                            <input class="form-control" type="text" name="size_min" placeholder="Min">
                        </div>

                        <div id="newpopupFormDivSeatMax" class="form-group">
                            <br>
                            <input class="form-control" type="text" name="size_max" placeholder="Max">
                            <input  name="owner" type="hidden" value=".$usercheck." />
                        </div>
                    </div>

                    <div ng-controller="DatepickerDemoCtrl">
                        <div id="newpopupFormDivDate" class="form-group">
                            <span>Date </span>
                            <input class="form-control" type="text" 
                                  placeholder="DD/MM/YYYY"
                                   is-open="opened"  
                                   ng-model="dt"
                                   datepicker-popup="dd/MM/yyyy"
                                   ng-required="true"
                                   min-date="minDate"
                                   name="date"
                                    >
                        </div>

                        <div id="newpopupFormDivDateIcon" class="form-group">
                            <br>
                            <button type="button" class="btn btn-default" ng-click="open($event)">
                                <i class="glyphicon glyphicon-calendar"></i>
                            </button>
                        </div>

                        <div id="newpopupFormDivTime" class="form-group">
                            <span>Time </span>
                            <input class="form-control" type="text" name="time" placeholder="12:00">
                            <input type="hidden" name="choose" value="P">
                        </div>

                        <div id="newpopupFormDivTimeIcon" class="form-group">
                            <br>
                            <button type="button" class="btn btn-default" ng-click="">
                                <i class="glyphicon glyphicon-time"></i>
                            </button>

                        </div>
                    </div>

                    <div >
                        <div id="newpopupFormDivType" class="form-group">
                            <select  class="form-control" name="typee">
                                <option>Type</option>
                                <option>Breakfast</option>
                                <option>Lunch</option>
                                <option>Dinner</option>
                                <option>Snack</option>
                            </select>
                        </div>

                        <div id="newpopupFormDivStyle" class="form-group" name="style" >
                            <select class="form-control">
                                <option>Style</option>
                                <option>Chinese</option>
                                <option>Finnish</option>
                                <option>Japanese</option>
                                <option>Italian</option>
                            </select>

                        </div>

                        <div id="newpopupFormDivImage" class="form-group">
                            <span class="selectPicture"> 
                            Select Picture &nbsp;&nbsp;&nbsp;
                                <i class="glyphicon glyphicon-camera"></i>
                            </span>
                            <input id="newpopupFormDivImageInput" class="form-control" name="upfile" type="file">
                        </div>
                    </div>

                </div>


                <div id="newpopupFormDivDescription">
                    <textarea class="form-control" rows="9"></textarea>

                    <div id="newpopupFormDivButtonDiv" class="form-group">
                        <button id="newpopupFormDivButton" class="btn btn-default" type="submit" name="submit" value="popup"> Launch Popup</button>
                    </div>
                </div>


            </form>
        </div>


    </script>-->

</body>
</html>
