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

</div>
</body>