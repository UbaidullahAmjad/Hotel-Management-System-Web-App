$(function (e) {
	$('#example').DataTable();
	$('#example2').DataTable();
});












function addDateRange1() {


	var packages = document.getElementsByClassName("package");
	// var packages = document.getElementById('packs').value;
	console.log(packages[0]);
	// var packages = $('#display_packagess');
	var max_fields = 10;
	var x = 1;
	$('#new').css('display', 'block');

	var wrapper = $(".input_fields_wrap");
	var fieldHTML1 = '<div class="form-group"><label for= "start_date">Start date</label><input type="date" class="form-control" name="start_date[]" id="start_date" required></div><div class="form-group"><label for="end_date">End date</label><input type="date" class="form-control" name="end_date[]" id="end_date" required></div>';
	var price1 = '<label for="">Pricing</label> <br>' +
		'<div class="form-group">' +
		'<label for="price_per_night1">Price per night (€)</label>' +
		'<div class="input-group mb-3">' +
		'<div class="input-group-prepend">' +
		'<span class="input-group-text" id="basic-addon1">€</span>' +
		'</div>' +
		'<input type="number" min="1" class="form-control" name="price_per_night1[]" id="price_per_night1" required>' +
		'</div>' +
		'</div>' +
		'<div class="form-group">' +
		'<label for="price_per_night1">Price per night (TND)</label>' +
		'<div class="input-group mb-3">' +
		'<div class="input-group-prepend">' +
		'<span class="input-group-text" id="basic-addon1">TND</span>' +
		'</div>' +
		'<input type="number" min="1" class="form-control" name="price_per_night2[]" id="price_per_night1" required>' +
		'</div>' +
		'</div>' +
		'<div class="form-group">' +
		'<label for="non_refundable1">Non refundable (€)</label>' +
		'<div class="input-group mb-3">' +
		'<div class="input-group-prepend">' +
		'<span class="input-group-text" id="basic-addon1">€</span>' +
		'</div>' +
		'<input type="number" min="1" class="form-control" name="non_refundable1[]" id="non_refundable1" required>' +
		'</div>' +
		'</div>' +
		'<div class="form-group">' +
		'<label for="non_refundable2">Non refundable (TND)</label>' +
		'<div class="input-group mb-3">' +
		'<div class="input-group-prepend">' +
		'<span class="input-group-text" id="basic-addon1">TND</span>' +
		'</div>' +
		'<input type="number" min="1" class="form-control" name="non_refundable2[]" id="non_refundable2" required>' +
		'</div>' +
		'</div>' +
		'<div class="form-group">' +
		'<label for="modifiable1">Modifiable (€)</label>' +
		'<div class="input-group mb-3">' +
		'<div class="input-group-prepend">' +
		'<span class="input-group-text" id="basic-addon1">€</span>' +
		'</div>' +
		'<input type="number" min="1" class="form-control" name="modifiable1[]" id="modifiable1" required>' +
		'</div>' +
		'</div>' +
		'<div class="form-group"><label for="modifiable2">Modifiable (TND)</label><div class="input-group mb-3"><div class="input-group-prepend"><span class="input-group-text" id="basic-addon1">TND</span></div><input type="number" min="1" class="form-control" name="modifiable2[]" id="modifiable2" required></div></div>' +

		'<div class="form-group"><label for="prepayment1">Prepayment (€)</label><div class="input-group mb-3"><div class="input-group-prepend"><span class="input-group-text" id="basic-addon1">€</span></div><input type="number" min="1" class="form-control" name="prepayment1[]" id="prepayment1" required></div></div>' +
		'<div class="form-group"><label for="prepayment2">Prepayment (TND)</label><div class="input-group mb-3"><div class="input-group-prepend"><span class="input-group-text" id="basic-addon1">TND</span></div><input type="number" min="1" class="form-control" name="prepayment2[]" id="prepayment2" required></div></div>' +

		'<div class="form-group"><label for="no_advance1">No advance (€)</label><div class="input-group mb-3"><div class="input-group-prepend"><span class="input-group-text" id="basic-addon1">€</span></div><input type="number" min="1" class="form-control" name="no_advance1[]" id="no_advance1" required></div></div>' +
		'<div class="form-group"><label for="no_advance2">No advance (TND)</label><div class="input-group mb-3"><div class="input-group-prepend"><span class="input-group-text" id="basic-addon1">TND</span></div><input type="number" min="1" class="form-control" name="no_advance2[]" id="no_advance2" required></div></div>' +

		'<div class="form-group mt-5"><button onclick="addDateRange1()" id="firstbutton" type="button" class="btn btn-success"><i class="fa fa-plus"></i> Add Date Range</button></div>';
	var data = '<div class="">' + packages[0].innerHTML + fieldHTML1 + price1 + '</div>';
	console.log(data);
	if (x < max_fields) {
		x++;
		$(wrapper).append(data);
	}

}


function addDateRange() {


	var packages = document.getElementsByClassName("package");
	// var packages = document.getElementById('packs').value;
	console.log(packages[0]);
	// var packages = $('#display_packagess');

	var max_fields = 10;
	var x = 1;
	$('#new').css('display', 'block');

	var wrapper = $(".input_fields_wrap");
	var fieldHTML1 = '<div class="form-group"><label for= "start_date">Start date</label><input type="date" class="form-control" name="start_date[]" id="start_date" required></div><div class="form-group"><label for="end_date">End date</label><input type="date" class="form-control" name="end_date[]" id="end_date" required></div>';
	var price1 = '<label for="">Pricing</label> <br>' +
		'<div class="form-group">' +
		'<label for="price_per_night1">Price per night (€)</label>' +
		'<div class="input-group mb-3">' +
		'<div class="input-group-prepend">' +
		'<span class="input-group-text" id="basic-addon1">€</span>' +
		'</div>' +
		'<input type="number" min="1" class="form-control" name="price_per_night1[]" id="price_per_night1" required>' +
		'</div>' +
		'</div>' +
		'<div class="form-group">' +
		'<label for="price_per_night1">Price per night (TND)</label>' +
		'<div class="input-group mb-3">' +
		'<div class="input-group-prepend">' +
		'<span class="input-group-text" id="basic-addon1">TND</span>' +
		'</div>' +
		'<input type="number" min="1" class="form-control" name="price_per_night2[]" id="price_per_night1" required>' +
		'</div>' +
		'</div>' +
		'<div class="form-group">' +
		'<label for="non_refundable1">Non refundable (€)</label>' +
		'<div class="input-group mb-3">' +
		'<div class="input-group-prepend">' +
		'<span class="input-group-text" id="basic-addon1">€</span>' +
		'</div>' +
		'<input type="number" min="1" class="form-control" name="non_refundable1[]" id="non_refundable1" required>' +
		'</div>' +
		'</div>' +
		'<div class="form-group">' +
		'<label for="non_refundable2">Non refundable (TND)</label>' +
		'<div class="input-group mb-3">' +
		'<div class="input-group-prepend">' +
		'<span class="input-group-text" id="basic-addon1">TND</span>' +
		'</div>' +
		'<input type="number" min="1" class="form-control" name="non_refundable2[]" id="non_refundable2" required>' +
		'</div>' +
		'</div>' +
		'<div class="form-group">' +
		'<label for="modifiable1">Modifiable (€)</label>' +
		'<div class="input-group mb-3">' +
		'<div class="input-group-prepend">' +
		'<span class="input-group-text" id="basic-addon1">€</span>' +
		'</div>' +
		'<input type="number" min="1" class="form-control" name="modifiable1[]" id="modifiable1" required>' +
		'</div>' +
		'</div>' +
		'<div class="form-group"><label for="modifiable2">Modifiable (TND)</label><div class="input-group mb-3"><div class="input-group-prepend"><span class="input-group-text" id="basic-addon1">TND</span></div><input type="number" min="1" class="form-control" name="modifiable2[]" id="modifiable2" required></div></div>' +

		'<div class="form-group"><label for="prepayment1">Prepayment (€)</label><div class="input-group mb-3"><div class="input-group-prepend"><span class="input-group-text" id="basic-addon1">€</span></div><input type="number" min="1" class="form-control" name="prepayment1[]" id="prepayment1" required></div></div>' +
		'<div class="form-group"><label for="prepayment2">Prepayment (TND)</label><div class="input-group mb-3"><div class="input-group-prepend"><span class="input-group-text" id="basic-addon1">TND</span></div><input type="number" min="1" class="form-control" name="prepayment2[]" id="prepayment2" required></div></div>' +

		'<div class="form-group"><label for="no_advance1">No advance (€)</label><div class="input-group mb-3"><div class="input-group-prepend"><span class="input-group-text" id="basic-addon1">€</span></div><input type="number" min="1" class="form-control" name="no_advance1[]" id="no_advance1" required></div></div>' +
		'<div class="form-group"><label for="no_advance2">No advance (TND)</label><div class="input-group mb-3"><div class="input-group-prepend"><span class="input-group-text" id="basic-addon1">TND</span></div><input type="number" min="1" class="form-control" name="no_advance2[]" id="no_advance2" required></div></div>' +

		'<div class="form-group mt-5"><button onclick="addDateRange1()" id="firstbutton" type="button" class="btn btn-success"><i class="fa fa-plus"></i> Add Date Range</button></div>';
	var data = '<div class="">' + packages[0].innerHTML + fieldHTML1 + price1 + '</div>';
	var data = '<div class="">' + packages[0].innerHTML + fieldHTML1 + price1 + '</div>';
	console.log(data);
	if (x < max_fields) {
		x++;
		$(wrapper).append(data);
	}

}



function addPrice() {

	$('#display_packages').css('display', 'block');
}

function addPrice1() {
	var max_fields = 10;
	var x = 1;
	var wrapper = $(".input_fields_wrap");
	var fieldHTML = '<div class="mt-5"><input class="mt-5" type="date" name="datefrom1[]" value="" /></div><div><input class="mt-5" type="date" name="dateto1[]" value="" /></div><div><input class="mt-5" type="text" placeholder="Price per person per night (€)" name="rangeprice11[]" value="" /></div><div><input class="mt-5" type="text" mb-5" placeholder="Price per person per night (TND)" name="rangeprice22[]" value=""/></div>';
	if (x < max_fields) {
		x++;
		$(wrapper).append(fieldHTML);
	}
}

$(wrapper).on('click', '.remove_button', function (e) {
	e.preventDefault();
	$(this).parent('div').remove(); //Remove field html
	x--; //Decrement field counter
});


