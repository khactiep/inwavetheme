<?php
   /*
   Plugin Name: Joomla Plugin
   Plugin URI:
   Description: Demo Plugin
   Version: 1.2
   Author: Mr.KhacTiep
   Author URI:
   License: GPL2
   */
	 function header_shortcode_function(){ ?>
	 
		<header style="font-family: timenewroman">
			<div class="top">
				<div class="container">
					<div class="topleft">
						<ul>
							<li><a href="<?php the_permalink(210);?>">Home</a></li>
							<li><a href="https://bowthemes.com/affiliate/">Affiliates</a></li>
						</ul>
					</div>
					<div class="topright">
						<ul>
							<li><a href="#">LOG IN</a></li>
							<li><a href="#">REGISTER</a></li>
						</ul>
					</div>
				</div>
			</div>
			
			<nav class="navbar navbar-inverse" style="background-color: black; margin-bottom: 0;border-radius:0">
				<div class="container">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar" style="border: none; position: absolute; top: 28px; right: 0">
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>                        
						</button>
						<a class="navbar-brand" href="<?php the_permalink(210);?>" target="blank"><img src="<?php bloginfo('template_url')?>/BT/joomla.png"></a>
					</div>
					
						<a href="#"><div class="cartbtn" style="font-size:12px"><span class="fa fa-cart-plus"></span> &nbsp Go to cart</div></a>
						
					<div class="collapse navbar-collapse" id="myNavbar">
						<ul class="nav navbar-nav">
							<li><a class="active" href="#">Home</a></li>
							<li><a href="#">Joomla Templates</a></li>
							<li><a href="#">Joola Extensions</a></li>
							<li><a href="#">Parcing</a></li>
							<li><a href="#">Our Blog</a></li>
							<li><a href="#">Support</a></li>
							<li><a href="#">Contact</a></li>
						</ul>
					</div>
					
				</div>
			</nav>
		</header>
		<?php
	 }
	function bthosting_shortcode_function (){?>
	
			<div style="font-family: timenewroman">
				<div class="container-fluid" style="background-color:aqua; padding-top:50px; padding-bottom: 320px">
					<center>
						<h1>BT HOSTING</h1>
						<h3>RESPONSIVE TEMPLATE FOR HOSTING AND CORPORATE</h3>
						<br>
						<div title="Template Detail"><a href="<?php the_permalink(194);?>" style="display:block" onmouseover="fc1()" id="check1">CHECK IT OUT</a></div>
						<div title="Template Detail"><a href="<?php the_permalink(194);?>" style="display:none" onmouseout="fc2()" id="check2" class="fa fa-arrow-circle-right"></a></div>
					</center>
				</div>
				<script>
					function fc1(){
						document.getElementById("check2").style.display="block";
						document.getElementById("check1").style.display="none";
					}
					function fc2(){
						document.getElementById("check1").style.display="block";
						document.getElementById("check2").style.display="none";
					}
				</script>
				
				<div class="abc">
					<img style="margin-top: -20%; margin-left: 33%; width: 38%; box-shadow: 0 10px 20px grey;z-index:1;position: relative" src="<?php bloginfo('template_url')?>/BT/c1.png">
					<img style="margin-top: -30%; margin-left: 15%; width: 38%; box-shadow: 0 10px 20px grey" src="<?php bloginfo('template_url')?>/BT/c2.png">
					<img style="margin-top: -30%; margin-left: 51%; width: 38%; box-shadow: 0 10px 20px grey" src="<?php bloginfo('template_url')?>/BT/c3.png">
				</div>
				
				<div class="container-fluid" style="background-color:white; padding:50px">
					<center>
						<h2>WE SPECIALISE IN MAKING BEAUTIFUL JOOMLATEMPLATES</h2>
						<h5>Powerful Joomla Tempaltes and Joomla Extensions for running seriuos business</h5>
						<br>
						<div class="box2ab">
						<a href="<?php the_permalink(192);?>" class="box2a">Joomla Templates</a>
						<a href="<?php the_permalink(186);?>" class="box2b">Joomla Extensions</a>
						</div>
					</center>
				</div>
			</div>
	<?php
	}
	function templates_shortcode_function(){ ?>
			<div style="font-family: timenewroman">
				<div class="container-fluid" style="background-color:beige; padding:50px">
					<center>
						<h2>LATEST JOOMLA TEMPLATES</h2>
						<h4>Browses and download all our templates only 59$. Join our Club members!</h4>
						<br>
						<div class="row" id="slide1" style="display:block">
							<div class="col-sm-3" style="padding-top:10px"><a href="<?php the_permalink(194);?>" target="blank"><?php echo get_the_post_thumbnail(194)?></a></div>
							<div class="col-sm-3" style="padding-top:10px"><a href="<?php the_permalink(196);?>" target="blank"><?php echo get_the_post_thumbnail(196)?></a></div>
							<div class="col-sm-3" style="padding-top:10px"><a href="<?php the_permalink(198);?>" target="blank"><?php echo get_the_post_thumbnail(198)?></a></div>
							<div class="col-sm-3" style="padding-top:10px"><a href="<?php the_permalink(200);?>" target="blank"><?php echo get_the_post_thumbnail(200)?></a></div>
						</div>
						<div class="row" id="slide2" style="display:none">
							<div class="col-sm-3" style="padding-top: 10px"><a href="<?php the_permalink(202);?>" target="blank"><?php echo get_the_post_thumbnail(202)?></a></div>
							<div class="col-sm-3" style="padding-top: 10px"><a href="<?php the_permalink(204);?>" target="blank"><?php echo get_the_post_thumbnail(204)?></a></div>
							<div class="col-sm-3" style="padding-top: 10px"><a href="<?php the_permalink(206);?>" target="blank"><?php echo get_the_post_thumbnail(206)?></a></div>
							<div class="col-sm-3" style="padding-top: 10px"><a href="<?php the_permalink(208);?>" target="blank"><?php echo get_the_post_thumbnail(208)?></a></div>
						</div>
						<br>
					<div class="btnbox">
						<div class="prebtn" onclick="fc()">&#10094;</div>
						<div class="nextbtn" onclick="fc()">&#10095;</div>
					</div>
					</center>
			
				</div>
				<script>
					function fc(){
						if (document.getElementById("slide1").style.display=="none"){
							document.getElementById("slide1").style.display="block";
							document.getElementById("slide2").style.display="none";
						} else {
							document.getElementById("slide2").style.display="block";
							document.getElementById("slide1").style.display="none";
						}
					}
				</script>
			</div>
		
	<?php
	}
	function extensions_shortcode_function(){?>
	
	
			<div style="font-family: timenewroman">
				<div class="container-fluid" style="background-color:white; padding:50px">
					<center>
						<h3>LATEST EXTENSIONS</h3>
						<h5>Browses and download all our extensions only 59$. Join our Club members!</h5>
						<br>
						<br>
						<div class="row">
							
							<div class="col-sm-3"><a href="<?php the_permalink(88);?>"><div class="box"><img src="<?php bloginfo('template_url')?>/BT/a1.png" style="width:80px"></div></a>
								<a href="<?php the_permalink(88);?>" style="text-decoration: none"><h6>BT PRODUCT QUICKVIEW</h6></a>
								<div class="boxm" style="background-color:red">P</div>
								<div class="boxm" style="background-color:violet">2.5</div>
								<div class="boxm" style="background-color:orange">3.X</div>
							</div>
							<div class="col-sm-3"><a href="<?php the_permalink(95);?>"><div class="box"><img src="<?php bloginfo('template_url')?>/BT/a2.png" style="width:80px"></div></a>
								<a href="<?php the_permalink(95);?>" style="text-decoration: none"><h6>BT SIMPLE SLIDESHOW</h6></a>
								<div class="boxm" style="background-color:green">M</div>
								<div class="boxm" style="background-color:violet">2.5</div>
								<div class="boxm" style="background-color:orange">3.X</div>
							</div>
							<div class="col-sm-3"><a href="<?php the_permalink(206);?>"><div class="box"><img src="<?php bloginfo('template_url')?>/BT/a3.png" style="width:80px"></div></a>
								<a href="<?php the_permalink(206);?>" style="text-decoration: none"><h6>BT PROPERTY COMPONENT</h6></a>
								<div class="boxm" style="background-color:red">P</div>
								<div class="boxm" style="background-color:violet">2.5</div>
								<div class="boxm" style="background-color:orange">3.X</div>
							</div>
							<div class="col-sm-3"><a href="<?php the_permalink(98);?>"><div class="box"><img src="<?php bloginfo('template_url')?>/BT/a4.png" style="width:80px"></div></a>
								<a href="<?php the_permalink(98);?>" style="text-decoration: none"><h6>BT SHORTCODE</h6></a>
								<div class="boxm" style="background-color:green">M</div>
								<div class="boxm" style="background-color:blue">C</div>
								<div class="boxm" style="background-color:red">P</div>
								<div class="boxm" style="background-color:violet">2.5</div>
								<div class="boxm" style="background-color:orange">3.X</div>
							</div>
						</div>
					</center>
				</div>
			</div>
	<?php
	}
	function advice_shortcode_function(){?>
			<div style="font-family: timenewroman">
				<div class="container-fluid" style="background-color:beige; padding:50px">
					
						
						<div class="row">
							<div class="col-sm-3" style="margin-top:20px">
								<h3>WHAT’S OUR EXPERT ADVICES ?</h3>
								<p>We share our experience and put all of them in this Website Development Tutorials section.
								Here, you get information about web development tools, resources or the way to build a nice website.</p>
							</div>
							<div class="col-sm-3" style="margin-top:20px"><a href="<?php the_permalink(63);?>"><?php echo get_the_post_thumbnail(55)?></a><br><br>
								<a href="<?php the_permalink(55);?>" style="color:blue; text-decoration: none">10 things you need to know about Joomla SEO</a><hr color="blue">
								<p>SEO - or Search Engine Optimization - is a complex area of web development.
								I've been working with SEO for a number of years, and with Joomla and SEO for almost 4 years now.
								In this post, I talk about ten important factors you should consider when optimizing your site.</p>
								<a href="<?php the_permalink(55);?>" target="blank" style="color: blue; text-decoration: none" class="fa fa-arrow-circle-right"> Read More</a>
							</div>
							<div class="col-sm-3" style="margin-top:20px"><a href="<?php the_permalink(63);?>"><?php echo get_the_post_thumbnail(60)?></a><br><br>
								<a href="<?php the_permalink(60);?>" style="color:blue; text-decoration: none">Best of free Joomla Templates</a><br><hr color="blue">
								<p>Finding a great template for your Joomla site can be a challenge.
								There are tons of free Joomla templates out there, but to be honest: Most of them are junk.
								Finding quality free Joomla templates is important to ensure you can work smoothly with the content, modules and other extensions you want to include.</p>
								<a href="<?php the_permalink(60);?>" target="blank" style="color: blue; text-decoration: none" class="fa fa-arrow-circle-right"> Read More</a>
							</div>
							<div class="col-sm-3" style="margin-top:20px"><a href="<?php the_permalink(63);?>"><?php echo get_the_post_thumbnail(63)?></a><br><br>
								<a href="<?php the_permalink(63);?>" style="color:blue; text-decoration: none">How to Speed Up Your Joomla Website</a><br><hr color="blue">
								<p>The speed at which your site loads is very important. Firstly, a fast loading site will have your readers stick around longer.
								If they are served content fast, it is more tempting to click on another link to read more.
								Nobody wants to wait for a slow site.</p>
								<a href="<?php the_permalink(63);?>" target="blank" style="color: blue; text-decoration: none" class="fa fa-arrow-circle-right"> Read More</a>
							</div>
						</div>
						
				</div>
			</div>
	<?php
	}
	function footer_shortcode_function(){?>
		<div style="font-family: timenewroman">
			<footer>
				
				<div class="ftop">
					<div class="container">
						<div class="row">
						<div class="col-sm-4 ftopleft">
							Copyright &copy; 2011 <a style="text-decoration:none; color: #2a8493" href="<?php the_permalink(210);?>">BowThemes</a>. All right reserved.
						</div>
						<div class="col-sm-8 ftopright">
						<center>
						<ul>
							<li><a href="http://bowthemes.com/frequently-asked-questions">FAQs</a></li>
							<li><a href="http://bowthemes.com/privacy-policy.html">Privacy Policy</a></li>
							<li><a href="http://bowthemes.com/support-policy.html">Support Policy</a></li>
							<li><a href="http://bowthemes.com/terms-and-conditions.html">Terms and Conditions</a></li>
							<li><a href="http://bowthemes.com/affiliate-program-terms-and-conditions.html">Affiliate Terms and Conditions</a></li>
							<li><a href="https://bowthemes.com/affiliate/">Affiliate</a></li>
						</ul>
						</center>
						</div>
						</div>
					</div>
				
				<hr>
					<div class="container" style="padding: 10px 0px 50px 0px">
						<div class="row">
						<div class="fbtleft col-sm-7">
						<p style="font-size:11px; color:white">
							The Joomla! ® name and logo is used under a limited license from Open Source Matters in the United States and other countries.
						</p>
						
						<p style="font-size:11px; color: white">
							BowThemes.com is not affiliated with or endorsed by Open Source Matters or the Joomla! Project.
						</p>
						</div>
						<div class="col-sm-5">
						<center>
						<p style="font-size:11px; color:white">Join our social network to get latest updateds</p>
						<div class="icon">
							<a href="https://www.facebook.com/bowthemes" target="blank"class="fbox fa fa-facebook" style="font-size:14px; color:white"></a>			
							<a href="https://twitter.com/bowthemes" target="blank" class="fbox fa fa-twitter" style="font-size:14px; color:white"></a>			
							<a href="https://www.youtube.com/user/bowthemes" target="blank" class="fbox fa fa-youtube" style="font-size:14px; color:white"></a>			
							<a href="https://www.linkedin.com/company/bowthemes" target="blank" class="fbox fa fa-linkedin" style="font-size:14px; color:white"></a>			
						</div>
						</center>
						</div>
						</div>
					</div>
				</nav>
				
			</footer>
		</div>
	<?php
	}
	add_shortcode( 'header_shortcode', 'header_shortcode_function' );
	add_shortcode( 'bthosting_shortcode', 'bthosting_shortcode_function' );
	add_shortcode( 'templates_shortcode', 'templates_shortcode_function' );
	add_shortcode( 'extensions_shortcode', 'extensions_shortcode_function' );
	add_shortcode( 'advice_shortcode', 'advice_shortcode_function' );
	add_shortcode( 'footer_shortcode', 'footer_shortcode_function' );
?>