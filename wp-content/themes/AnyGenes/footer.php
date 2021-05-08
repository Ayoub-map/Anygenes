<?php wp_footer(); ?>


<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KSCJB9G" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<style type="text/css">
	.tooltip {
		display: none;
		position: absolute;
		border: 1px solid #333;
		background-color: #161616;
		border-radius: 5px;
		padding: 10px;
		color: #fff;
		font-size: 12px Arial;
	}
</style>

<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<ul class="" style="float: right;">
				<a href="#TOP" class="masterTooltip TOPP" title="go to top">
					<i style="color:blue;" class="fa fa-arrow-circle-up fa-2x" aria-hidden="true"></i>
				</a>
			</ul>
		</div>
	</div>
</div>

<footer>
	<div class="top-footer">
		<span style="color:steelblue;font-size:12pt;font-weight:bold;margin-left:10%;"><i style="margin-right:10px;" class="fa fa-handshake-o" aria-hidden="true"></i> Some of our partners<br /><br />
		</span>
		<div id="owl-brand" class="owl-carousel">
			<div class="item">
				<img style="width:150px;height:50px;" src="<?php echo get_template_directory_uri() ?>/assets/img/inserm.jpg" alt="Inserm" class="img-fluid" />
			</div>
			<div class="item">
				<img style="width:150px;height:50px;" src="<?php echo get_template_directory_uri() ?>/assets/img/APHP.jpg" alt="Assistance Public Hôpitaux de Paris" class="img-fluid" />
			</div>
			<div class="item">
				<img style="width:150px;height:50px;" src="<?php echo get_template_directory_uri() ?>/assets/img/gustave-roussy.jpg" alt="Gustave Roussy" class="img-fluid" />
			</div>
			<div class="item">
				<img style="width:150px;height:50px;" src="<?php echo get_template_directory_uri() ?>/assets/img/universite-paris-descarte.jpeg" alt="universite paris descarte" class="img-fluid" />
			</div>
			<div class="item">
				<img style="width:150px;height:50px;" src="<?php echo get_template_directory_uri() ?>/assets/img/IFM.jpg" alt="ifm" class="img-fluid" />
			</div>
			<div class="item">
				<img style="width:150px;height:50px;" src="<?php echo get_template_directory_uri() ?>/assets/img/luxembourg-institute-health.jpg" alt="luxembourg institute health" class="img-fluid" />
			</div>
			<div class="item">
				<img style="width:150px;height:50px;" src="<?php echo get_template_directory_uri() ?>/assets/img/idipaz.jpg" alt="idipaz" class="img-fluid" />
			</div>
			<div class="item">
				<img style="width:150px;height:50px;" src="<?php echo get_template_directory_uri() ?>/assets/img/KERY.jpg" alt="KERY" class="img-fluid" />
			</div>
			<div class="item">
				<img style="width:150px;height:50px;" src="<?php echo get_template_directory_uri() ?>/assets/img/hospiatl-universitario-ramon-cajal.jpg" alt="hospiatl universitario ramon cajal" class="img-fluid" />
			</div>
		</div>
	</div>


	<div class="container-fluid">
		<div class="col-md-6 col-md-offset-1  col-xs-12 col-sm-8  col-sm-offset-1  ">
			<?php
			if (empty($_SESSION['nom'])) {
			?>
				<br />
				<h3 class="widget-title">Subscribe</h3>
				<p>
					Never miss any news published in our website. Subscribe to our newsletter now.
				</p>
				<p>
					Email address:
				</p>

			<?php } else { ?>
				<h3 class="widget-title">You are already Subscribed</h3>
			<?php }
			?>

			<form action="http://localhost/anygenes/register.php" method="POST">
				<?php
				if (empty($_SESSION['nom'])) {
				?>
					<input class="form-control form-control-sm" type="text" name="email" value="" size="40" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" placeholder="Your Email" required />
				<?php } else { ?>
					<input class="form-control form-control-sm" type="text" name="email" value="<?php echo $_SESSION['email'] ?>" size="40" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" required />
				<?php } ?>
				<input class="form-control form-control-sm" type="hidden" name="subscribe" value="subscribe" />
				<?php
				if (empty($_SESSION['nom'])) {
				?>
					<input type="submit" value="SUBSCRIBE" class="btn button button-subcribe btn-sm" />
				<?php } else { ?>
					<input style="margin:10px;" type="hidden" value="SUBSCRIBE" class="btn button button-subcribe" />
				<?php }
				?>
			</form>
		</div>
	</div>
	<br>


	<div class="copyright">
		<div class="" style="padding:10px;">
			Copyright © 2021 AnyGenes - Designed by <a href="http://localhost/anygenes" title="Efficient technologies for signaling pathways">AnyGenes</a>
			<ul class="quick-link">
				<li><a href="http://localhost/anygenes/tu.php">Terms of Use & Privacy Policy</a></li>
			</ul>
		</div>
	</div>
</footer>
<script>
	$(document).ready(function() {
		$("#owl-brand").owlCarousel({
			margin: 5,

			autoPlay: 3000,
			stopOnHover: true,
			items: 6,
			itemsDesktop: [1199, 4],
			itemsMobile: [479, 1],
			itemsTablet: [768, 2],
			itemsDesktopSmall: [979, 3],
			navigation: true,
			navigationText: ['<i class="fa fa-chevron-left fa-1x"></i>', '<i class="fa fa-chevron-right fa-1x"></i>'],
			pagination: false,
			responsive: true,
			itemsTablet: [768, 2],
			itemsTabletSmall: false,
			singleItem: false,

			responsiveClass: true,
			responsive: {
				0: {
					items: 1,
					nav: true
				},
				600: {
					items: 4,
					nav: true
				},
				1000: {
					items: 6,
					nav: true,

				}
			}
		});
	});
</script>
<script type="text/javascript">
	$('.masterTooltip').hover(function() {
		// Hover over code
		var title = $(this).attr('title');
		$(this).data('tipText', title).removeAttr('title');
		$('<p class="tooltip" style="font-size:12pt;"></p>')
			.text(title)
			.appendTo('body')
			.fadeIn('slow');
	}, function() {
		// Hover out code
		$(this).attr('title', $(this).data('tipText'));
		$('.tooltip').remove();
	}).mousemove(function(e) {
		var mousex = e.pageX - 110;
		var mousey = e.pageY - 25;
		$('.tooltip')
			.css({
				top: mousey,
				left: mousex
			})
	});

	$(document).ready(function() {
		// Popup Window
		var scrollTop = '';
		var newHeight = '100';

		$(window).bind('scroll', function() {
			scrollTop = $(window).scrollTop();
			newHeight = scrollTop + 100;
		});

		$('.popup-trigger').click(function(e) {
			e.stopPropagation();
			if (jQuery(window).width() < 767) {
				$(this).after($(".popup"));
				$('.popup').show().addClass('popup-mobile').css('top', 0);
				$('html, body').animate({
					scrollTop: $('.popup').offset().top
				}, 1000);
			} else {
				$('.popup').removeClass('popup-mobile').css('top', newHeight).toggle();
			};
		});

		$('html').click(function() {
			$('.popup').hide();
		});

		$('.popup-btn-close').click(function(e) {
			$('.popup').hide();
		});

		$('.popup').click(function(e) {
			e.stopPropagation();
		});

		$('.TOPP').click(function() {
			$('body,html').animate({
				scrollTop: 0
			}, 1000);
			return false;
		});
	});
</script>


</body>

</html>