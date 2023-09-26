<?php
ob_start();
session_start();

$server_url='https://print.bncc.ac.th/printStation';
$code=trim($_POST['code']);

if(is_numeric($code)){
    $code=$server_url.'/?p=ajax/print/api/json/id/'.$code;
}

$_SESSION['last_code']=$code;
?>
<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="icon" href="img/favicon.png" type="image/png">
        <title>BNCC:printStation</title>
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="vendors/linericon/style.css">
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" href="vendors/owl-carousel/owl.carousel.min.css">
        <link rel="stylesheet" href="vendors/lightbox/simpleLightbox.css">
        <link rel="stylesheet" href="vendors/nice-select/css/nice-select.css">
        <link rel="stylesheet" href="vendors/animate-css/animate.css">
        <link rel="stylesheet" href="vendors/flaticon/flaticon.css">
        <!-- main css -->
        <link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="css/responsive.css">
		<script>
			function order(){
				alert("นักเรียน-นักศึกษา ครู-อาจารย์ และบุคลากรทางการศึกษา ติดต่อขอใช้บริการได้ที่งานศูนย์ข้อมูลสารสนเทศ หรือที่ศูนย์บางนาอินเตอร์เน็ต");
			}
			</script>
    </head>
    <body>
        
        <!--================Header Menu Area =================-->
        <header class="header_area">
            <div class="main_menu">
            	<nav class="navbar navbar-expand-lg navbar-light">
					<div class="container box_1620">
						<!-- Brand and toggle get grouped for better mobile display -->
						<a class="navbar-brand logo_h" href="index.php"><img src="img/bnccweb_logo.png" alt="" width="100"></a>
						<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<!-- Collect the nav links, forms, and other content for toggling -->
						<div class="collapse navbar-collapse offset" id="navbarSupportedContent">
							<ul class="nav navbar-nav menu_nav justify-content-center">
								<li class="nav-item active"><a class="nav-link" href="index.html">หน้าหลัก</a></li> 
								<li class="nav-item"><a class="nav-link" href="#">เกี่ยวกับ</a></li> 
								<li class="nav-item"><a class="nav-link" href="https://web.bncc.ac.th:10000/">ระบบจัดการ</a>
								<li class="nav-item"><a class="nav-link" href="../phpmyadmin">phpMyAdmin</a>
							</ul>
							<ul class="nav navbar-nav navbar-right">
								<li class="nav-item"><a href="../printStation" onClick="order()" class="tickets_btn">ลงชื่อเข้าใช้</a></li>
							</ul>
						</div> 
					</div>
            	</nav>
            </div>
        </header>
        <!--================Header Menu Area =================-->
        
        <!--================Home Banner Area =================-->
        <section class="home_banner_area">
            <div class="banner_inner">
				<div class="container">
					<div class="row">
						<div class="col-lg-5">
							<div class="banner_content">
                            <div class="spinner-border"></div><h2>กำลังดำเนินการ</h2>
                                
                                <h3 id="printing_progress">กำลังเชื่อมต่อ Server...</h3>                              
							</div>
						</div>
						<div class="col-lg-7">
							<div class="home_left_img">
								<img class="img-fluid" src="images/brother_mfu_1.png" alt="">
							</div>
						</div>
					</div>
				</div>
            </div>
        </section>
        <!--================End Home Banner Area =================-->
        <!--================Footer Area =================-->
        <footer class="footer_area p_120">
        	<div class="container">
        		<div class="row footer_inner">
        			<div class="col-lg-5 col-sm-6">
        				<aside class="f_widget ab_widget">
        					<div class="f_title">
        						<h3>เกี่ยวกับเรา</h3>
        					</div>
        					<p>งานศูนย์ข้อมูลสารสนเทศ ฝ่ายแผนงานและความร่วมมือ </p>
        					<p><a href="http://www.bncc.ac.th" target="_blank">วิทยาลัยพณิชยการบางนา</a></p>
        				</aside>
        			</div>
        			<div class="col-lg-5 col-sm-6">
        				<aside class="f_widget news_widget">
        					<div class="f_title">
        						<h3>รับข่าวสาร</h3>
        					</div>
        					<p>รับจดหมายอิเล็กทรอนิกส์</p>
        					<div id="mc_embed_signup">
                                <form target="_blank" action="news.php" method="get" class="subscribe_form relative">
                                	<div class="input-group d-flex flex-row">
                                        <input name="EMAIL" placeholder="Enter email address" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email Address '" required="" type="email">
                                        <button class="btn sub-btn"><span class="lnr lnr-arrow-right"></span></button>		
                                    </div>				
                                    <div class="mt-10 info"></div>
                                </form>
                            </div>
        				</aside>
        			</div>
        			<div class="col-lg-2">
        				<aside class="f_widget social_widget">
        					<div class="f_title">
        						<h3>ติดตามเรา</h3>
        					</div>
        					<p>บนโซเชียลมีเดีย</p>
        					<ul class="list">
        						<li><a href="#"><i class="fa fa-facebook"></i></a></li>
        						<li><a href="#"><i class="fa fa-twitter"></i></a></li>
        						<li><a href="#"><i class="fa fa-dribbble"></i></a></li>
        						<li><a href="#"><i class="fa fa-behance"></i></a></li>
        					</ul>
        				</aside>
        			</div>
        		</div>
        	</div>
        </footer>
        <!--================End Footer Area =================-->
        
        
        
        
        
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="js/jquery-3.2.1.min.js"></script>
        <script src="js/popper.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/stellar.js"></script>
        <script src="vendors/lightbox/simpleLightbox.min.js"></script>
        <script src="vendors/nice-select/js/jquery.nice-select.min.js"></script>
        <script src="vendors/isotope/imagesloaded.pkgd.min.js"></script>
        <script src="vendors/isotope/isotope-min.js"></script>
        <script src="vendors/owl-carousel/owl.carousel.min.js"></script>
        <script src="js/jquery.ajaxchimp.min.js"></script>
        <script src="vendors/counter-up/jquery.waypoints.min.js"></script>
        <script src="vendors/counter-up/jquery.counterup.min.js"></script>
        <script src="js/mail-script.js"></script>
        <!--gmaps Js-->
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjCGmQ0Uq4exrzdcL6rvxywDDOvfAu6eE"></script>
        <script src="js/gmaps.min.js"></script>
        <script src="js/theme.js"></script>
	</body>
	<script>
		$(function(){
            $("#printing_progress").load("./fetch_data.php",
            function(responseTxt, statusTxt, xhr){
                load_doc();
            });
			
		});

        function load_doc(){
            $("#printing_progress").load("./load_doc.php?f=xx",
            function(responseTxt, statusTxt, xhr){
                print_temp();
            });
        }

        function print_temp(){
            $("#printing_progress").load("./print_temp.php",
            function(responseTxt, statusTxt, xhr){
                setInterval(goHome,2000);
            });
        }

        function goHome(){
            $(location).attr('href','./index.php');
        }
	</script>
</html>