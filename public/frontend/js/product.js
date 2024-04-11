

$(function () {
    // Assuming #publishButton is the ID of the button triggering the request
    $('.cart_quantity_down').on('click', function (e) {
        e.preventDefault();
        const dataUrl = $(this).data("url");
        console.log(dataUrl);
        var $inputField = $(this).closest('.cart_quantity').find('.cart_quantity_input'); // Find the corresponding input field
        const parent = $(this).closest("tr");
        $.ajax({
            type: 'post',
            url: dataUrl,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.code === 200) {
                    var currentValue = parseInt($inputField.val());
                    if (currentValue <= 1) {
                        parent.remove();
                    } else {
                        $inputField.val(currentValue - 1); // Decrease the value by 1
                    }
                } else {
                    console.log(response)
                    alert('Đã xảy ra lỗi!');
                }
            },
            error: function (error) {
                console.log(error);
                alert('Đã xảy ra lỗi!');
            }
        });
    });

    $('.cart_quantity_up').on('click', function (e) {
        e.preventDefault();
        const dataUrl = $(this).data("url");
        var $inputField = $(this).closest('.cart_quantity').find('.cart_quantity_input');
        $.ajax({
            type: 'post',
            url: dataUrl,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.code === 200) {
                    var currentValue = parseInt($inputField.val());
                    $inputField.val(currentValue + 1); // Decrease the value by 1
                } else {
                    alert(response.message );
                }
                console.log(response)
            },
            error: function (error) {
                console.log(error);
                alert('Đã xảy ra lỗi!');
            }
        });
    });

    $('.cart_delete').on('click', function (e) {
        e.preventDefault();
        const dataUrl = $(this).data("url");
        const parent = $(this).closest("tr");
        if (confirm('Bạn có muốn xóa sản phẩm không?')) {
            $.ajax({
                type: 'delete',
                url: dataUrl,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.code === 200) {
                        parent.remove();
                    } else {
                        alert('Đã xảy ra lỗi!');
                    }
                },
                error: function (error) {
                    console.log(error);
                    alert('Đã xảy ra lỗi!');
                }
            });
        }
    });
    // -- hủy đơn hàng
    $('.order-canceled').on('click', function (e) {
        e.preventDefault();
        const dataUrl = $(this).data("url");
        const parent = $(this).closest("tr");
        if (confirm('Bạn có muốn hủy đơn hàng không?')) {
            $.ajax({
                type: 'post',
                url: dataUrl,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.code === 200) {
                        parent.remove();
                    } else {
                        alert('Đã xảy ra lỗi!');
                    }
                },
                error: function (error) {
                    console.log(error);
                    alert('Đã xảy ra lỗi!');
                }
            });
        }
    });
    $('.btn-order').on('click', function (e) {
        if (!confirm("Bạn có chắc muốn tiếp tục?")) {
            e.preventDefault(); // Ngăn chặn submit form nếu người dùng không xác nhận
        }
    });
    

})
