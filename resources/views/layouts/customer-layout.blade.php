<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Hotel Management System</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <link href="{{ asset('/assets/plugins/bootstrap-4.3.1/css/bootstrap.min.css') }}" rel="stylesheet" />

		<!-- Sidemenu Css -->
		<link href="{{ asset('/assets/css/sidemenu.css')}}" rel="stylesheet" />

		<!-- Dashboard Css -->
		<link href="{{ asset('/assets/css/style.css')}}" rel="stylesheet" />
		<link href="{{ asset('/assets/css/admin-custom.css')}}" rel="stylesheet" />

		<!-- c3.js Charts Plugin -->
		<link href="{{ asset('/assets/plugins/charts-c3/c3-chart.css')}}" rel="stylesheet" />

		<!-- p-scroll bar css-->
		<link href="{{ asset('/assets/plugins/pscrollbar/pscrollbar.css')}}" rel="stylesheet" />

		<!---Font icons-->
		<link href="{{ asset('/assets/css/icons.css')}}" rel="stylesheet"/>

		<!---P-scroll Bar css -->
		<link href="{{ asset('/assets/plugins/pscrollbar/pscrollbar.css')}}" rel="stylesheet"/>

		<!-- Color Skin css -->
		<link id="theme" rel="stylesheet" type="text/css" media="all" href="{{ asset('/assets/color-skins/color6.css')}}" />

        <link rel="icon" href="{{ asset('/assets/images/brand/favicon.ico')}}" type="image/x-icon"/>
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('/assets/images/brand/favicon.ico')}}" />

        <!-- Data table css -->
		<link href="{{ asset('/assets/plugins/datatable/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
		<link href="{{ asset('/assets/plugins/datatable/jquery.dataTables.min.css')}}" rel="stylesheet" />
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jodit/3.4.25/jodit.min.css"/>
		<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>
		<link href="{{ asset('assets/plugins/fullcalendar/fullcalendar.css')}}" rel='stylesheet' />
		<link href="{{ asset('/assets/plugins/fullcalendar/fullcalendar.print.min.css')}}" rel='stylesheet' media='print' />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.0.2/css/star-rating.min.css" />
		<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
 <!-- floara editotr -->
 <link href="https://cdn.jsdelivr.net/npm/froala-editor@3.1.0/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />

 <style>
		tr th{
			background-color: #a7947a;
			color: white !important;
		}

		div.r_detail {
            background-color: white;
            width: 600px;
            height: 110px;
            overflow: scroll;
            padding: 10px;
        }
		/* tr td{
			background-color: #a29b91;
			color: white;
		} */
	</style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            <header class="bg-white shadow">
                <!-- <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8"> -->
                    <!--App-Header-->
				<div class="app-header1 header py-1 d-flex" style="background: cadetblue !important;">
					<div class="container-fluid">
						<div class="d-flex">
							<a class="header-brand" href="/dashboard">
								<!-- <h3 class="logo-name"><img src="" style="background-color: white;border-radius:10px;width: 100px;height: 50px;" alt="" height="80" width="100"></h3> -->
								<!-- <img src="" class="header-brand-img" alt="Lmslist logo"> -->
							</a>
							<!--<a aria-label="Hide Sidebar" class="app-sidebar__toggle" data-toggle="sidebar" href="#"></a>-->
							<!--<div class="header-navicon">
								<a href="#" data-toggle="search" class="nav-link d-lg-none navsearch-icon">
									<i class="fe fe-search"></i>
								</a>
							</div>
							<div class="header-navsearch">
								<form class="form-inline mr-auto">
									<div class="nav-search">
										<input type="search" class="form-control header-search" placeholder="Search…" aria-label="Search" >
										<button class="btn" type="submit"><i class="fe fe-search"></i></button>
									</div>
								</form>
							</div> -->
							<div class="d-flex order-lg-2 ml-auto">
								<div class="dropdown d-none d-md-flex" >
									<!--<a  class="nav-link icon full-screen-link">-->
									<!--	<i class="fe fe-maximize-2"  id="fullscreen-button"></i>-->
									<!--</a>-->
								</div>
								<!-- <div class="dropdown d-none d-md-flex country-selector">
									<a href="#" class="d-flex nav-link leading-none" data-toggle="dropdown">
										<img src="{{ asset('/assets/images/flags/us_flag.jpg')}}" alt="flag-img" class="avatar avatar-xs mr-1 align-self-center">
										<div>
											<span class="text-white">English</span>
										</div>
									</a>
									<div class="language-width dropdown-menu dropdown-menu-right dropdown-menu-arrow">
										<a href="#" class="dropdown-item d-flex pb-3">
											<img src="{{ asset('assets/images/flags/french_flag.jpg')}}"  alt="flag-img" class="avatar mr-3 align-self-center" />
											<div>
												<strong>French</strong>
											</div>
										</a>
										<a href="#" class="dropdown-item d-flex pb-3">
											<img src="{{ asset('/assets/images/flags/germany_flag.jpg')}}"  alt="flag-img" class="avatar  mr-3 align-self-center" >
											<div>
												<strong>Germany</strong>
											</div>
										</a>
										<a href="#" class="dropdown-item d-flex pb-3">
											<img src="{{ asset('/assets/images/flags/italy_flag.jpg')}}"  alt="flag-img" class="avatar  mr-3 align-self-center" >
											<div>
												<strong>Italy</strong>
											</div>
										</a>
										<a href="#" class="dropdown-item d-flex pb-3">
											<img src="{{ asset('/assets/images/flags/russia_flag.jpg')}}"  alt="flag-img" class="avatar  mr-3 align-self-center" >
											<div>
												<strong>Russia</strong>
											</div>
										</a>
										<a href="#" class="dropdown-item d-flex pb-3">
											<img src="{{ asset('/assets/images/flags/spain_flag.jpg')}}"  alt="flag-img" class="avatar  mr-3 align-self-center" >
											<div>
												<strong>Spain</strong>
											</div>
										</a>
									</div>
								</div> -->
								<div class="dropdown d-none d-md-flex">
									<!-- <a class="nav-link icon" data-toggle="dropdown">
										<i class="fa fa-bell-o"></i>
										<span class=" nav-unread badge badge-danger  badge-pill">4</span>
									</a> -->
									<!-- <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
										<a href="#" class="dropdown-item text-center">You have 4 notification</a>
										<div class="dropdown-divider"></div>
										<a href="#" class="dropdown-item d-flex pb-3">
											<div class="notifyimg">
												<i class="fa fa-envelope-o"></i>
											</div>
											<div>
												<strong>2 new Messages</strong>
												<div class="small text-muted">17:50 Pm</div>
											</div>
										</a>
										<a href="#" class="dropdown-item d-flex pb-3">
											<div class="notifyimg">
												<i class="fa fa-calendar"></i>
											</div>
											<div>
												<strong> 1 Event Soon</strong>
												<div class="small text-muted">19-10-2019</div>
											</div>
										</a>
										<a href="#" class="dropdown-item d-flex pb-3">
											<div class="notifyimg">
												<i class="fa fa-comment-o"></i>
											</div>
											<div>
												<strong> 3 new Comments</strong>
												<div class="small text-muted">05:34 Am</div>
											</div>
										</a>
										<a href="#" class="dropdown-item d-flex pb-3">
											<div class="notifyimg">
												<i class="fa fa-exclamation-triangle"></i>
											</div>
											<div>
												<strong> Application Error</strong>
												<div class="small text-muted">13:45 Pm</div>
											</div>
										</a>
										<div class="dropdown-divider"></div>
										<a href="#" class="dropdown-item text-center">See all Notification</a>
									</div> -->
								</div>
								<!-- <div class="dropdown d-none d-md-flex">
									<a class="nav-link icon" data-toggle="dropdown">
										<i class="fa fa-envelope-o"></i>
										<span class=" nav-unread badge badge-warning  badge-pill">3</span>
									</a>
									<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
										<a href="#" class="dropdown-item d-flex pb-3">
											<img src="{{ asset('/assets/images/users/male/41.jpg')}}" alt="avatar-img" class="avatar brround mr-3 align-self-center">
											<div>
												<strong>Blake</strong> I've finished it! See you so.......
												<div class="small text-muted">30 mins ago</div>
											</div>
										</a>
										<a href="#" class="dropdown-item d-flex pb-3">
											<img src="{{ asset('/assets/images/users/female/1.jpg')}}" alt="avatar-img" class="avatar brround mr-3 align-self-center">
											<div>
												<strong>Caroline</strong> Just see the my Admin....
												<div class="small text-muted">12 mins ago</div>
											</div>
										</a>
										<a href="#" class="dropdown-item d-flex pb-3">
											<img src="{{ asset('/assets/images/users/male/18.jpg')}}" alt="avatar-img" class="avatar brround mr-3 align-self-center">
											<div>
												<strong>Jonathan</strong> Hi! I'am singer......
												<div class="small text-muted">1 hour ago</div>
											</div>
										</a>
										<a href="#" class="dropdown-item d-flex pb-3">
											<img src="{{ asset('/assets/images/users/female/18.jpg')}}" alt="avatar-img" class="avatar brround mr-3 align-self-center">
											<div>
												<strong>Emily</strong> Just a reminder you have.....
												<div class="small text-muted">45 mins ago</div>
											</div>
										</a>
										<div class="dropdown-divider"></div>
										<a href="#" class="dropdown-item text-center">View all Messages</a>
									</div>
								</div> -->
								<!-- <div class="dropdown d-none d-md-flex">
									<a class="nav-link icon" data-toggle="dropdown">
										<i class="fe fe-grid"></i>
									</a>
									<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow  app-selector">
										<ul class="drop-icon-wrap">
											<li>
												<a href="#" class="drop-icon-item">
													<i class="icon icon-speech text-dark"></i>
													<span class="block"> E-mail</span>
												</a>
											</li>
											<li>
												<a href="#" class="drop-icon-item">
													<i class="icon icon-map text-dark"></i>
													<span class="block">map</span>
												</a>
											</li>

											<li>
												<a href="#" class="drop-icon-item">
													<i class="icon icon-bubbles text-dark"></i>
													<span class="block">Messages</span>
												</a>
											</li>
											<li>
												<a href="#" class="drop-icon-item">
													<i class="icon icon-user-follow text-dark"></i>
													<span class="block">Followers</span>
												</a>
											</li>
											<li>
												<a href="#" class="drop-icon-item">
													<i class="icon icon-picture text-dark"></i>
													<span class="block">Photos</span>
												</a>
											</li>
											<li>
												<a href="#" class="drop-icon-item">
													<i class="icon icon-settings text-dark"></i>
													<span class="block">Settings</span>
												</a>
											</li>
										</ul>
										<div class="dropdown-divider"></div>
										<a href="#" class="dropdown-item text-center">View all</a>
									</div>
								</div> -->
								<div>
								<a href="https://book.djerbaplaza.com/home"><i style="margin-top: 20px !important;color: white;font-size: 25px;" class="fa fa-home"></i></a>
								</div>
								<div class="dropdown ">
									<a href="#" class="nav-link pr-0 leading-none user-img" data-toggle="dropdown">
										<img src="{{ asset('/storage/'. auth()->user()->avatar)}}" alt="profile-img" class="avatar avatar-md brround">
									</a>
									<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow ">
										<!--<a class="dropdown-item" href="#">-->
										<!--	<i class="dropdown-icon icon icon-user"></i> My Profile-->
										<!--</a>-->
										<!--<a class="dropdown-item" href="#">-->
										<!--	<i class="dropdown-icon icon icon-speech"></i> Inbox-->
										<!--</a>-->
										<!--<a class="dropdown-item" href="#">-->
										<!--	<i class="dropdown-icon  icon icon-settings"></i> Account Settings-->
										<!--</a>-->

										<a class="dropdown-item" href="{{ route('do-logout') }}">
											<i class="dropdown-icon icon icon-power"></i> Log out
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
                <!--/App-Header-->
                <!-- Sidebar menu-->
				<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
				<aside class="app-sidebar doc-sidebar">
					<div class="app-sidebar__user clearfix">
						<div class="dropdown user-pro-body">
							<div>
								<img src="{{ asset('/storage/'. auth()->user()->avatar)}}" alt="user-img" class="avatar avatar-lg brround">
								<!--<a href="#" class="profile-img">-->
								<!--	<span class="fa fa-pencil" aria-hidden="true"></span>-->
								<!--</a>-->
							</div>
							<div class="user-info">
								<h2>{{ auth()->user()->name }} (Customer)</h2>

							</div>
						</div>
					</div>
					<ul class="side-menu">
						<!-- <li class="slide">
							<a class="side-menu__item" data-toggle="slide" href="{{ route('dashboard') }}"><i class="side-menu__icon fe fe-airplay"></i><span class="side-menu__label">Dashboard</span></a>


						</li> -->

						<li class="slide">
							<a class="side-menu__item" data-toggle="slide" href="{{ route('customer-bookings') }}"><i class="side-menu__icon fa fa-paste"></i><span class="side-menu__label">Active Bookings</span></a>
                        </li>
						<!-- <li class="slide">
							<a class="side-menu__item" data-toggle="slide" href="{{ route('booking-history') }}"><i class="side-menu__icon fa fa-paste"></i><span class="side-menu__label"> Bookings History</span></a>
                        </li> -->
						<li class="slide">
							<a class="side-menu__item" data-toggle="slide" href="{{ route('view-profile') }}"><i class="side-menu__icon fa fa-paste"></i><span class="side-menu__label">Profile</span></a>
						</li>
						<li class="slide">
							<a class="side-menu__item" data-toggle="slide" href="{{ route('ratings') }}"><i class="side-menu__icon fa fa-paste"></i><span class="side-menu__label">Ratings</span></a>
                        </li>
						<li class="slide">
							<a class="side-menu__item" data-toggle="slide" href="{{ route('logout') }}"><i class="side-menu__icon fa fa-paste"></i><span class="side-menu__label">Logout</span></a>
						</li>

                        <li class="slide">
							<a class="side-menu__item" data-toggle="slide" href="/projects/HMS/public/"><i class="side-menu__icon fa fa-paste"></i><span class="side-menu__label">Back to Home</span></a>
                        </li>





					</ul>
				</aside>
				<!-- /Sidebar menu-->
                <!-- </div> -->
            </header>

            <!-- Page Content -->
            <main>
            @yield('content')
            </main>
        </div>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}" defer></script>
    <!-- Data tables -->
    <script src="{{ asset('/assets/js/jquery-3.2.1.min.js')}}"></script>

		<!-- Bootstrap js -->
		<script src="{{ asset('/assets/plugins/bootstrap-4.3.1/js/popper.min.js')}}"></script>
		<script src="{{ asset('/assets/plugins/bootstrap-4.3.1/js/bootstrap.min.js')}}"></script>
		<script src="{{ asset('/assets/plugins/datatable/jquery.dataTables.min.js')}}"></script>
        <script src="{{ asset('/assets/plugins/datatable/dataTables.bootstrap4.min.js')}}"></script>
        <script src="{{ asset('/assets/plugins/bootstrap-wizard/jquery.bootstrap.wizard.js')}}"></script>
        <script src="{{ asset('/assets/plugins/jquery-validation/dist/jquery.validate.min.js')}}"></script>
		<script src="{{ asset('/assets/js/wizard.js')}}"></script>
        <script src="{{ asset('/assets/js/myscript.js')}}"></script>
        <script src="{{ asset('/assets/js/datatable.js')}}"></script>
		<script src="//cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>

		<script src="//cdnjs.cloudflare.com/ajax/libs/jodit/3.4.25/jodit.min.js"></script>
		<script src="{{ asset('/assets/js/myscript.js') }}"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.0.2/js/star-rating.min.js"></script>
		<script src="{{ asset('/assets/plugins/fullcalendar/moment.min.js')}}"></script>
		<script src="{{ asset('/assets/plugins/fullcalendar/fullcalendar.min.js')}}"></script>
		<script src="{{ asset('/assets/js/fullcalendar.js')}}"></script>
		<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/froala-editor@3.1.0/js/froala_editor.pkgd.min.js"></script>


    </body>
</html>
