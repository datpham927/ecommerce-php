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