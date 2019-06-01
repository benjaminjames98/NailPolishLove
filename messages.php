<?php

require_once 'private.php';

require_once 'utils.php';
$db = get_db();

// get messages sent to and from user
$query = <<<SQL
SELECT u1.username, u2.username, m.text, m.datetime
FROM Message m
         JOIN User u1 ON m.to_user_id = u1.id
         JOIN User u2 ON m.from_user_id = u2.id
WHERE u2.id = ?
   OR u1.id = ?
ORDER BY datetime desc;
SQL;
$stmt = $db->prepare($query);
$stmt->bind_param('ss', $_SESSION['id'], $_SESSION['id']);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($username1, $username2, $text, $datetime);
$messages = [];
while ($stmt->fetch())
    $messages[] = ['username1' => $username1, 'username2' => $username2, 'text' => $text, 'datetime' => $datetime];
$stmt->close();

?>

<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Messages</title>
</head>
<body>
<?php require_once 'navbar.php'; ?>
<h1>Received Messages</h1>
<!-- this section prints the messages from the $messages array -->
<?php foreach ($messages as $m) { ?>
    <div>
        <p>to: <?= $m['username1'] ?><br style="line-height:0px;" />
        from: <?= $m['username2'] ?><br style="line-height:0px;" />
        text: <?= $m['text'] ?><br style="line-height:0px;" />
        time: <?= $m['datetime'] ?></p>
    </div> <br>
<?php } ?>
</body>
</html>
