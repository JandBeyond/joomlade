<body class="no-trans front-page transparent-header <?php echo (($isFrontpage) ? ('front') : ('page')).' '.$active_alias.' '.$pageclass; ?>">
<!-- scrollToTop -->
<!-- ================ -->
<div class="scrollToTop circle"><i class="icon-up-open-big"></i></div>

<div class="page-wrapper">
	<!-- header-container start -->
	<div class="header-container">

		<!-- header-top start -->
		<!-- classes:  -->
		<!-- "dark": dark version of header top e.g. class="header-top dark" -->
		<!-- "colored": colored version of header top e.g. class="header-top colored" -->
		<!-- ================ -->
		<div class="header-top colored ">
			<div class="container">
				<div class="row">
					<div class="col-xs-3 col-sm-6 col-md-9">
						<!-- header-top-first start -->
						<!-- ================ -->
						<div class="header-top-first clearfix">
							<?php $pos='social-links-top';
								if ($this->countModules($pos)): ?>
								<jdoc:include type="modules" name="<?php echo $pos; ?>" style="none"/>
							<?php endif;?>
							<?php $pos='address-top';
							if ($this->countModules($pos)): ?>
								<jdoc:include type="modules" name="<?php echo $pos; ?>" style="none"/>
							<?php endif;?>
						</div>
						<!-- header-top-first end -->
					</div>
					<div class="col-xs-9 col-sm-6 col-md-3">

						<!-- header-top-second start -->
						<!-- ================ -->
						<div id="header-top-second"  class="clearfix">

							<!-- header top dropdowns start -->
							<!-- ================ -->
							<div class="header-top-dropdown text-right">
								<div class="btn-group">
									<a href="#" class="btn btn-default btn-sm"><i class="fa fa-user pr-10"></i> Sign Up</a>
								</div>
								<div class="btn-group dropdown">
									<button type="button" class="btn dropdown-toggle btn-default btn-sm" data-toggle="dropdown"><i class="fa fa-lock pr-10"></i> Login</button>
									<ul class="dropdown-menu dropdown-menu-right dropdown-animation">
										<li>
											<form class="login-form margin-clear">
												<div class="form-group has-feedback">
													<label class="control-label">Username</label>
													<input type="text" class="form-control" placeholder="">
													<i class="fa fa-user form-control-feedback"></i>
												</div>
												<div class="form-group has-feedback">
													<label class="control-label">Password</label>
													<input type="password" class="form-control" placeholder="">
													<i class="fa fa-lock form-control-feedback"></i>
												</div>
												<button type="submit" class="btn btn-gray btn-sm">Log In</button>
												<span class="pl-5 pr-5">or</span>
												<button type="submit" class="btn btn-default btn-sm">Sing Up</button>
												<ul>
													<li><a href="#">Forgot your password?</a></li>
												</ul>
												<span class="text-center">Login with</span>
												<ul class="social-links circle small colored clearfix">
													<li class="facebook"><a target="_blank" href="http://www.facebook.com"><i class="fa fa-facebook"></i></a></li>
													<li class="twitter"><a target="_blank" href="http://www.twitter.com"><i class="fa fa-twitter"></i></a></li>
													<li class="googleplus"><a target="_blank" href="http://plus.google.com"><i class="fa fa-google-plus"></i></a></li>
												</ul>
											</form>
										</li>
									</ul>
								</div>
							</div>
							<!--  header top dropdowns end -->
						</div>
						<!-- header-top-second end -->
					</div>
				</div>
			</div>
		</div>
		<!-- header-top end -->

		<!-- header start -->
		<!-- classes:  -->
		<!-- "fixed": enables fixed navigation mode (sticky menu) e.g. class="header fixed clearfix" -->
		<!-- "dark": dark version of header e.g. class="header dark clearfix" -->
		<!-- "full-width": mandatory class for the full-width menu layout -->
		<!-- "centered": mandatory class for the centered logo layout -->
		<!-- ================ -->
		<header class="header fixed clearfix">

			<div class="container">
				<div class="row">
					<div class="col-md-2">
						<!-- header-left start -->
						<!-- ================ -->
						<div class="header-left clearfix">

							<?php $pos='logo';if ($this->countModules($pos)): ?>
							<!-- logo -->
							<div id="logo" class="logo">
								<jdoc:include type="modules" name="<?php echo $pos; ?>" style="none"/>
							</div>
							<?php endif;?>

							<?php $pos='slogan';if ($this->countModules($pos)): ?>
							<div class="site-slogan">
								<jdoc:include type="modules" name="<?php echo $pos; ?>" style="none"/>
							</div>
							<!-- name-and-slogan -->
							<?php endif;?>

						</div>
						<!-- header-left end -->

					</div>
					<div class="col-md-10">

						<!-- header-right start -->
						<!-- ================ -->
						<div class="header-right clearfix">

							<!-- main-navigation start -->
							<!-- classes: -->
							<!-- "onclick": Makes the dropdowns open on click, this the default bootstrap behavior e.g. class="main-navigation onclick" -->
							<!-- "animated": Enables animations on dropdowns opening e.g. class="main-navigation animated" -->
							<!-- "with-dropdown-buttons": Mandatory class that adds extra space, to the main navigation, for the search and cart dropdowns -->
							<!-- ================ -->
							<div class="main-navigation  animated with-dropdown-buttons">

								<!-- navbar start -->
								<!-- ================ -->
								<nav class="navbar navbar-default" role="navigation">
									<div class="container-fluid">

										<!-- Toggle get grouped for better mobile display -->
										<div class="navbar-header">
											<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-1">
												<span class="sr-only">Toggle navigation</span>
												<span class="icon-bar"></span>
												<span class="icon-bar"></span>
												<span class="icon-bar"></span>
											</button>

										</div>

										<!-- Collect the nav links, forms, and other content for toggling -->
										<div class="collapse navbar-collapse" id="navbar-collapse-1">
											<?php $pos='main-menu';if ($this->countModules($pos)): ?>
											<!-- main-menu -->
											<jdoc:include type="modules" name="<?php echo $pos; ?>" style="none"/>
											<?php endif;?>
											<!-- main-menu end -->

											<?php $pos='search';
											if ($this->countModules($pos)): ?>
												<!-- header dropdown buttons -->
												<jdoc:include type="modules" name="<?php echo $pos; ?>" style="none"/>
												<!-- header dropdown buttons end-->
											<?php endif;?>


										</div>

									</div>
								</nav>
								<!-- navbar end -->

							</div>
							<!-- main-navigation end -->
						</div>
						<!-- header-right end -->

					</div>
				</div>
			</div>

		</header>
		<!-- header end -->
	</div>
	<!-- header-container end -->
	<?php $pos='breadcrumb';
	if ($this->countModules($pos)): ?>
	<!-- breadcrumb start -->
	<!-- ================ -->
	<div class="breadcrumb-container">
		<div class="container">
			<jdoc:include type="modules" name="<?php echo $pos; ?>" style="none"/>
		</div>
	</div>
	<!-- breadcrumb end -->
	<?php endif;?>
	<!-- main-container start -->
	<!-- ================ -->
	<section class="main-container">
		<div class="container">
			<div class="row">

				<div class="<?php echo $contentclass; ?>">
					<?php $pos='inner-top'; ?>
					<?php if ($this->countModules($pos)): ?>
						<!-- <?php echo $pos; ?> -->
						<div class="row <?php echo $pos; ?>">
							<jdoc:include type="modules" name="<?php echo $pos; ?>" style="joomlade"/>
						</div><!-- div.row -->
					<?php endif;?>
					<?php if (!$showsystemoutput) : ?>
						<jdoc:include type="message" />
						<!-- Component Start -->
						<jdoc:include type="component" />
						<!-- Component End -->
					<?php endif; ?>
					<?php $pos='inner-bottom'; ?>
					<?php if ($this->countModules($pos)): ?>
						<!-- <?php echo $pos; ?> -->
						<div class="row <?php echo $pos; ?>">
							<jdoc:include type="modules" name="<?php echo $pos; ?>" style="joomlade"/>
						</div><!-- div.row -->
					<?php endif;?>
				</div><!-- .main -->


				<?php $pos='sidebar-a'; ?>
				<?php if ($this->countModules($pos)): ?>
					<!-- <?php echo $pos; ?> -->
					<aside class="<?php echo $sidebar_a; ?> <?php echo $pos; ?>">
						<div class="sidebar">
							<jdoc:include type="modules" name="<?php echo $pos; ?>" style="sidebar"/>
						</div><!-- div.row -->
					</aside><!-- .<?php echo $pos; ?> -->
				<?php endif;?>

				<?php $pos='sidebar-b'; ?>
				<?php if ($this->countModules($pos)): ?>
					<!-- <?php echo $pos; ?> -->
					<aside class="<?php echo $sidebar_b; ?> <?php echo $pos; ?>">
						<div class="sidebar">
							<jdoc:include type="modules" name="<?php echo $pos; ?>" style="sidebar"/>
						</div><!-- div.row -->
					</aside><!-- .<?php echo $pos; ?> -->
				<?php endif;?>
			</div>
		</div>
	</section>
	<!-- main-container end -->

	<!-- footer top start -->
	<!-- ================ -->
	<div class="dark-bg  default-hovered footer-top animated-text">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="call-to-action text-center">
						<div class="row">
							<div class="col-sm-8">
								<h2>Powerful Bootstrap Template</h2>
								<h2>Waste no more time</h2>
							</div>
							<div class="col-sm-4">
								<p class="mt-10"><a href="#" class="btn btn-animated btn-lg btn-gray-transparent ">Purchase<i class="fa fa-cart-arrow-down pl-20"></i></a></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- footer top end -->

	<!-- footer start (Add "dark" class to #footer in order to enable dark footer) -->
	<!-- ================ -->
	<footer id="footer" class="clearfix ">

		<!-- .footer start -->
		<!-- ================ -->
		<div class="footer">
			<div class="container">
				<div class="footer-inner">
					<div class="row">
						<div class="col-md-3">
							<div class="footer-content">
								<div class="logo-footer"><img id="logo-footer" src="images/logo_light_blue.png" alt=""></div>
								<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Necessitatibus illo vel dolorum soluta consectetur doloribus sit. Delectus non tenetur odit dicta vitae debitis suscipit doloribus. Ipsa, aut voluptas quaerat... <a href="page-about.html">Learn More<i class="fa fa-long-arrow-right pl-5"></i></a></p>
								<div class="separator-2"></div>
								<nav>
									<ul class="nav nav-pills nav-stacked">
										<li><a target="_blank" href="http://htmlcoder.me/support">Support</a></li>
										<li><a href="#">Privacy</a></li>
										<li><a href="#">Terms</a></li>
										<li><a href="page-about.html">About</a></li>
									</ul>
								</nav>
							</div>
						</div>
						<div class="col-md-3">
							<div class="footer-content">
								<h2 class="title">Latest From Blog</h2>
								<div class="separator-2"></div>
								<div class="media margin-clear">
									<div class="media-left">
										<div class="overlay-container">
											<img class="media-object" src="images/blog-thumb-1.jpg" alt="blog-thumb">
											<a href="blog-post.html" class="overlay-link small"><i class="fa fa-link"></i></a>
										</div>
									</div>
									<div class="media-body">
										<h6 class="media-heading"><a href="blog-post.html">Lorem ipsum dolor sit amet...</a></h6>
										<p class="small margin-clear"><i class="fa fa-calendar pr-10"></i>Mar 23, 2015</p>
									</div>
									<hr>
								</div>
								<div class="media margin-clear">
									<div class="media-left">
										<div class="overlay-container">
											<img class="media-object" src="images/blog-thumb-2.jpg" alt="blog-thumb">
											<a href="blog-post.html" class="overlay-link small"><i class="fa fa-link"></i></a>
										</div>
									</div>
									<div class="media-body">
										<h6 class="media-heading"><a href="blog-post.html">Lorem ipsum dolor sit amet...</a></h6>
										<p class="small margin-clear"><i class="fa fa-calendar pr-10"></i>Mar 22, 2015</p>
									</div>
									<hr>
								</div>
								<div class="media margin-clear">
									<div class="media-left">
										<div class="overlay-container">
											<img class="media-object" src="images/blog-thumb-3.jpg" alt="blog-thumb">
											<a href="blog-post.html" class="overlay-link small"><i class="fa fa-link"></i></a>
										</div>
									</div>
									<div class="media-body">
										<h6 class="media-heading"><a href="blog-post.html">Lorem ipsum dolor sit amet...</a></h6>
										<p class="small margin-clear"><i class="fa fa-calendar pr-10"></i>Mar 21, 2015</p>
									</div>
									<hr>
								</div>
								<div class="media margin-clear">
									<div class="media-left">
										<div class="overlay-container">
											<img class="media-object" src="images/blog-thumb-4.jpg" alt="blog-thumb">
											<a href="blog-post.html" class="overlay-link small"><i class="fa fa-link"></i></a>
										</div>
									</div>
									<div class="media-body">
										<h6 class="media-heading"><a href="blog-post.html">Lorem ipsum dolor sit amet...</a></h6>
										<p class="small margin-clear"><i class="fa fa-calendar pr-10"></i>Mar 21, 2015</p>
									</div>
								</div>
								<div class="text-right space-top">
									<a href="blog-large-image-right-sidebar.html" class="link-dark"><i class="fa fa-plus-circle pl-5 pr-5"></i>More</a>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="footer-content">
								<h2 class="title">Portfolio Gallery</h2>
								<div class="separator-2"></div>
								<div class="row grid-space-10">
									<div class="col-xs-4 col-md-6">
										<div class="overlay-container mb-10">
											<img src="images/gallery-1.jpg" alt="">
											<a href="portfolio-item.html" class="overlay-link small">
												<i class="fa fa-link"></i>
											</a>
										</div>
									</div>
									<div class="col-xs-4 col-md-6">
										<div class="overlay-container mb-10">
											<img src="images/gallery-2.jpg" alt="">
											<a href="portfolio-item.html" class="overlay-link small">
												<i class="fa fa-link"></i>
											</a>
										</div>
									</div>
									<div class="col-xs-4 col-md-6">
										<div class="overlay-container mb-10">
											<img src="images/gallery-3.jpg" alt="">
											<a href="portfolio-item.html" class="overlay-link small">
												<i class="fa fa-link"></i>
											</a>
										</div>
									</div>
									<div class="col-xs-4 col-md-6">
										<div class="overlay-container mb-10">
											<img src="images/gallery-4.jpg" alt="">
											<a href="portfolio-item.html" class="overlay-link small">
												<i class="fa fa-link"></i>
											</a>
										</div>
									</div>
									<div class="col-xs-4 col-md-6">
										<div class="overlay-container mb-10">
											<img src="images/gallery-5.jpg" alt="">
											<a href="portfolio-item.html" class="overlay-link small">
												<i class="fa fa-link"></i>
											</a>
										</div>
									</div>
									<div class="col-xs-4 col-md-6">
										<div class="overlay-container mb-10">
											<img src="images/gallery-6.jpg" alt="">
											<a href="portfolio-item.html" class="overlay-link small">
												<i class="fa fa-link"></i>
											</a>
										</div>
									</div>
								</div>
								<div class="text-right space-top">
									<a href="portfolio-grid-2-3-col.html" class="link-dark"><i class="fa fa-plus-circle pl-5 pr-5"></i>More</a>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="footer-content">
								<h2 class="title">Find Us</h2>
								<div class="separator-2"></div>
								<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium odio voluptatem necessitatibus illo vel dolorum soluta.</p>
								<ul class="social-links circle animated-effect-1">
									<li class="facebook"><a target="_blank" href="http://www.facebook.com"><i class="fa fa-facebook"></i></a></li>
									<li class="twitter"><a target="_blank" href="http://www.twitter.com"><i class="fa fa-twitter"></i></a></li>
									<li class="googleplus"><a target="_blank" href="http://plus.google.com"><i class="fa fa-google-plus"></i></a></li>
									<li class="linkedin"><a target="_blank" href="http://www.linkedin.com"><i class="fa fa-linkedin"></i></a></li>
									<li class="xing"><a target="_blank" href="http://www.xing.com"><i class="fa fa-xing"></i></a></li>
								</ul>
								<div class="separator-2"></div>
								<ul class="list-icons">
									<li><i class="fa fa-map-marker pr-10 text-default"></i> One infinity loop, 54100</li>
									<li><i class="fa fa-phone pr-10 text-default"></i> +00 1234567890</li>
									<li><a href="mailto:info@theproject.com"><i class="fa fa-envelope-o pr-10"></i>info@theproject.com</a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- .footer end -->

		<!-- .subfooter start -->
		<!-- ================ -->
		<div class="subfooter">
			<div class="container">
				<div class="subfooter-inner">
					<div class="row">
						<div class="col-md-12">
							<p class="text-center">Copyright <?php echo '&copy; '.date('Y').' - '.$app->getCfg('sitename');?>. All Rights Reserved</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- .subfooter end -->

	</footer>
	<!-- footer end -->
</div>
</body>