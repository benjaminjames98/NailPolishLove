<?php

require_once 'private.php';

require_once 'utils.php';
$db = get_db();

if (isset($_POST['save'])) {
    // called if the page was called by the 'save' button
    $stmt = $db->prepare("UPDATE User SET profile = ?, photo_url = ? WHERE username = ?");
    $stmt->bind_param("sss", $_POST['profile'], $_POST['photo_url'], $_SESSION['username']);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($profile, $photo_url);
    $stmt->fetch();
    $stmt->close();

    $_SESSION['photo_url'] = $_POST['photo_url'];
}

if (isset($_POST['save_preferences'])) {
    // called if the page was called by the 'save_preferences' button
    // remove all existing likes
    $stmt = $db->prepare("DELETE FROM Likes WHERE user_id = ?");
    $stmt->bind_param("s", $_SESSION['id']);
    $stmt->execute();
    $stmt->close();

    // add likes back in
    $likes = $_POST;
    unset($likes['save_preferences']);
    $likes = array_keys($likes);
    $stmt = $db->prepare("INSERT INTO Likes (user_id, nailpolish_id) VALUES (?, ?)");
    foreach ($likes as $like) {
        $stmt->bind_param("ss", $_SESSION['id'], $like);
        $stmt->execute();
    }
    $stmt->close();
}

// get profile and photo information
$stmt = $db->prepare("SELECT profile, photo_url FROM User WHERE username = ?;");
$stmt->bind_param("s", $_SESSION['username']);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($profile, $photo_url);
$stmt->fetch();
$stmt->close();

// get polish preferences in array
$query = <<<SQL
SELECT n.id, n.title, (SELECT COUNT(l.nailpolish_id) FROM Likes as l WHERE l.nailpolish_id = n.id AND l.user_id = ?)
FROM NailPolish as n
ORDER BY n.id;
SQL;
$stmt = $db->prepare($query);
$stmt->bind_param('s', $_SESSION['id']);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($id, $title, $liked);
$polishes = [];
while ($stmt->fetch()) $polishes[] = ['id' => $id, 'title' => $title, 'liked' => $liked != 0];
$stmt->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Settings</title>
</head>
<body>
<?php require_once 'navbar.php'; ?>

<h1>Settings</h1>
<form id="form" method="post">
    Profile Text:<br>
    <textarea name="profile" maxlength="128"><?= $profile ?></textarea><br>
    Photo URL:<br>
    <input type="text" name="photo_url" maxlength="128" value="<?= $photo_url ?>"><br>
    <input type="submit" name="cancel" value="Cancel">
    <input type="submit" name="save" value="Save">
</form>

<h1>Polish you Like</h1>
<form id="form" method="post">
    Select the polishes you like: <br>
    <!-- this section prints the checkboxes from the previously submitted array -->
    <?php foreach ($polishes as $p) { ?>
        <input type="checkbox" name="<?= $p['id'] ?>" <?= ($p['liked']) ? 'checked' : '' ?> ><?= $p['title'] ?><br>
    <?php } ?>
    <input type="submit" value="Cancel">
    <input type="submit" name="save_preferences" value="Save">
</form>
</body>
</html>