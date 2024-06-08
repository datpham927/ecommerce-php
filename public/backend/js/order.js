




$(function() {
    // Assuming #publishButton is the ID of the button triggering the request
    $('.btn-confirm-status-order').on('click', function(e) {
        e.preventDefault();
        const dataUrl = $(this).data("url");
        const parent = $(this).closest("tr");
        if (confirm("Bạn có muốn xác nhận sản phẩm này không?")) {
            $.ajax({
                type: 'put',
                url: dataUrl,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.code === 200) {
                        parent.remove();
                        alert('Xác nhận thành công');
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

 
