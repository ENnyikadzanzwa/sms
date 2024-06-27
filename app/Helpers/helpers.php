// app/Helpers/helpers.php
<?php
if (!function_exists('generateRandomPassword')) {
    function generateRandomPassword($length = 8)
    {
        $digits = '0123456789';
        return substr(str_shuffle(str_repeat($digits, $length)), 0, $length);
    }
}
