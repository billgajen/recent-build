<?php

include "includes/common.php";

require 'fb-sdk/facebook.php';

// Create our Application instance (replace this with your appId and secret).
$facebook = new Facebook(array(
  'appId'  => FB_APP_ID,
  'secret' => FB_APP_SECRET,
));

if(isset($_GET['action']) && $_GET['action'] === 'logout'){
    $facebook->destroySession();
	header("location:".SITE_URL);
}

// Get User ID
$user = $facebook->getUser();

if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me',
                'GET',
                array(
                    'access_token' => $access_token
                ));
  } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
  }
}


// Login or logout url will be needed depending on current user state.
if ($user) {
  $logoutUrl = $facebook->getLogoutUrl();
} else {
  $loginUrl = $facebook->getLoginUrl(array(
    'scope' => 'email'
	));
}

if($user){
$user_det = $facebook->api('/me?fields=id,name,gender,first_name,last_name,email,link'); 
$user_gender = $user_det["gender"];
if($user_gender=="male"){ $oppGender = "female"; }
if($user_gender=="female"){ $oppGender = "male"; }

$selUser = "select * from ".TBL_USER." where fb_id='".$user."'";
$resUser = mysql_query($selUser);

if(mysql_num_rows($resUser)==0){
	$insUser = "insert into ".TBL_USER."(fb_id, name, first_name, last_name, link, gender, email, created_date) VALUES
				('".$user."','".$user_det["name"]."','".$user_det["first_name"]."','".$user_det["last_name"]."','".$user_det["link"]."','".$user_det["gender"]."','".$user_det["email"]."',now())";	
	$resInsUser = mysql_query($insUser);
}


}
?>
<!DOCTYPE html>
<html <?php if($user){ ?>class="logged"<?php } ?>>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <title>Frendcy</title>
        <!--[if lte IE 9]>
            <script>
                var tags = 'abbr article aside audio canvas datalist details figure footer header hgroup mark menu meter nav output progress section time video'.split(' ');
                for (var i = 0; i < tags.length; i++) {
                    document.createElement(tags[i]);
                }
            </script>
        <![endif]-->
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/touch/apple-touch-icon-144x144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/touch/apple-touch-icon-114x114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/touch/apple-touch-icon-72x72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="images/touch/apple-touch-icon-57x57-precomposed.png">
        <link rel="shortcut icon" href="images/touch/apple-touch-icon.png">

        <link rel="icon" type="image/ico" href="favicon.ico" />
        <meta name="description" content="Do you fancy your friend? Express your interest and find out who likes you. An easy way to get connected. Show your interest without getting embarrassed.">
        <meta name="keywords" content="Show interest, express your interest, express love, dating, I love you, I fancy you, fancy">
        <link rel="stylesheet" href="css/main.css">
        <!--[if lt IE 9]>
            <link rel="stylesheet" href="css/ie8-and-down.css" />
        <![endif]-->
        <script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
        <script>
            if (document.innerWidth || document.documentElement.clientWidth > 960) {
                document.write(unescape('%3Cscript src="js/plugins/jquery.tinyscrollbar.min.js"%3E%3C/script%3E'));
            } 
			var selected_friends = new Array();
        </script>
        <script type="text/javascript" src="js/jquery.validate.js"></script>
        <style type="text/css">
		#contact_form label.error{ width:100% !important; font-weight:normal !important; display:none !important; }
		</style>
		<script type="text/javascript" src="js/main.js"></script>
        <script type="text/javascript">
		window.fbAsyncInit = function() {
			// init the FB JS SDK
			FB.init({
			  appId      : '<?php echo FB_APP_ID; ?>',           // App ID from the app dashboard
			  status     : true,                                 // Check Facebook Login status
			  xfbml      : true                                  // Look for social plugins on the page
			});
			// Additional initialization code such as adding Event Listeners goes here
		  }; 	
		  // Load the SDK asynchronously
		  (function(d, s, id){
			 var js, fjs = d.getElementsByTagName(s)[0];
			 if (d.getElementById(id)) {return;}
			 js = d.createElement(s); js.id = id;
			 js.src = "//connect.facebook.net/en_US/all.js";
			 fjs.parentNode.insertBefore(js, fjs);
		   }(document, 'script', 'facebook-jssdk'));
		
		
		function load_tinyscroll(){
			if($(".fb-friends-list")){
				if (document.innerWidth || document.documentElement.clientWidth > 960) {
					var oScrollbar = $('.fb-friends-list');
					oScrollbar.tinyscrollbar();
					oScrollbar.tinyscrollbar_update();	
				}
			}
		}
		function filter_friends(type,element){
			$(".sort-friends ul li.selected").removeClass("selected");
			$(element).addClass("selected");	
			if(type=="male"){
				$("#friends_list ul li").hide();	
				$("#friends_list ul li.male").show();	
			}else if(type=="female"){
				$("#friends_list ul li").hide();	
				$("#friends_list ul li.female").show();	
			}else{
				$("#friends_list ul li").show();	
			}
			load_tinyscroll();
			$("#search_key").val("");
			return false;
		}
		function filter_friends_keyword(){
			$(".sort-friends ul li.selected").removeClass("selected");
			$(".sort-friends ul li:last").addClass("selected");
			var keyword = $("#search_key").val().toLowerCase();
			$("#friends_list ul li").hide();
			$("#friends_list ul li").each(function(){
				var searchphrase = $(this).find("span").text().toLowerCase();
				if (searchphrase.toLowerCase().indexOf(keyword) != -1){
					$(this).show();
				}
			});
			load_tinyscroll();
			return false;
		}
		function load_ajax_request(){
			if(selected_friends.length>0){
				$("#message_container").html('<img src="loading.gif" width="32" height="32" border="0" />');
				$.ajax({
					url : "proposal-request.php",
					type : "post",
					data : "requestID="+selected_friends.toString(),
					success:function(data){
						/*for (var i=0;i<selected_friends.length;i++){
							var elementselected = $("#friend_"+selected_friends[i]).find("a");
							elementselected.addClass("noaction");
							elementselected.text("Request Sent");
						}*/
						if(parseInt(data)>0){
							showModal();
							showMsgShare();
						}
						$("#message_container").html('');
						//selected_friends =  new Array();
						//$("#message_container").html('Your selection has been saved securely to our system');
					}
				});
			}else{
				alert("Please select atleast one friend to submit");	
			}
		}
		function share_fb(){
			FB.ui({
			  method: 'feed',
			  link: '<?php echo SITE_URL; ?>',
			  picture: '<?php echo SITE_URL; ?>images/logo-icon.png',
			  name: '<?php echo SITE_TITLE; ?>',
			  description: '<?php echo FB_SHARE_MESSAGE; ?>'
			}, function(response){
				
			});	
			closeOverlay();
		}
					
		$(document).ready(function(){
			$("#contact_form").validate({
				rules: {
					"name":"required",
					"email": {
						"required":true,
						"email":true	
					},
					"subject": "required",
					"query":"required"
				},
				messages : {
					"name":"",
					"email": {
						"required":"",
						"email":"Please enter valid Email address"	
					},
					"subject": "",
					"query":""
				},
				submitHandler: function() { 
					$("#success_message").show();
					$("#success_message").html('<img src="loading.gif" width="32" height="32" border="0" />');
					$.ajax({
						url : "contact-request.php",
						type : "post",
						data : "name="+$("#name").val()+"&email="+$("#email").val()+"&subject="+$("#subject").val()+"&query="+$("#query").val(),
						success:function(data){
							$("#contact_form").trigger('reset');
							$("#error_message").hide();
							$("#success_message").html("Message Sent");
							setTimeout(function(){ $("#success_message").hide(); },5000);
						}
					});
				},
				errorContainer: $("#contact_form div#error_message"),
			});
		});
		//<img src="loading.gif" width="32" height="32" border="0" />
		</script>
        <!-- Google Analytics -->
        <script>
          (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

          ga('create', 'UA-42732971-1', 'frendcy.com');
          ga('send', 'pageview');

        </script>
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->

        <header>
            <nav>
                <a href="<?php echo SITE_URL; ?>"><div class="logo"></div></a>
                <ul class="top-navigation">
                    <li class="scroll-link"><a href="">About</a></li>
                    <li class="scroll-link"><a href="">Contact</a></li>
                    <?php if($user){ ?>
                    <li class="fb-logout"><a href="<?php echo SITE_URL."?action=logout"; ?>">Logout</a></li>
                    <?php } ?>
                    <li class="social-icon"><a href="http://www.facebook.com/frendcy" target="_blank"><img alt="facebook share" src="images/icons/fb-share.png" /></a></li>
                    <li class="social-icon"><a href="http://www.twitter.com/frendcy" target="_blank"><img alt="twitter share" src="images/icons/twitter-share.png" /></a></li>
                </ul>
                <h1>Secretly find who’s interested in you</h1>
                <a href="<?php echo $loginUrl; ?>" class="fb-login"></a>
            </nav>
        </header>
        <div class="container">
            <?php if ($user): ?>
            <?php 
				$delUserFriends = "delete from ".TBL_FRIENDS." where fb_user_id='".$user."'";
				$resDelUserFriends = mysql_query($delUserFriends);
				$user_friends = $facebook->api('/me/friends?fields=id,name,gender,first_name,last_name'); 
			?>
            <section class="grey-bg">
                <div class="fb-friends-module">
                    <h2><?php if($user){ echo $user_det["first_name"]." ".$user_det["last_name"]; } ?><span>Simply click to select/deselect and submit to save records.</span></h2>
                    <!--<form name="frm_search" id="frm_search" method="get" action="" onSubmit="return filter_friends_keyword();" >-->
                    <div class="sort-friends">
                        <span>Sort by:</span>
                        <ul>
                            <li <?php if($oppGender=="male"){ ?>class="selected"<?php } ?> onClick="return filter_friends('male',this);"><a href="#">Men</a><span>/</span></li>
                            <li <?php if($oppGender=="female"){ ?>class="selected"<?php } ?> onClick="return filter_friends('female',this);"><a href="#">Women</a><span>/</span></li>
                            <li onClick="return filter_friends('all',this);"><a href="#">All</a></li>
                        </ul>
                        <div class="search">
                            <span>Search:</span> 
                            	<input type="search" id="search_key" name="search_key" placeholder="Type name" onKeyup="filter_friends_keyword();" />
                        </div>
                    </div>
                    <!--</form>-->
                    <input type="hidden" name="max_selection" id="max_selection" value="<?php echo MAX_SELECTION_COUNT; ?>" />
                    <div class="fb-friends-list">
                        <div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
                        <div class="viewport" id="friends_list">
                            <ul class="overview">
                            	<?php if(isset($user_friends["data"])){ ?>
								<?php foreach($user_friends["data"] as $friends){ ?>
                                <?php
									$insFriends = "insert into ".TBL_FRIENDS." 
													(fb_user_id, fb_friend_id, name, first_name, last_name, gender) values 
													('".$user."','".$friends["id"]."','".$friends["name"]."','".$friends["first_name"]."',
													'".$friends["last_name"]."','".$friends["gender"]."')";
									$resFriends = mysql_query($insFriends);
									
									$selIsRequested = "select * from ".TBL_PROPOSAL." where fb_proposer='".$user."' and fb_acceptor='".$friends["id"]."'";
									$resIsRequested = mysql_query($selIsRequested);
									if(mysql_num_rows($resIsRequested)>0){
										$rowIsRequested = mysql_fetch_object($resIsRequested);
										if($rowIsRequested->is_success=='0'){
											$rtype = "Request";		
										}else{
											$rtype = "Link";	
										}
									}else{
										$rtype = "New";	
									}
									
								?>
                                <?php if($rtype=="Request" || $rtype=="Link"){ ?>
                                <script type="text/javascript">
								selected_friends.push('<?php echo $friends["id"]; ?>');
								</script>
								<?php } ?>
                                <li class="<?php echo $friends["gender"]; ?>" <?php if($friends["gender"]!=$oppGender){ ?> style="display:none;" <?php } ?> id="friend_<?php echo $friends["id"]; ?>">
                                    <div class="friend-details">
                                        <span><?php echo $friends["first_name"]." ".$friends["last_name"]; ?></span>
                                        <img alt="<?php echo $friends["first_name"]." ".$friends["last_name"]; ?>" src="https://graph.facebook.com/<?php echo $friends["id"]; ?>/picture?width=145&height=145" width="145" height="145" />
                                    </div>
                                    <?php if($rtype=="Request"){ ?>
                                    <a title="<?php echo $friends["id"]; ?>" class="noaction selected">Remove</a>
                                    <?php }else if($rtype=="Link"){ ?>
                                    <a title="<?php echo $friends["id"]; ?>" class="noaction selected">Remove</a>
                                    <?php }else{ ?>
                                    <a title="<?php echo $friends["id"]; ?>">Show Interest</a>
                                    <?php } ?>
                                </li>
                                <?php } } ?>
                            </ul>
                        </div>
                    </div>
                    <script type="text/javascript">
					$(window).load(function(){
						load_tinyscroll();	//alert("dsfasfas");
					});
					</script>
                    <div class="button-wrapper">
                        <div id="message_container"></div>
                        <input type="button" class="submit" value="Submit Selection" onClick="load_ajax_request();" />
                        
                    </div>
                </div>
            </section>
            <?php endif ?>
            <?php unset($friend_det); ?>
            <section>
                <div class="how-it-works">
                    <h2>How it works</h2>
                    <ul class="steps">
                        <li class="step-one">
                            <h3>1. Security</h3>
                            <p>Click on the button to Login to your Facebook account and accept to access your profile, friends and contact details.  <span>All data will be securely protected and will not be shared.</span></p>
                        </li>
                        <li class="step-two">
                            <h3>2. Privacy</h3>
                            <p>Select the friend(s) whom you want to express your interest from the Friends list by clicking 'Show Interest' button, then click 'Save'. <span>Selected friends will not be notified and we won't post anything on your wall. You can remove your selection any time.</span></p>
                        </li>
                        <li class="step-three">
                            <h3>3. Excitement</h3>
                            <p>Here's the exciting part; if the person you selected also shows interest in you through Frendcy, you both will get notified by email. <span>Isn't that great? All these information will be kept confidential.</span></p>
                        </li>
                    </ul>
                </div>
            </section>
            <section>
                <ul class="site-info-contact">
                    <li>
                        <h2>About</h2>
                        <p>Frendcy is the place where you secretly express your interest in someone and find out if the person is also interested in you. As the 'How it works' explains,  you can login to your Facebook account through Frendcy and from your list of friends you can choose either one or more friends you are interested in. The friend(s) you selected to show interest will not know until one of those friends also shows interest in you via Frendcy. Then you both will get notified via email.</p>
                        <p>We believe it's a great way to express your interest to someone without feeling embarrassed. We keep all your details very private and confidential. Frendcy won't automatically post anything on your wall without your permission. If you want get a quicker response from your Frendcy selections, we suggest you to post about frendcy.com on your wall and spread the word.</p>
                    </li>
                    <li>
                        <h2>Contact</h2>
                        <form id="contact_form" method="" action="" name="contact_form">
                            <ul>
                                <li>
                                    <label for="name">Name:</label>
                                    <input type="text" id="name" placeholder="Eg: Wayne" name="name" />
                                    <span class="form_hint">Proper format "name@something.com"</span>
                                </li>
                                <li>
                                    <label for="email">Email:</label>
                                    <input type="text" id="email"  placeholder="Eg: wayne@work.com" name="email" />
                                    <span class="form_hint">Proper format "name@something.com"</span>
                                </li>
                                <li>
                                    <label for="subject">Subject:</label>
                                    <input type="text" id="subject" placeholder="Eg: Thank you" name="subject" />
                                    <span class="form_hint">Proper format "name@something.com"</span>
                                </li>
                                <li>
                                    <label class="query" for="query">Query:</label>
                                    <textarea name="query" id="query" cols="30" rows="4" placeholder="Write what your query is about..."></textarea>
                                    <span class="form_hint">Proper format "name@something.com"</span>
                                </li>
                            </ul>
                            <div class="button-wrapper">
                                <div class="message-box error" id="error_message" style="display:none;">All fields required</div>
                                <div class="message-box" id="success_message" style="display:none;">Message Sent</div>
                                <input type="submit" value="Send">
                            </div>
                        </form>
                    </li>
                </ul>
            </section>
        </div>
        <div id="modal"></div>
        <div id="message-share" class="popup-container">
            <div class="popup">
                <div class="close-btn"></div>
                <div class="message-box">Your selection has been stored successfully<span>Check your junk mail if not received the confirmation</span></div>
                <h2>What's next?</h2>
                <h3>How to get a quicker response?</h3>
                <p>The friends you have selected may not already know about Frendcy, so what better way to get them to know than to spread the word via Facebook or Twitter. This way, you increase your chances of that secret admirer selecting you. So, Do you want share about Frendcy?</p>
                <ul class="decision">
                    <li class="yes"><a href="#" onClick="share_fb(); return false;">Yes</a></li>
                    <li class="no"><a href="#" onClick="closeOverlay(); return false;">NO</a></li>
                </ul>
            </div>
        </div>
        <footer>
            <nav>
                <ul>
                    <li><a href="<?php echo SITE_URL; ?>terms/">Terms &amp; Conditions</a></li>
                    <li><a href="<?php echo SITE_URL; ?>terms/">Cookie Policy</a></li>
                    <li><a href="<?php echo SITE_URL; ?>terms/">Privacy Policy</a></li>
                    <li class="social-icon"><a href="http://www.facebook.com/frendcy" target="_blank"><img alt="facebook share" src="images/icons/fb-share.png" /></a></li>
                    <li class="social-icon"><a href="http://www.twitter.com/frendcy" target="_blank"><img alt="twitter share" src="images/icons/twitter-share.png" /></a></li>
                </ul>
            </nav>
        </footer>
    </body>
</html>