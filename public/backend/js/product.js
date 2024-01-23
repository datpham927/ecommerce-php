    // Xử lý sự kiện khi nút "Add Size" được click
    $("#add-size").click(function() {
        // Clone ô kích thước đầu tiên và thêm vào container
        var clone = $(".size-input:first").clone();
        $("#sizes-container").append(clone);

        // Xóa giá trị của input quantity trong clone mới
        clone.find("input[name='quantities[]']").val('');

        // Focus vào ô kích thước của clone mới
        clone.find(".size-select").focus();
    });  

        // Xử lý sự kiện khi nút "Add Size" được click
        $("#add-size").click(function() {
            // Clone ô kích thước đầu tiên và thêm vào container
            var clone = $(".size-input:first").clone();
            $("#sizes-container").append(clone);
    
            // Xóa giá trị của input quantity trong clone mới
            clone.find("input[name='quantities[]']").val('');
    
            // Focus vào ô kích thước của clone mới
            clone.find(".size-select").focus();
        });  