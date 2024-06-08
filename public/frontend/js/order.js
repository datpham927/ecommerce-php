
$(function () {
// hủy đơn đặt hàng
$('.btn-is-canceled').on('click', function (e) {
    e.preventDefault();
    const dataUrl = $(this).data("url");
    $.ajax({
        type: 'PUT',
        url: dataUrl,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response.code === 200) {
                window.location.href = '/order/canceled';
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

})