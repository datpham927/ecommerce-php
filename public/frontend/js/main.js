/*price range*/

 $('#sl2').slider();

	var RGBChange = function() {
	  $('#RGB').css('background', 'rgb('+r.getValue()+','+g.getValue()+','+b.getValue()+')')
	};	
  // page detail
	$('.small-image').on('click', function() {
		// Handle the click event here
		var img = $(this).find('img').attr('src');
		// Perform your desired action with the image
		$('.view-product img').attr('src', img);
	});
	// click chọn size 
	$('.btn-size').on('click', function() {
		// Handle the click event here
		var quantityProduct = $(this).attr('title');
		$('.quantity-product').find('span').text(quantityProduct);
		$('#quantity').attr("max", quantityProduct);
		$('#quantity').val(0); // Corrected line to set the value of the input field to 0
  // thêm input ẩn khi click vào select size -> lấy giá trị 
		// Add a hidden input field with the selected size name
		$('<input>').attr({
			type: 'hidden',
			name: 'size_hidden',
			value: $(this).text()
		}).appendTo('.btn-size');
	});
	
	
	