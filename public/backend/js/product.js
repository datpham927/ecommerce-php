// Xử lý sự kiện khi nút "Add Size" được click
$(function() {
    $("#add-size").click(function() {
        // Clone ô kích thước đầu tiên và thêm vào container
        var clone = $(".size-input:first").clone();
        // Xóa giá trị của input quantity trong clone mới
        clone.find("input[name='quantities[]']").val('');
        clone.find("input[name='sizes[]']").val('');
        $("#sizes-container").append(clone);
        // Focus vào ô kích thước của clone mới
        clone.find(".size-select").focus();
    });
})
$(function() {
    $("#sizes-container").on('click', '.remove_input_size', function() {
        var quantity = $(".size-input").length;
        if (quantity > 1) {
            const parent = $(this).closest(".size-input");
            parent.remove();
        } else {
            alert('Không thể xóa!');
        }
    })
});
// Xử lý sự kiện khi nút "thêm attribute" được click
$(function() {
    $("#add-attribute").click(function() {
        // Clone ô kích thước đầu tiên và thêm vào container
        var clone = $(".attribute-input:first").clone();
        // Xóa giá trị của input quantity trong clone mới
        clone.find("input[name='attribute_keys[]']").val('');
        clone.find("input[name='attribute_names[]']").val('');
        $("#attributes-container").append(clone);

        // Focus vào ô kích thước của clone mới
        clone.find(".attribute-select").focus();
    });

})

$(function() {
    $("#attributes-container").on('click', '.remove_input_attribute', function() {
        var quantity = $(".attribute-input").length;
        if (quantity > 1) {
            const parent = $(this).closest(".attribute-input");
            parent.remove();
        } else {
            alert('Không thể xóa!');
        }
    })
});


// public product
$(function() {
    // Assuming #publishButton is the ID of the button triggering the request
    $('.btn-publish-product').on('click', function(e) {
        e.preventDefault();
        const dataUrl = $(this).data("url");
        const parent = $(this).closest("tr");

        if (confirm("Bạn có muốn đăng sản phẩm này không?")) {
            $.ajax({
                type: 'POST',
                url: dataUrl,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(results) {
                    results.code == 200 && parent.remove();
                    alert('Đã đăng!')
                },
                error: function(results) {
                    console.log(results);
                    alert('Đã xảy ra lỗi!')
                }
            });
        }
    })
})

// soft delete product

$(function() {
    // Assuming #publishButton is the ID of the button triggering the request
    $('.btn-delete-product').on('click', function(e) {
        e.preventDefault();
        const dataUrl = $(this).data("url");
        const parent = $(this).closest("tr");
        if (confirm("Bạn có muốn xóa sản phẩm này không?")) {
            $.ajax({
                type: 'DELETE',
                url: dataUrl,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.code === 200) {
                        parent.remove();
                        alert(response.message);
                    } else {
                        alert('Đã xảy ra lỗi!');
                    }
                },
                error: function(error) {
                    console.log(error);
                    alert('Đã xảy ra lỗi!');
                }
            });
        }
    });
})

// restore product

$(function() {
    // Assuming #publishButton is the ID of the button triggering the request
    $('.btn-restore-product').on('click', function(e) {
        e.preventDefault();

        const dataUrl = $(this).data("url");
        const parent = $(this).closest("tr");

        if (confirm("Bạn có muốn khôi phục sản phẩm này không?")) {
            $.ajax({
                type: 'post',
                url: dataUrl,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.code === 200) {
                        parent.remove();
                        alert(response.message);
                    } else {
                        alert('Đã xảy ra lỗi!');
                    }
                },
                error: function(error) {
                    console.log(error);
                    alert('Đã xảy ra lỗi!');
                }
            });
        }
    });
    $('#product_thumb').change(function () {
        const dataUrl = $(this).data("url"); 
        const formData = new FormData();
        formData.append('image', $(this)[0].files[0]); 
        const parent = $(this).closest(".product-thumb"); 
        $.ajax({
            type: 'post',
            url: dataUrl,
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.code === 200) {
                    // Thay thế hình ảnh 
                        parent.find('img').attr('src', response.image);
                } else {
                    console.log(response.message);
                    alert(response.message);
                }
            },
            error: function(error) {
                console.log(error);
                alert(response.message);
            }
        });
    });
})