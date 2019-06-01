<?php

require_once 'utils.php';
$db = get_db();

// get 3 most like nail polishes
$query = <<<SQL
SELECT n.id, n.title,
       COUNT(*) as likes
FROM Likes l
         JOIN NailPolish n ON l.nailpolish_id = n.id
GROUP BY n.id
ORDER BY likes DESC, n.id ASC 
LIMIT 3;
SQL;
$stmt = $db->prepare($query);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($id, $title, $likes);
$likes = [];
echo "<h1>Top 3 Polishes</h1>";
while ($stmt->fetch())
    echo "<p>id: $id - name: $title - likes: $likes";
$stmt->close();

// get the most popular day of the week to get messages
$query = <<<SQL
SELECT DAYOFWEEK(datetime) as day
FROM Message
GROUP BY day
ORDER BY day DESC
LIMIT 1;
SQL;
$stmt = $db->prepare($query);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($day);
$stmt->fetch();
echo "<h1>Most Popular Day of Week to Message</h1>";
echo ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'][$day - 1];
$stmt->close();