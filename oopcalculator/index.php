<?php
session_start();
if (!isset($_SESSION['expression'])) {
    $_SESSION['expression'] = '';
}
$buttons = [
    ['C', 'CE',  'MC'],
    ['7', '8', '9', '/'],
    ['4', '5', '6', '*'],
    ['1', '2', '3', '-'],
    ['±', '0', '.', '+'],
    ['M+', 'M-', 'MR', '=']
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP OOP Calculator</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <div class="calculator">
        <h2>PHP OOP Calculator</h2>
        <form action="process.php" method="post">
            <div class="display"><?= htmlspecialchars($_SESSION['expression']) ?></div>
            <div class="buttons">
                <?php foreach ($buttons as $row): ?>
                    <div class="row">
                        <?php foreach ($row as $button): ?>
                            <button type="submit" name="button" value="<?= $button ?>"><?= $button ?></button>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </form>
    </div>
</body>
</html>
