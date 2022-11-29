@extends('layouts.admin-layout')

@section('content')
<div class="app-content">
					<div class="side-app">
						<div class="page-header">
							<h4 class="page-title">Dashboard 1</h4>
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="#">Home</a></li>
								<li class="breadcrumb-item active" aria-current="page">Dashboard 1</li>
							</ol>
						</div>

						<div class="row">
							<div class="col-sm-12 col-md-6 col-lg-6 col-xl-3 ">
								<div class="card overflow-hidden">
									<div class="card-header">
										<h3 class="card-title font-weight-normal">Total Products</h3>
										<div class="card-options"> <a class="btn btn-sm btn-primary" href="#">View</a> </div>
									</div>
									<div class="card-body ">
										<h2 class="text-dark  mt-0">4,657</h2>
										<div class="progress progress-sm mt-0 mb-2">
											<div class="progress-bar bg-primary w-75" role="progressbar"></div>
										</div>
										<div class=""><i class="fa fa-caret-up text-green mr-1"></i>10% than last year</div>
									</div>
								</div>
							</div>
							<div class=" col-sm-12 col-md-6 col-lg-6 col-xl-3">
								<div class="card overflow-hidden">
									<div class="card-header">
										<h3 class="card-title font-weight-normal">Total Sales</h3>
										<div class="card-options"> <a class="btn btn-sm btn-secondary" href="#">View</a> </div>
									</div>
									<div class="card-body ">
										<h2 class="text-dark  mt-0">2,592</h2>
										<div class="progress progress-sm mt-0 mb-2">
											<div class="progress-bar bg-secondary w-45" role="progressbar"></div>
										</div>
										<div class=""><i class="fa fa-caret-down text-danger mr-1"></i>12% than last year</div>
									</div>
								</div>
							</div>
							<div class=" col-sm-12 col-md-6 col-lg-6 col-xl-3">
								<div class="card overflow-hidden">
									<div class="card-header">
										<h3 class="card-title font-weight-normal">Total Earnings</h3>
										<div class="card-options"> <a class="btn btn-sm btn-success" href="#">View</a> </div>
									</div>
									<div class="card-body ">
										<h2 class="text-dark  mt-0">3,517</h2>
										<div class="progress progress-sm mt-0 mb-2">
											<div class="progress-bar bg-success w-50" role="progressbar"></div>
										</div>
										<div class=""><i class="fa fa-caret-down text-danger mr-1"></i>5% than last year</div>
									</div>
								</div>
							</div>
							<div class="col-sm-12 col-md-6 col-lg-6 col-xl-3 ">
								<div class="card overflow-hidden">
									<div class="card-header">
										<h3 class="card-title font-weight-normal">Total Orders</h3>
										<div class="card-options"> <a class="btn btn-sm btn-info" href="#">View</a> </div>
									</div>
									<div class="card-body ">
										<h2 class="text-dark  mt-0">1,759</h2>
										<div class="progress progress-sm mt-0 mb-2">
											<div class="progress-bar bg-info w-25" role="progressbar"></div>
										</div>
										<div class=""><i class="fa fa-caret-up text-success mr-1"></i>15% than last year</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-8 col-lg-12 col-md-12">
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Sales Overview</h3>
									</div>
									<div class="card-body">
										<div class="chart-wrapper">
											<canvas id="sales" class=""></canvas>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-4 col-lg-12 col-md-12">
								<div class="card text-center">
									<div class="card-body">
										<img src="../assets/images/png/banner/2.png" class="mb-0 h-240" alt="img">
										<h2 class="font-weight-normal mb-4">Congratulations!</h2>
										<h4 class="mb-2 text-default">Order Confirmed....</h4>
										<p class="mb-0 text-muted">You Have Done More Profit Today <br>....Check Your Profit Details</p>
										<a class="btn ripple  btn-primary mt-2" href="#">View Balance</a>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
						    <div class="col-xl-4 col-md-12 col-sm-12">
								<div class="card overflow-hidden">
									<div class="item-card2-tans">
										<div class="item-card7-imgs">
											<a href="page-details.html"></a>
											<img src="../assets/images/media/pictures/thumb-11.jpg" alt="img" class="cover-image">
											<div class="tag-text">
												<span class="bg-dark-transparent tag-option">PSD</span>
											</div>
										</div>
										<div class="item-card2-icons">
											<a href="#" class="bg-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Add to Wishlist"><i class="fe fe-heart"></i></a>
											<a href="#" class="bg-secondary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Buy Now"><i class="fe fe-shopping-cart"></i></a>
											<a href="#" class="bg-info" data-toggle="tooltip" data-placement="top" title="" data-original-title="View Details"><i class="fe fe-eye"></i></a>
										</div>
									</div>
									<div class="card-body">
										<div class="item-card7-desc">
											<div class="item-card7-text">
												<a href="page-details.html" class="text-dark"><h4 class="font-weight-semibold">PSD Template</h4></a>
												<p class="fs-13 mb-1 text-muted">Lorem Ipsum available, quis int lorem ipsum nostrum exercitationem voluptatem accusantium doloremque laudantium.</p>
											</div>
											<div class="d-md-flex">
												<div class="rating-stars d-flex mr-5">
													<input type="number" readonly="readonly" class="rating-value star" name="rating-stars-value" value="3">
													<div class="rating-stars-container mr-2">
														<div class="rating-star sm">
															<i class="fa fa-star"></i>
														</div>
														<div class="rating-star sm">
															<i class="fa fa-star"></i>
														</div>
														<div class="rating-star sm">
															<i class="fa fa-star"></i>
														</div>
														<div class="rating-star sm">
															<i class="fa fa-star"></i>
														</div>
														<div class="rating-star sm">
															<i class="fa fa-star"></i>
														</div>
													</div>(3)
												</div>
												<div class="ml-auto">
													<div class="item-card9-cost">
														<h4 class="mb-0 fs-24">$25</h4>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="card-footer pt-2 pb-2">
										<div class="footerimg d-flex mt-0 mb-0">
											<div class="d-flex footerimg-l mb-0">
												<img src="../assets/images/users/female/1.jpg" alt="image" class="avatar avatar-sm brround  mr-2">
												<a href="#" class="time-title text-muted p-0 leading-normal">Lily Paige<i class="si si-check text-success fs-12 ml-1" data-toggle="tooltip" data-placement="top" title="" data-original-title="verified"></i></a>
											</div>
											<div class="footerimg-r ml-auto">
												<span class="text-muted"><i class="fe fe-shopping-cart"></i> 16</span>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-4 col-md-12 col-sm-12">
								<div class="card ">
									<div class="card-header"><h5 class="card-title">Top Visitors</h5></div>
									<div class="card-body">
										<div class="media mb-5 mt-0">
											<div class="d-flex mr-3">
												<a href="#"> <img class="media-object rounded-circle thumb-sm" alt="64x64" src="../assets/images/users/male/18.jpg"> </a>
											</div>
											<div class="media-body">
												<a href="#" class="text-dark font-weight-semibold">Nathaniel Bustos</a>
												<div class="text-muted small">Manager</div>
											</div>
											<button type="button" class="btn btn-light btn-sm d-block">Follow</button>
										</div>
										<div class="media mb-5">
											<div class="d-flex mr-3">
												<a href="#"> <img class="media-object rounded-circle thumb-sm" alt="64x64" src="../assets/images/users/female/4.jpg"> </a>
											</div>
											<div class="media-body">
												<a href="#" class="text-dark font-weight-semibold">Latanya Kinard</a>
												<div class="text-muted small">Web Designer</div>
											</div>
											<button type="button" class="btn btn-light btn-sm d-block">Follow</button>
										</div>
										<div class="media mb-5">
											<div class="d-flex mr-3">
												<a href="#"> <img class="media-object rounded-circle thumb-sm" alt="64x64" src="../assets/images/users/male/20.jpg"> </a>
											</div>
											<div class="media-body">
												<a href="#" class="text-dark font-weight-semibold">George Lujan</a>
												<div class="text-muted small">App Developer</div>
											</div>
											<button type="button" class="btn btn-light btn-sm d-block">Follow</button>
										</div>
										<div class="media mb-5">
											<div class="d-flex mr-3">
												<a href="#"> <img class="media-object rounded-circle thumb-sm" alt="64x64" src="../assets/images/users/female/19.jpg"> </a>
											</div>
											<div class="media-body">
												<a href="#" class="text-dark font-weight-semibold">Samantha</a>
												<div class="text-muted small">Administartor</div>
											</div>
											<button type="button" class="btn btn-light btn-sm d-block">Follow</button>
										</div>
										<div class="media mb-0">
											<div class="d-flex mr-3">
												<a href="#"> <img class="media-object rounded-circle thumb-sm" alt="64x64" src="../assets/images/users/male/21.jpg"> </a>
											</div>
											<div class="media-body">
												<a href="#" class="text-dark font-weight-semibold">George Lujan</a>
												<div class="text-muted small">Web Developer</div>
											</div>
											<button type="button" class="btn btn-light btn-sm d-block">Follow</button>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-4 col-md-12 col-sm-12">
								<div class="card">
									<div class="card-header">
										<h4 class="card-title">Countrywise Sales</h4>
									</div>
									<div class="card-body table-responsive p-0">
										<table class="table card-table text-nowrap table-vcenter">
											<tbody>
												<tr>
													<td class="p-3"><i class="flag flag-us mt-2"></i></td>
													<td class="p-3">USA
														<div class="progress progress-xs mt-1">
															<div class="progress-bar bg-primary w-80"></div>
														</div>
													</td>
													<td class="text-right p-3">
														<small class="text-muted">Views</small>
														<div class="num-font font-weight-bold">24,675</div>
													</td>
												</tr>
												<tr>
													<td class="p-3"><i class="flag flag-pl mt-2"></i></td>
													<td class="p-3">Poland
														<div class="progress progress-xs mt-2">
															<div class="progress-bar bg-secondary w-60"></div>
														</div>
													</td>
													<td class="text-right p-3">
														<small class="text-muted">Views</small>
														<div class="num-font font-weight-bold">23,678</div>
													</td>
												</tr>
												<tr>
													<td class="p-3"><i class="flag flag-de mt-2"></i></td>
													<td class="p-3">Germany
														<div class="progress progress-xs mt-2">
															<div class="progress-bar  bg-success w-50"></div>
														</div>
													</td>
													<td class="text-right p-3">
														<small class="text-muted">Views</small>
														<div class="num-font font-weight-bold">12,675</div>
													</td>
												</tr>
												<tr>
													<td class="p-3"><i class="flag flag-ru mt-2"></i></td>
													<td class="p-3">Russia
														<div class="progress progress-xs mt-2">
															<div class="progress-bar bg-info w-35"></div>
														</div>
													</td>
													<td class="text-right p-3">
														<small class="text-muted">Views</small>
														<div class="num-font font-weight-bold">11,756</div>
													</td>
												</tr>
												<tr>
													<td class="p-3"><i class="flag flag-in mt-2"></i></td>
													<td class="p-3">India
														<div class="progress progress-xs mt-2">
															<div class="progress-bar bg-warning w-35"></div>
														</div>
													</td>
													<td class="text-right p-3">
														<small class="text-muted">Views</small>
														<div class="num-font font-weight-bold">2,786</div>
													</td>
												</tr>
												<tr>
													<td class="p-3"><i class="flag flag-ge mt-2 border-0"></i></td>
													<td class="p-3">Germany
														<div class="progress progress-xs mt-2">
															<div class="progress-bar bg-pink w-55"></div>
														</div>
													</td>
													<td class="text-right p-3">
														<small class="text-muted">Views</small>
														<div class="num-font font-weight-bold">34,789</div>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-12 col-lg-12 col-md-12">
								<div class="card">
									<div class="card-header">
										<h5 class="card-title">Order Overview</h5>
									</div>
									<div class="card-body">
										<div class="table-responsive border-top mb-0">
											<table class="table table-bordered text-nowrap mb-0">
												<thead>
													<tr>
														<th>Order ID</th>
														<th>Category</th>
														<th>Date</th>
														<th>Price</th>
														<th>Status</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td class="text-primary">#89345</td>
														<td>HTML Template</td>
														<td>07-12-2020</td>
														<td class="fs-16 font-weight-semibold">$13</td>
														<td>
															<a href="#" class="badge badge-danger">Pending</a>
														</td>
													</tr>
													<tr>
														<td class="text-primary">#39281</td>
														<td>Worpress Template</td>
														<td>12-11-2020</td>
														<td class="fs-16 font-weight-semibold">$54</td>
														<td>
															<a href="#" class="badge badge-primary">Paid</a>
														</td>
													</tr>
													<tr>
														<td class="text-primary">#35825</td>
														<td>Angular Template</td>
														<td>15-11-2020</td>
														<td class="fs-16 font-weight-semibold">$32</td>
														<td>
															<a href="#" class="badge badge-primary">Paid</a>
														</td>
													</tr>
													<tr>
														<td class="text-primary">#62391</td>
														<td>PHP Template</td>
														<td>10-11-2020</td>
														<td class="fs-16 font-weight-semibold">$15</td>
														<td>
															<a href="#" class="badge badge-danger">Pending</a>
														</td>
													</tr>
													<tr>
														<td class="text-primary">#92481</td>
														<td>PSD Template</td>
														<td>07-11-2020</td>
														<td class="fs-16 font-weight-semibold">$32</td>
														<td>
															<a href="#" class="badge badge-primary">Paid</a>
														</td>
													</tr>
													<tr>
														<td class="text-primary">#29381</td>
														<td>HTML Template</td>
														<td>31-10-2020</td>
														<td class="fs-16 font-weight-semibold">$25</td>
														<td>
															<a href="#" class="badge badge-danger">Pending</a>
														</td>
													</tr>
													<tr>
														<td class="text-primary">#72356</td>
														<td>Wordpress Template</td>
														<td>27-10-2020</td>
														<td class="fs-16 font-weight-semibold">$16</td>
														<td>
															<a href="#" class="badge badge-danger">Pending</a>
														</td>
													</tr>
													<tr>
														<td class="text-primary">#89345</td>
														<td>Angular Template</td>
														<td>30-11-2020</td>
														<td class="fs-16 font-weight-semibold">$24</td>
														<td>
															<a href="#" class="badge badge-primary">Paid</a>
														</td>
													</tr>
													<tr>
														<td class="text-primary">#4570</td>
														<td>PHP Template</td>
														<td>03-12-2020</td>
														<td class="fs-16 font-weight-semibold">$14</td>
														<td>
															<a href="#" class="badge badge-danger">Pending</a>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
                </div>

@endsection