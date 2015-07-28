<?php
session_start();
$usercheck = $_SESSION['username'];
?>
<!doctype html>
<html ng-app="missPopup">
<head>
<meta charset="utf-8">
<title>Miss Pup Op, makes everyday a restaurant day!</title>
<link href="styles/style.css" rel="stylesheet" type="text/css">
<link href="styles/search.css" rel="stylesheet" type="text/css">




  <link rel="stylesheet" type="text/css" href="styles/ngDialog.css">

  <link rel="stylesheet" type="text/css" href="styles/bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="styles/popDialog.css">
    <link rel="stylesheet" type="text/css" href="styles/ngDialog-theme-default.css">

    <!-- <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet"> -->

    <script type="text/javascript" src="jQueryAssets/angular.min.js"></script>
    <script type="text/javascript" src="jQueryAssets/ui-bootstrap-tpls-0.13.0.min.js"></script>
    <script type="text/javascript" src="jQueryAssets/ngDialog.js"></script>
    <script type="text/javascript" src="javascript/homePage.js"></script>
<!--The following script tag downloads a font from the Adobe Edge Web Fonts server for use within the web page. We recommend that you do not modify it.-->
<script>var __adobewebfontsappname__="dreamweaver"</script>
<script src="http://use.edgefonts.net/open-sans:n3:default.js" type="text/javascript"></script>

</head>

<body>
  <header><!-- This is the header content. It contains Logo and links -->
    <div id="logo"><a href="index.html" title="Miss Pup Op, makes everyday a restuarant day!"></a></div>
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
  
  <div id="index_wrapper" class="wrapper">
   <div id="title_blank">
    </div>
    <div id="title_words">
      <h1>Search for the best pop ups near you!</h1>
      <h2>List your pop up restaurants and organize events anytime you like.</h2>
    </div>
    <form id="search_form" method= "GET" class="form" action="result.php">
     <div id="search_bar"><input type="search" name="search" placeholder="Search for location, e.g. Tampere"></div>
     <div id="search_button"><input type="submit" value="Let's eat"></div>
    </form>
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
                    <!---------------------------------------------- OR ------------------------------------------- &nbsp;-->
                    <br>
                <div style="margin:0 auto">
                    <!--<button id="loginWithFacebook" class="btn btn-primary btn-lg btn-block"> Login With Facebook </button>-->
                </div>
            </form>
        </div>
    </script>

    <script type="text/ng-template" id="registerDialogId">
        <div class="register-dialog">
            <div class="register-title">
                <span>JOIN MISSPOPUP</span>
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
                          <input type="checkbox" name="agree" > I agree with terms and privacy agreement.
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
                       <a class="btn btn-primary btn-lg btn-block registerButton" type="submit" name="submit" value="Login"> Register </a>
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
</body>

</html>
