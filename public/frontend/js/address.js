$(function() {
    $('.choose').change(function() {
        const action = $(this).attr('name');
        const code = $(this).val();
        $(".ward").html('<option value="0">Chọn xã phường</option>'); // Xóa nội dung của phần tử #ward
        let result = '';
        if (action === 'city') {
             result = "province";
        } else {
            result = "ward";
        }
        $.ajax({
            type: 'POST',
            url: 'profile/select-address',
            data: { action: action, code: code },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log(response);
                $("." + result).html(response);
            },
            error: function(error) {
                console.log(error);
                alert('Đã xảy ra lỗi!');
            }
        });
    });  
});
