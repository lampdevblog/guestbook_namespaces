<?php
require_once("config.php");
use Guestbook\Classes\Validator;
use Guestbook\Classes\User;

$requestBody = file_get_contents('php://input');
$data = json_decode($requestBody, true);
$cmd = $data['cmd'];
$value = $data['value'];
$response = ['success' => 0];
if (!empty($cmd) && !empty($value)) {
    $validator = new Validator(new User());
    switch ($cmd) {
        case 'check_username':
            $isAvailable = $validator->isUserNameAvailable($value);
            if (!$isAvailable) {
                $response = ['success' => 1];
            } else {
                $response = ['success' => 0, 'error' => $validator->errors[0]];
            }
            break;
        case 'check_email':
            $isAvailable = $validator->isEmailAvailable($value);
            if (!$isAvailable) {
                $response = ['success' => 1];
            } else {
                $response = ['success' => 0, 'error' => $validator->errors[0]];
            }
            break;
        default:
            break;
    }
}
header('Content-Type: application/json');
echo json_encode($response);
die();
