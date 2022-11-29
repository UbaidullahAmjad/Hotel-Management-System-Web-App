@extends('welcome')

@section('content')

<div class="content margint60"><!-- Content Section -->
		<div class="container margint60">
			<h2>Select Your Favourite Package</h2>
			<div class="row">
            <div class="col-lg-9"><!-- Explore Rooms -->
					<table style="border: solid 1px #f0f0f0;">
						<tr class="products-title">
							<td class="table-products-image pos-center"><h6>IMAGE</h6></td>
							<td class="table-products-name pos-center"><h6>ROOM NAME</h6></td>
							<td class="table-products-price pos-center"><h6>PRICE</h6></td>

						</tr>
						<tr class="table-products-list pos-center">
							<td class="products-image-table"><img alt="Products Image 1" src="temp/room-image-1.jpg" class="img-responsive"></td>
							<td class="title-table">
								<div class="room-details-list clearfix">
									<div class="pull-left">
										<h5>Suit Room</h5>
									</div>
									<div class="pull-left room-rating">
										<ul>
											<li><i class="fa fa-star"></i></li>
											<li><i class="fa fa-star"></i></li>
											<li><i class="fa fa-star"></i></li>
											<li><i class="fa fa-star"></i></li>
											<li><i class="fa fa-star inactive"></i></li>
										</ul>
									</div>
								</div>
								<div class="list-room-icons clearfix">
									<ul>
										<li><i class="fa fa-calendar"></i></li>
										<li><i class="fa fa-flask"></i></li>
										<li><i class="fa fa-umbrella"></i></li>
										<li><i class="fa fa-laptop"></i></li>
									</ul>
								</div>
								<p>Vestibulum id ligula porta felis euismod semper. Aenean eu leo quam. Pellentesque orla porta felis euismodnean eu at ero <a class="active-color" href="#">[...]</a> </p>
							</td>
							<td><h3>70$</h3></td>
							<!-- <td><div class="button-style-1"><a href="#"><i class="fa fa-calendar"></i><span class="mobile-visibility">Book Now</span></a></div></td> -->
						</tr>
						<tr style="border: solid 1px #f0f0f0;" class="table-products-list pos-center ">

								<td><h3>Package 1</h3>
								<p style="font-size: 16px;"><b>Facilities:</b> &nbsp; <i title="Television" class="fa fa-laptop"></i> <i title="Wifi" class="fa fa-wifi"></i><i title="Food" class="fa fa-fish"></i>  </p></td>
								<td><div class="button-style-1"><a href="{{ route('booknow') }}"><i class="fa fa-calendar"></i><span class="mobile-visibility">Buy Now</span></a></div></td>



						</tr>
						<tr style="border: solid 1px #f0f0f0;" class="table-products-list pos-center ">

								<td><h3>Package 2</h3>
								<p style="font-size: 16px;"><b>Facilities:</b> &nbsp; <i title="Wifi" class="fa fa-wifi"></i><i title="Food" class="fa fa-fish"></i>  </p></td>
								<td><div class="button-style-1"><a href="{{ route('booknow') }}"><i class="fa fa-calendar"></i><span class="mobile-visibility">Buy Now</span></a></div></td>



						</tr>
						<tr style="border: solid 1px #f0f0f0;" class="table-products-list pos-center  mt-5">

								<td><h3 class="mt-5">Package 3</h3>
								<p style="font-size: 16px;"><b>Facilities:</b> &nbsp; <i title="Television" class="fa fa-laptop"></i> <i title="Wifi" class="fa fa-wifi"></i><i title="Food" class="fa fa-fish"></i>  </p></td>
								<td><div class="button-style-1"><a href="{{ route('booknow') }}"><i class="fa fa-calendar"></i><span class="mobile-visibility">Buy Now</span></a></div></td>



						</tr>

					</table>
				</div>
            </div>
        </div>
</div>

@endsection