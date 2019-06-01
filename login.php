<?php

require_once 'public.php';

if (isset($_POST['username'])) {
    // if information is returned, attempt to log in
    $username = $_POST['username'];
    $password = $_POST['password'];

    require_once 'utils.php';
    $db = get_db();

    $stmt = $db->prepare("SELECT id, password, profile, photo_url FROM User WHERE username = ?;");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows === 0) $error = "that username doesn't seem to exist";
    else {
        $stmt->bind_result($id, $hash, $profile, $photo_url);
        $stmt->fetch();
        if (password_verify($password, $hash)) {
            // correct login
            $_SESSION['username'] = $username;
            $_SESSION['id'] = $id;
            $_SESSION['profile'] = $profile;
            $_SESSION['photo_url'] = $photo_url;
            header("Location: matches.php");
            die();
        } else $error = 'wrong password';
    }
    $stmt->close();
} else {
    $_POST['username'] = '';
    $_POST['password'] = '';
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
<?php require_once 'navbar.php'; ?>
<h1>Login</h1>
<?php if (isset($error)) echo "<p style='color: red'>$error</p><br>"; ?>
<form id="form" method="post">
    username:<br>
    <input type="text" name="username" maxlength="64" value="<?= $_POST['username'] ?>"><br>
    password:<br>
    <input type="password" name="password" maxlength="24"><br>
    <input type="submit" value="Login">
</form>
</body>
</html>