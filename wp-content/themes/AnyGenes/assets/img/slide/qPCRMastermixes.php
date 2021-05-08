<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->
<head>

    <!-- Basic Page Needs
  ================================================== -->
	<meta charset="utf-8">
	<title>AnyGenes : Products</title>
	<meta name="description" content="Products">
	<meta name="author" content="www.anygenes.com">
	
    <!-- Mobile Specific Metas
	================================================== -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    
    <!-- CSS
	================================================== -->
  	<link rel="stylesheet" href="css/zerogrid.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/responsiveslides.css">
	
	<!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	
	<!-- Owl Carousel Assets -->
    <link href="owl-carousel/owl.carousel.css" rel="stylesheet">
    <!-- <link href="owl-carousel/owl.theme.css" rel="stylesheet"> -->
	
	<link rel="stylesheet" href="css/menu.css">
	<script src="js/jquery183.min.js"></script>
	<script src="js/script.js"></script>
	
	<script src="js/jquery-latest.min.js"></script>
	<script src="js/responsiveslides.min.js"></script>

<!-- timeline news -->

    <script>
		// You can also use "$(window).load(function() {"
		$(function () {
		  // Slideshow 
		  $("#slider").responsiveSlides({
			auto: true,
			pager: false,
			nav: true,
			speed: 500,
			namespace: "callbacks",
			before: function () {
			  //$('.events').append("<li>before event fired.</li>");
			},
			after: function () {
			  //$('.events').append("<li>after event fired.</li>");
			}
		  });
		});
	</script>
</head>
<body class="home-page">
	<div class="wrap-body">
		<header >
			<?php include('head.php');?>
		</header>
		<!--////////////////////////////////////Container Products -->
				<section class="content-box boxstyle-2 box-4">

					<div class="zerogrid">
						<div class="row wrap-box"><!--Start Box-->
							<div class="crumbs" style="margin-bottom:15px;">
									<ul>
										<li><a href="products.php">Products</a></li>
										<li><a href="#">qPCR Master Mixes</a></li>
									</ul>
								</div>
							<div class="row">
								<div class="col-1-2" >
									<div class="wrap-col">
										<div class="box-item">
											<div class="zoom-container">
												<img src="images/signalingPathway2.png" />
											</div>
											<div class="box-item-content">
												<a href="signalingPathways.php">Signaling Pathways</a>
												<p>
													Select your SignArrays to analyze your <br/>
													favorite signaling pathways in less than <br/>3 hours !
												</p>
											</div>
										</div>
									</div>
								</div>
								<div class="col-1-2" >
									<div class="wrap-col">
										<div class="box-item">
											<div class="zoom-container">
												<img src="images/qPCRMasterMix.png">
											</div>
											<div class="box-item-content">
												<a href="qPCRMastermixes">qPCR Master Mixes</a>
												<p>
													Improve your results with our very efficient 
													and sensitive Perfect MasterMix SYBR Green® or PROBE !
												</p>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>

				<!-----------------content-box-3-------------------->
				<section class="content-box box-3">
					<div class="zerogrid">
						<div class="row wrap-box"><!--Start Box-->
							<div class="header">
								<div class="wrapper">
									<h2>PRODUCTS</h2>
									<hr class="line" style="max-width:130px;">
									<div class="intro"><a href="#"> Explore all the products</a></div>
								</div>
							</div>
						</div>
					</div>
				</section>
		<!--////////////////////////////////////Footer-->
		<?php include('footer.php');?>
	</div>
	
	<!-- carousel -->
    <script>
    $(document).ready(function() {
      $("#owl-brand").owlCarousel({
        autoPlay: 3000,
        items : 6,
		itemsDesktop : [1199,4],
        itemsDesktopSmall : [979,2],
		navigation: true,
		navigationText: ['<i class="fa fa-chevron-left fa-5x"></i>', '<i class="fa fa-chevron-right fa-5x"></i>'],
		pagination: false
      });
    });
    </script>
<!-- news timeline -->
<script src="newstimeline/jstimeline/jquery.mobile.custom.min.js"></script>
<script src="newstimeline/jstimeline/main.js"></script> <!-- Resource jQuery -->
</body>
</html>