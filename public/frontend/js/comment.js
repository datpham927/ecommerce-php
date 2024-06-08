$(function () {
    $('.btn-comment').on('keypress', function (event) {
        // Kiểm tra xem phím được nhấn có phải là phím "Enter" không (mã phím 13)
        if (event.which === 13) {
            const dataUrl = $(this).data("url");
            const text = $(this).val();
            const self = $(this); // Lưu trữ đối tượng jQuery trong biến self để sử dụng trong hàm success
            const pathName=window.location.pathname
            $.ajax({
                type: 'post',
                url: dataUrl,
                data: { comment_text: text ,pathName},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.code === 200) {
                        self.val(""); // Xóa nội dung của input sau khi thêm bình luận thành công
                        location.reload()
                    } else {
                        console.log(response.message);
                        alert(response.message);
                    }
                },
                error: function (error) {
                    console.log(error);
                    alert("Đã xảy ra lỗi!"); // Hiển thị thông báo lỗi mặc định
                }
            });
        }
    });

    // show rep input 
    $('.btn-rep-comment').on('click', function (event) {
        const parent = $(this).closest(".comment-item-body")
        const inputComment = parent.find(".input-comment-rep")
        inputComment.addClass('active');
        inputComment.focus();
    });

    $('.input-comment-rep').on('blur', function (event) {
        $(this).val("");
        $(this).removeClass('active');
    });

    //   -------- add children comment
    $('.input-comment-rep').on('keypress', function (event) {
        // Kiểm tra xem phím được nhấn có phải là phím "Enter" không (mã phím 13)
        if (event.which === 13) {
            const dataUrl = $(this).data("url");
            const text = $(this).val();
            const self = $(this); // Lưu trữ đối tượng jQuery trong biến self để sử dụng trong hàm success
            const pathName=window.location.pathname
            $.ajax({
                type: 'post',
                url: dataUrl,
                data: { comment_text: text,pathName },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.code === 200) {
                        self.val(""); // Xóa nội dung của input sau khi thêm bình luận thành công
                        self.removeClass('active')
                        location.reload()
                    } else {
                        console.log(response.message);
                        alert(response.message);
                    }
                },
                error: function (error) {
                    console.log(error);
                    alert("Đã xảy ra lỗi!"); // Hiển thị thông báo lỗi mặc định
                }
            });
        }
    });

    //   delete comment

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
                        location.reload()
                    }
                }
            })
        }

    })

});
