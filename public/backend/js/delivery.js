$(function() {
    $('.choose').change(function() {
        const action = $(this).attr('id');
        const code = $(this).val();
        $("#ward").html('<option value="0">Chọn xã phường</option>'); // Xóa nội dung của phần tử #ward
        var result = '';
        if (action == 'city') {
             result = "province";
        } else {
            result = "ward";
        }
        $.ajax({
            type: 'POST',
            url: '/admin/delivery/select-delivery',
            data: { action: action, code: code },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                $("#" + result).html(response);
            },
            error: function(error) {
                console.log(error);
                alert('Đã xảy ra lỗi!');
            }
        });
    });
    $(".freeship").change(function(){
        const dataUrl = $(this).data("url");
        const feeship=$(this).val();
        $.ajax({
            method: "put",
            url: dataUrl,
            data: { feeship: feeship },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }, 
            error: function(error) {
                alert('Đã xảy ra lỗi!');
            }
        });
    });
});
