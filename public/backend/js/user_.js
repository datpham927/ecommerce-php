




$(function() {
    // Assuming #publishButton is the ID of the button triggering the request
    $('.user-avatar').change(function () {
        const dataUrl = $(this).data("url"); 
        const formData = new FormData();
        formData.append('image', $(this)[0].files[0]); 
        const parent = $(this).closest(".add-avatar");
        console.log()
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
    $('.btn-delete-staff').on('click', function(e) {
        e.preventDefault();
        const dataUrl = $(this).data("url");
        const parent = $(this).closest("tr");
        if (confirm("Bạn có muốn xóa nhân viên này không?")) {
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
                        alert(response.message);
                    }
                },
                error: function(error) {
                    console.log(error);
                    alert(response.message);
                }
            });
        }
    });
    // customer

    $('.btn-delete-customer').on('click', function(e) {
        e.preventDefault();
        const dataUrl = $(this).data("url");
        const parent = $(this).closest("tr");
        if (confirm("Bạn có muốn xóa tài khoản này không?")) {
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
                        alert(response.message);
                    }
                },
                error: function(error) {
                    console.log(error);
                    alert(response.message);
                }
            });
        }
    });


    $('.btn-customer-is_block').on('click', function(e) {
        e.preventDefault();
        const dataUrl = $(this).data("url");
        if (confirm("Bạn có muốn chặn tài khoản này không?")) {
            $.ajax({
                type: 'POST',
                url: dataUrl,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.code === 200) {
                        alert(response.message);
                        location.reload();
                    } else {
                        alert(response.message);
                    }
                },
                error: function(error) {
                    console.log(error);
                    alert(response.message);
                }
            });
        }
    });

    $('.btn-customer-is_active').on('click', function(e) {
        e.preventDefault();
        const dataUrl = $(this).data("url");
        if (confirm("Bạn có muốn tài khoản này hoạt động không?")) {
            $.ajax({
                type: 'POST',
                url: dataUrl,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.code === 200) {
                        alert(response.message);
                        location.reload();
                    } else {
                        alert(response.message);
                    }
                },
                error: function(error) {
                    console.log(error);
                    alert(response.message);
                }
            });
        }
    });
    
})

 
