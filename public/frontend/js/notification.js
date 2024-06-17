$(function () {
    // Submit comment on pressing Enter key
    $('.btn-notification').on('click', function (event) {
            const dataUrl = $(this).data("url");
            $.ajax({
                type: 'put',
                url: dataUrl,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }, 
            });
    }); 
});
