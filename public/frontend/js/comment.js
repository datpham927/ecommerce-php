$(function () {
    // Submit comment on pressing Enter key
    $('.btn-comment').on('keypress', function (event) {
        if (event.which === 13) {
            const dataUrl = $(this).data("url");
            const text = $(this).val();
            const ratingValue = $("#rating-input").val();
            if (!ratingValue) {
                alert("Vui lòng chọn đánh giá bằng sao!")
                return;
            }
            const pathName = window.location.pathname;
            const self = $(this);
            $.ajax({
                type: 'post',
                url: dataUrl,
                data: { comment_text: text, pathName, comment_rating: ratingValue },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.code === 200) {
                        self.val("");
                        location.reload();
                    } else {
                        console.log(response.message);
                        alert(response.message);
                    }
                },
                error: function (error) {
                    console.log(error);
                    alert("Đã xảy ra lỗi!");
                }
            });
        }
    });

    // Show reply input
    $('.btn-rep-comment').on('click', function (event) {
        const parent = $(this).closest(".comment-item-body");
        const inputComment = parent.find(".input-comment-rep");
        inputComment.addClass('active').focus();
    });

    // Hide reply input on blur
    $('.input-comment-rep').on('blur', function (event) {
        $(this).val("").removeClass('active');
    });

    // Add children comment
    $('.input-comment-rep').on('keypress', function (event) {
        if (event.which === 13) {
            const dataUrl = $(this).data("url");
            const text = $(this).val();
            const pathName = window.location.pathname;
            const self = $(this);
            $.ajax({
                type: 'post',
                url: dataUrl,
                data: { comment_text: text, pathName },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.code === 200) {
                        self.val("").removeClass('active');
                        location.reload();
                    } else {
                        console.log(response.message);
                        alert(response.message);
                    }
                },
                error: function (error) {
                    console.log(error);
                    alert("Đã xảy ra lỗi!");
                }
            });
        }
    });

    // Delete comment
    $(".btn-delete-comment").on('click', function () {
        if (confirm("Bạn có muốn xóa bình luận này không?")) {
            const dataUrl = $(this).data("url");
            $.ajax({
                type: "delete",
                url: dataUrl,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: (res) => {
                    if (res.code == 200) {
                        location.reload();
                    }
                }
            });
        }
    });

    // Hover effect for star ratings
    $("div.star-wrapper i").on("mouseover", function () {
        if ($(this).siblings("i.vote-recorded").length == 0) {
            $(this)
                .prevAll()
                .addBack()
                .addClass("fa-solid yellow")
                .removeClass("fa-regular");
            $(this).nextAll().removeClass("fa-solid yellow").addClass("fa-regular");
        }
    });

    // Set rating value on hover over stars
    $('.fa-star').hover(function () {
        var rating = $(this).data('rating');
        $(this).parent().siblings('#rating-input').val(rating);
    }, function () {
        // Do nothing on hover out
    });

    // Create and append hidden input element for rating value
    var hiddenInput = $('<input>', {
        type: 'hidden',
        id: 'rating-input',
        value: ''
    });
    $('.rating-wrapper').append(hiddenInput);
});
