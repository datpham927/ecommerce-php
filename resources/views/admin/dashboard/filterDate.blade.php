<div style="padding: 30px 0;">
    <div class="col-sm-12 m-b-xs" style="display: flex;">
        <form autocomplete="off" id="filter-form"
            style="display: flex; justify-items: center; text-align: center; gap:20px">
            <input style="text-align: center;" name="from_date" value="{{ $fromDate ?? '' }}" type="text"
                placeholder="Từ ngày" class="datepicker input-sm form-control input-from-date">
            <input style="text-align: center;" name="to_date" value="{{ $toDate ?? '' }}" type="text"
                placeholder="Đến ngày" class="datepicker input-sm form-control input-to-date">

            <select style="text-align: center;" name="date" class="dashboard-filter form-control">
                <option value="">-- Lọc theo --</option>
                <option value="7ngay" {{ $dateFilter === '7ngay' ? 'selected' : '' }}>7 ngày qua</option>
                <option value="thangtruoc" {{ $dateFilter === 'thangtruoc' ? 'selected' : '' }}>Tháng trước</option>
                <option value="thangnay" {{ $dateFilter === 'thangnay' ? 'selected' : '' }}>Tháng này</option>
                <option value="365ngayqua" {{ $dateFilter === '365ngayqua' ? 'selected' : '' }}>365 ngày qua</option>
            </select>

            <button type="submit">Lọc</button>
            </f>
    </div>
</div>