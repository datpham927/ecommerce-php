<?php

use Carbon\Carbon;

if (!function_exists('renderSettingInputText')) {
    function renderSettingInputText($name, $label, $value) {
        return '
        <div class="form-group">
            <label style="font-size:13px;color:#757575;font-weight:400" for="' . htmlspecialchars($name) . '">' . htmlspecialchars($label) . '</label>
            <input type="text" class="form-control ' . (session()->get('errors') && session()->get('errors')->has($name) ? 'is-invalid' : '') . '"
                id="' . htmlspecialchars($name) . '" name="' . htmlspecialchars($name) . '" placeholder="Nhập ' . htmlspecialchars($label) . '"
                value="' . htmlspecialchars(old($name, $value)) . '" />
        </div>
        ';
    }
}
if (!function_exists('renderSettingInputImage')) {
    function renderSettingInputImage($name, $label, $val = null) {
        return '
        <div class="form-group add-avatar">
            <label for="' . $name . '">
                ' . $label . '
                <img src="' . asset('backend/images/image_logo2.png') . '" style="width: 30px; height: 30px;" />
                <input type="file" class="user-avatar" 
                    data-url="' . route("upload_image") . '"
                    id="' . $name . '" style="display: none;" name="' . $name . '" />
            </label> 
            <img src="' . ($val ? asset($val) : asset('backend/images/avatar.jpg')) . '" style="width: 50px; height: 50px;" />
        </div>';
    }
}

function execPostRequest($url, $data)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data))
    );
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    //execute post
    $result = curl_exec($ch);
    //close connection
    curl_close($ch);
    return $result;
}



if (!function_exists('momoConfig')) {
    function momoConfig() {
        return [
            'partnerCode'=>"MOMOBKUN20180529",
            'accessKey'=>"klm05TvNBzhg7h7j",
            'secretKey'=>"at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa"
        ];
    }
}


if (!function_exists('handleFilterByDate')) {
    function handleFilterByDate($request) {
        $dateFilter="";
        $today = Carbon::now();
        // Initialize default date range
        $fromDate = $today->copy()->startOfMonth();
        $toDate = $today->copy()->endOfMonth();
        // Check for the date filter in the request
        if ($request->has('date')) {
            $dateFilter = $request->input('date');
            switch ($dateFilter) {
                case '7ngay':
                    $fromDate = $today->copy()->subDays(7)->startOfDay();
                    $toDate = $today->copy()->endOfDay();
                    break;
                case 'thangtruoc':
                    $fromDate = $today->copy()->subMonth()->startOfMonth();
                    $toDate = $today->copy()->subMonth()->endOfMonth();
                    break;
                case 'thangnay':
                    $fromDate = $today->copy()->startOfMonth();
                    $toDate = $today->copy()->endOfMonth();
                    break;
                case '365ngayqua':
                    $fromDate = $today->copy()->subDays(365)->startOfDay();
                    $toDate = $today->copy()->endOfDay();
                    break;
                default:
                    // Fallback to default date range
                    $fromDate = $today->copy()->startOfMonth();
                    $toDate = $today->copy()->endOfMonth();
                    break;
            }
        } elseif ($request->has(['from_date', 'to_date'])) {
            // Use custom date range if provided
            $fromDate = Carbon::parse($request->input('from_date'))->startOfDay();
            $toDate = Carbon::parse($request->input('to_date'))->endOfDay();
        }
        return [
           "fromDate"=> $fromDate,
            "toDate"=>$toDate,
            "dateFilter"=>$dateFilter
        ];
    }
}
?>