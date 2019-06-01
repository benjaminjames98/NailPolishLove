<?php

require_once 'private.php';

require_once 'utils.php';
$db = get_db();

if (isset($_POST['send_message'])) {
    // called if the page was called by the 'send_message' button
    if (trim($_POST['message']) == '') $error = 'no message provided';
    else {
        $stmt = $db->prepare("INSERT INTO Message (from_user_id, to_user_id, datetime, text) VALUES (?, ?, NOW(), ?)");
        $stmt->bind_param("sss", $_SESSION['id'], $_POST['id'], $_POST['message']);
        $stmt->execute();
        $stmt->close();
    }
}

// get preferences overlap in array
// btw, this may be the greatest thing I have ever written in my life
$query = <<<SQL
SELECT u1.id,
       u1.username,
       u1.profile,
       u1.photo_url,
       COUNT(*) as overlap
FROM Likes l1
         JOIN Likes l2 ON l1.nailpolish_id = l2.nailpolish_id
         JOIN User u1 ON l1.user_id = u1.id
         JOIN User u2 ON l2.user_id = u2.id AND u1.id != u2.id
         LEFT OUTER JOIN Message m ON m.to_user_id = u1.id AND m.from_user_id = u2.id
WHERE u2.id = ? AND m.from_user_id IS NULL
GROUP BY u1.id
ORDER BY overlap DESC, u1.id ASC;
SQL;
$stmt = $db->prepare($query);
$stmt->bind_param('s', $_SESSION['id']);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($id, $username, $profile, $photo_url, $overlap);
$users = [];
while ($stmt->fetch())
    $users[] = ['id' => $id, 'username' => $username, 'profile' => $profile, 'photo_url' => $photo_url, 'overlap' => $overlap];
$stmt->close();
?>

<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Matches</title>
</head>
<body>
<?php require_once 'navbar.php'; ?>
<h1>Potential Matches</h1>
<?php if (isset($error)) echo "<p style='color: red'>$error</p><br>"; ?>
<!-- this section prints the users from the $user array -->
<?php foreach ($users as $u) { ?>
    <div>
        <img src="<?= $u['photo_url'] ?>" height="60" width="60">
        <p><?= $u['username'] ?> <br style="line-height:0px;" />
        overlap: <?= $u['overlap'] ?> <br style="line-height:0px;" />
        <?= $u['profile'] ?></p>
        <form method="post">
            <input type="text" name="message" maxlength="256">
            <input type="hidden" name="id" value="<?= $u['id'] ?>">
            <input type="submit" name="send_message" value="Send Message">
        </form>
    </div> <br>
<?php } ?>
</body>

</html>
