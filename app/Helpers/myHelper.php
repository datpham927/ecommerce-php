<?php

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
?>
