<?php
require_once("config.php");
use Guestbook\Classes\DB;
use Guestbook\Classes\Validator;
use Guestbook\Classes\User;

if (!empty($_SESSION['user_id'])) {
    header("location: /index.php");
    exit;
}
$errors = [];
if (!empty($_POST)) {
    $validator = new Validator(new DB());
    foreach ($_POST as $k => $v) {
        $validator->checkEmpty($k, $v);
    }
    $errors = $validator->errors;
    if (empty($errors)) {
        $user = new User();
        $user = $user->checkLogin($_POST['user_name'], sha1($_POST['password'].SALT));
        if (!empty($user->id)) {
            $_SESSION['user_id'] = $user->id;
            header("location: /index.php");
            exit;
        } else {
            $errors[] = 'Please enter valid credentails';
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Guest Book</title>
    <meta charset="UTF-8">
</head>
<body>
<h1>Log In Page</h1>
<div>
    <form method="POST">
        <div style="color: red;">
            <?php foreach ($errors as $error) :?>
                <p><?php echo $error;?></p>
            <?php endforeach; ?>
        </div>
        <div>
            <label>User Name / Email:</label>
            <div>
                <input type="text" name="user_name" required="" value="<?php echo (!empty($_POST['user_name']) ? $_POST['user_name'] : '');?>"/>
            </div>
        </div>
        <div>
            <label>Password:</label>
            <div>
                <input type="password" name="password" required="" value=""/>
            </div>
        </div>
        <div>
            <br/>
            <input type="submit" name="submit" value="Log In">
        </div>      
    </form>
</div>
</body>
</html>