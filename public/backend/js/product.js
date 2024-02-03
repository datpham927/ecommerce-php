// Xử lý sự kiện khi nút "Add Size" được click
$("#add-size").click(function() {
    // Clone ô kích thước đầu tiên và thêm vào container
    var clone = $(".size-input:first").clone();
    clone.find("input[name='product_quantities[]']").val('');
    clone.find("input[name='product_sizes[]']").val('');
    $("#sizes-container").append(clone);

    // Xóa giá trị của input quantity trong clone mới

    // Focus vào ô kích thước của clone mới
    clone.find(".size-select").focus();
});

// Xử lý sự kiện khi nút "Add Size" được click
$("#add-attribute").click(function() {
    // Clone ô kích thước đầu tiên và thêm vào container
    var clone = $(".attribute-input:first").clone();
    // Xóa giá trị của input quantity trong clone mới
    clone.find("input[name='product_attribute_keys[]']").val('');
    clone.find("input[name='product_attribute_names[]']").val('');
    $("#attributes-container").append(clone);

    // Focus vào ô kích thước của clone mới
    clone.find(".attribute-select").focus();
});
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
                    console.log(results.code);
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