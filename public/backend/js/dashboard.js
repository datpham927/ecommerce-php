$(document).ready(function () {

    // Initialize calendars
    $('#mycalendar').monthly({ mode: 'event' });
    $('#mycalendar2').monthly({
        mode: 'picker',
        target: '#mytarget',
        setWidth: '250px',
        startHidden: true,
        showTrigger: '#mytarget',
        stylePast: true,
        disablePast: true
    });

    // Check protocol and alert if running locally
    if (window.location.protocol === 'file:') {
        alert('Just a heads-up, events will not work when run locally.');
    }

    // BOX BUTTON SHOW AND CLOSE
    $('.small-graph-box').hover(
        function () { $(this).find('.box-button').fadeIn('fast'); },
        function () { $(this).find('.box-button').fadeOut('fast'); }
    );

    $('.small-graph-box .box-close').click(function () {
        $(this).closest('.small-graph-box').fadeOut(200);
        return false;
    });

    // CHARTS
    var chart = Morris.Area({
        element: 'hero-area',
        padding: 10,
        behaveLikeLine: true,
        gridEnabled: false,
        gridLineColor: '#dddddd',
        axes: true,
        resize: true,
        smooth: true,
        pointSize: 0,
        lineWidth: 0,
        fillOpacity: 0.85,
        lineColors: ['#eb6f6f', '#926383', '#eb6f6f'],
        xkey: 'order_date',
        redraw: true,
        ykeys: ['sales', 'profit', 'quantity', 'total_order'],
        labels: ['Doanh thu', 'Lợi nhuận', 'Sản phẩm đã bán', 'Đơn hàng'],
        pointSize: 2,
        hideHover: 'auto'
    });
    loadChartByCurrentMonth();
    function loadChartByCurrentMonth() {
        // Lấy giá trị từ các phần tử đầu vào
        const fromDate = $(".input-from-date").val();
        const toDate = $(".input-to-date").val();
        const date = $(".dashboard-filter").val();
    
        // Tạo đối tượng data chỉ với các thuộc tính có giá trị
        const data = {
            ...(fromDate && { from_date: fromDate }),
            ...(toDate && { to_date: toDate }),
            ...(date && { date: date })
        };
        // Gửi yêu cầu AJAX
        $.ajax({
            type: 'GET',
            url: "/admin/chart_filter_by_date",
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: data,
            success: function (response) {
                chart.setData(response);
            },
            error: function () {
                alert('Đã xảy ra lỗi!');
            }
        });
    }
    

    // Load chart on form submit
    $('#filter-form').on('submit', function () {
        loadChartByCurrentMonth();
    });

    // Handle date input changes
    function handleDateInputChange() {
        var $dateSelect = $('select[name="date"]');
        $dateSelect.removeAttr('name').val('');
    }

    $('.input-to-date, .input-from-date').change(handleDateInputChange);

    $('.dashboard-filter').change(function () {
        // Kiểm tra nếu giá trị của select không phải là tùy chọn rỗng
        if ($(this).val() !== '') {
            // Xóa giá trị của các input
            $('input[name="from_date"]').val('').removeAttr('name');
            $('input[name="to_date"]').val('').removeAttr('name');
        }
    });

    // Remove empty or default values before form submission
    $('#filter-form').on('submit', function () {
        var fromDate = $('input[name="from_date"]').val().trim();
        var toDate = $('input[name="to_date"]').val().trim();
        var date = $('select[name="date"]').val().trim();

        if (!fromDate) $('input[name="from_date"]').removeAttr('name');
        if (!toDate) $('input[name="to_date"]').removeAttr('name');
        if (date === "" || date === "-- Lọc theo --") $('select[name="date"]').removeAttr('name');
    });

});
