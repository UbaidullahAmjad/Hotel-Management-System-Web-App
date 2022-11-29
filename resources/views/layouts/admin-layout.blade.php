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
    <!-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> -->
    <link href="{{ asset('/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
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
    <link href="{{ asset('/assets/css/icons.css')}}" rel="stylesheet" />

    <!---P-scroll Bar css -->
    <link href="{{ asset('/assets/plugins/pscrollbar/pscrollbar.css')}}" rel="stylesheet" />

    <!-- Color Skin css -->
    <link id="theme" rel="stylesheet" type="text/css" media="all" href="{{ asset('/assets/color-skins/color6.css')}}" />

    <link rel="icon" href="{{ asset('/assets/images/brand/favicon.ico')}}" type="image/x-icon" />
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('/assets/images/brand/favicon.ico')}}" />

    <!-- Data table css -->
    <link href="{{ asset('/assets/plugins/datatable/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{ asset('/assets/plugins/datatable/jquery.dataTables.min.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jodit/3.4.25/jodit.min.css" />
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>
    <link href="{{ asset('assets/plugins/fullcalendar/fullcalendar.css')}}" rel='stylesheet' />
    <link href="{{ asset('/assets/plugins/fullcalendar/fullcalendar.print.min.css')}}" rel='stylesheet' media='print' />
    <link href="{{asset('/assets/plugins/fileuploads/css/fileupload.css')}}" rel="stylesheet" type="text/css" />
    <!-- floara editotr -->
    <link href="https://cdn.jsdelivr.net/npm/froala-editor@3.1.0/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
  
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
    
    <style>
        tr th {
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

        label {
            font-size:19px;
        }

        .app-sidebar ul li a {
        
        color: black !important;
        font-weight: 500;
    }

    .fa-eye:before{
        color:white !important;
    }

    span.relative.inline-flex.items-center.px-4.py-2.text-sm.font-medium.text-gray-500.bg-white.border.border-gray-300.cursor-default.leading-5.rounded-md{
        display:none !important;   
    }
    a.relative.inline-flex.items-center.px-4.py-2.ml-3.text-sm.font-medium.text-gray-700.bg-white.border.border-gray-300.leading-5.rounded-md.hover\:text-gray-500.focus\:outline-none.focus\:ring.ring-gray-300.focus\:border-blue-300.active\:bg-gray-100.active\:text-gray-700.transition.ease-in-out.duration-150{
        display: none !important;
    }

    a.relative.inline-flex.items-center.px-4.py-2.text-sm.font-medium.text-gray-700.bg-white.border.border-gray-300.leading-5.rounded-md.hover\:text-gray-500.focus\:outline-none.focus\:ring.ring-gray-300.focus\:border-blue-300.active\:bg-gray-100.active\:text-gray-700.transition.ease-in-out.duration-150{
        display: none !important;
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
            <div class="app-header1 header py-1 d-flex" style="background: #a7947a !important;">
                <div class="container-fluid">
                    <div class="d-flex">
                        <a class="header-brand" href="/dashboard">
                            <marque style="color:white;margin-top:5px">Djerba Plaza Admin</marque>
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
                            <div class="dropdown d-none d-md-flex">
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
                                <!--
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
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
                            <!--
                                <div class="dropdown d-none d-md-flex">
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

                            <div class="dropdown d-none d-md-flex">
                                <a href="https://book.djerbaplaza.com/" class="nav-link icon">
                                    <i class="fa fa-home fa-2x"></i>
                                </a>
                                {{-- <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow  app-selector">
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
                                </div> --}}
                            </div>
                            <div class="dropdown ">
                                <a href="#" class="nav-link pr-0 leading-none user-img" data-toggle="dropdown">
                                    <img src="{{ asset('/assets/images/user1.jpg')}}" alt="profile-img" class="avatar avatar-md brround">
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
                            <img src="{{ asset('/assets/images/user1.jpg')}}" alt="user-img" class="avatar avatar-lg brround">
                            <!--<a href="#" class="profile-img">-->
                            <!--	<span class="fa fa-pencil" aria-hidden="true"></span>-->
                            <!--</a>-->
                        </div>
                        <div class="user-info">
                            <h2>{{ auth()->user()->name }}</h2>

                        </div>
                    </div>
                </div>
                <ul class="side-menu">
                    {{-- <li class="slide">
							<a class="side-menu__item" data-toggle="slide" href="{{ route('dashboard') }}"><i class="side-menu__icon fe fe-airplay"></i><span class="side-menu__label">Dashboard</span></a>
                    </li> --}}
                    @can('bookings')
                    <li class="slide">
                        <a class="side-menu__item" data-toggle="slide" href="{{ route('bookings') }}"><i class="side-menu__icon fa fa-list"></i><span class="side-menu__label">
                                Bookings</span></a>
                    </li>
                    @endcan
                    @can('rooms')
                    <li class="slide">
                        <a class="side-menu__item" data-toggle="slide" href="{{ route('rooms.index') }}"><i class="side-menu__icon fa fa-home"></i><span class="side-menu__label"> Rooms</span></a>
                    </li>
                    @endcan
                    @can('rates')
                    <li class="slide">
                        <a class="side-menu__item" data-toggle="slide" href="{{ route('rates.index') }}"><i class="side-menu__icon fa fa-dollar"></i><span class="side-menu__label">
                                Rates</span></a>
                    </li>
                    @endcan
                    @can('packages')
                    <li class="slide">
                        <a class="side-menu__item" data-toggle="slide" href="{{ route('packages.index') }}"><i class="side-menu__icon fa fa-archive"></i><span class="side-menu__label">
                                Packages</span></a>
                    </li>
                    @endcan
                    @can('activities')
                    <li class="slide">
                        <a class="side-menu__item" data-toggle="slide" href="{{ route('activities.index') }}"><img src="{{asset('/img/active.jpeg')}}" alt="" height="18" width="18">&nbsp;&nbsp;<span class="side-menu__label">
                                Activities</span></a>
                    </li>
                    @endcan
                    @can('services')
                    <li class="slide">
                        <a class="side-menu__item" data-toggle="slide" href="{{ route('services.index') }}"><img src="{{asset('/img/ser.png')}}" alt="" height="18" width="18">&nbsp;&nbsp;<span class="side-menu__label">
                                Services</span></a>
                    </li>
                    @endcan
                    @can('badges')
                    <li class="slide">
                        <a class="side-menu__item" data-toggle="slide" href="{{ route('badges.index') }}"><i class="side-menu__icon fa fa-certificate"></i><span class="side-menu__label">
                                Badges</span></a>
                    </li>
                    @endcan
                    @can('flat-rate')                 
                    <li class="slide">
                        <a class="side-menu__item" data-toggle="slide" href="{{ route('flatrates.index') }}"><i class="side-menu__icon fa fa-dollar"></i><span class="side-menu__label">
                                Flat Rate</span></a>
                    </li>
                    @endcan
                    @can('facilities')
                    <li class="slide">
                        <a class="side-menu__item" data-toggle="slide" href="{{ route('facilities.index') }}"><img src="{{asset('/img/buil.png')}}" alt="" height="18" width="18">&nbsp;&nbsp;<span class="side-menu__label">
                                Facilities</span></a>
                    </li>
                    @endcan
                    @can('customers')
                    <li class="slide">
                        <a class="side-menu__item" data-toggle="slide" href="{{ route('customers.index') }}"><i class="side-menu__icon fa fa-users"></i><span class="side-menu__label">
                                Customers</span></a>
                    </li>
                    @endcan
                    @can('discount')
                    
                    <li class="slide">
                        <a class="side-menu__item" data-toggle="slide" href="{{ route('admin.discount') }}"><i class="side-menu__icon fa fa-percentage">%</i><span class="side-menu__label">
                                Discount</span></a>
                    </li>
                    @endcan
                    @can('policy')
                    <li class="slide">
                        <a class="side-menu__item" data-toggle="slide" href="{{ route('policy.index') }}"><img src="{{asset('/img/cancel.png')}}" alt="" height="18" width="18">&nbsp;&nbsp;<span class="side-menu__label"> Cancellation
                                Policy</span></a>
                    </li>
                    @endcan
                    @can('email-management')
                    <li class="slide">
                        <a class="side-menu__item" data-toggle="slide" href="{{ route('emails.index') }}"><i class="side-menu__icon fa fa-envelope"></i><span class="side-menu__label"> 
                                Email Management</span></a>
                    </li>
                    @endcan
                    @can('roles')
                    <li class="slide">
                        <a class="side-menu__item" data-toggle="slide" href="{{ route('roles.index') }}"><i class="side-menu__icon fa fa-users"></i><span class="side-menu__label"> 
                                Roles</span></a>
                    </li>
                    @endcan
                    @can('site-settings')
                    
                    <li class="slide">
                        <div class="dropdown">
                        <i class="fa fa-cogs"></i><button class="btn dropdown-toggle" style="font-weight: 500;" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                             Site Settings
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="side-menu__item dropdown-item" data-toggle="slide" href="{{ route('setting.newhome') }}"><i class="side-menu__icon fa fa-home"></i><span class="side-menu__label">
                                Home Page </span></a>
                              

                                <a class="side-menu__item dropdown-item" data-toggle="slide" href="{{ route('setting.header') }}"><img src="{{asset('/img/header.png')}}" alt="" height="18" width="18">&nbsp;&nbsp;<span class="side-menu__label">Header/Footer</span></a>

                               

                            </div>

                        </div>
                    </li>

                    @endcan
                    @can('payment-methods')
                    <li class="slide">
                        <div class="dropdown">
                        <i class=" fa fa-cogs"></i><button class="btn dropdown-toggle" style="font-weight: 500;" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Payment Methods
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="side-menu__item dropdown-item" data-toggle="slide" href="{{ route('payment_methods.index') }}"><i class="side-menu__icon fa fa-dollar"></i><span class="side-menu__label"> Payment
                                Methods</span></a>
                                <a class="side-menu__item dropdown-item" data-toggle="slide" href="{{ route('countries.index') }}"><i class="side-menu__icon fa fa-flag"></i><span class="side-menu__label"> PM
                                        Countries</span></a>

                                <a class="side-menu__item dropdown-item" data-toggle="slide" href="{{ route('order_prices.index') }}"><i class="side-menu__icon fa fa-dollar"></i><span class="side-menu__label"> PM Order
                                        Prices</span></a>

                                <a class="side-menu__item dropdown-item" data-toggle="slide" href="{{ route('coupons.index') }}"><img src="{{asset('/img/tag.png')}}" alt="" height="18" width="18">&nbsp;&nbsp;<span class="side-menu__label"> PM Coupons</span></a>

                            </div>
                        </div>
                    </li>
                    @endcan





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
    <!-- <script src="{{ asset('/assets/js/myscript.js')}}"></script> -->
    <script src="{{ asset('/assets/js/datatable.js')}}"></script>
    <script src="//cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>

    <script src="//cdnjs.cloudflare.com/ajax/libs/jodit/3.4.25/jodit.min.js"></script>
    <script src="{{ asset('/assets/js/myscript.js') }}"></script>
    <script src="{{ asset('/assets/plugins/fullcalendar/moment.min.js')}}"></script>
    <script src="{{ asset('/assets/plugins/fullcalendar/fullcalendar.min.js')}}"></script>
    <script src="{{ asset('/assets/js/fullcalendar.js')}}"></script>
    <script src="{{asset('assets/plugins/select2/select2.full.min.js')}}"></script>
    <script src="{{asset('assets/js/select2.js')}}"></script>
    <script src="{{asset('/assets/plugins/fileuploads/js/fileupload.js')}}"></script>
    <script src="{{asset('/assets/js/formelements.js')}}"></script>


    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/froala-editor@3.1.0/js/froala_editor.pkgd.min.js">
    </script>
<script>
        $(function() {
            $('.js-example-basic-single').select2({
                tags: true,
                tokenSeparators: [',', ' ']
            });
        });
    </script>

</body>

</html>