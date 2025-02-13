<?php
session_start();
require_once 'functions.php';
if (!isset($_SESSION['expression'])) {
    $_SESSION['expression'] = '';
}
if (!isset($_SESSION['input'])) {
    $_SESSION['input'] = '';
}
if (!isset($_SESSION['result'])) {
    $_SESSION['result'] = '';
}
if (!isset($_SESSION['memory'])) {
    $_SESSION['memory'] = 0;
}
$buttons = [
    ['C', 'CE', 'MC'],
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
    <style>
        #cal-body {
            width: 400px;
            border-radius: 20px;
            background: #dde1e7;
            box-shadow: -5px -5px 9px rgba(255,255,255,0.45), 5px 5px 9px rgba(94,104,121,0.3);
            padding: 45px;
            scale: 0.6;
        }
        .input input {
            height: 100px;
            width: 100%;
            border-radius: 10px;
            background: #dde1e7;
            box-shadow: inset -5px -5px 9px rgba(255,255,255,0.45), inset 5px 5px 9px rgba(94,104,121,0.3);
            border: 0;
            color: rgb(116, 116, 116);
            font-size: 2.5rem;
            padding: 0 30px;
        }
        .input input:focus {
            outline: none;
        }
        .buttons button {
            cursor: pointer;
            height: 60px;
            width: 60px;
            border: 0;
            font-size: 2rem;
            border-radius: 50px;
            background: #dde1e7;
            box-shadow: -5px -5px 9px rgba(255,255,255,0.45), 5px 5px 9px rgba(94,104,121,0.3);
            color: rgb(137, 137, 137);
        }
        .buttons button:focus {
            background: #dde1e7;
            box-shadow: inset -5px -5px 9px rgba(255,255,255,0.45), inset 5px 5px 9px rgba(94,104,121,0.3);
        }
        .buttons {
            padding-top: 30px;
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>
<body>
    <div class="calculator">
        <h2>PHP OOP Calculator</h2>
        <form action="process.php" method="post">
            <div class="display">
                <div class="operation"><?php echo $_SESSION['expression'] !== '' ? htmlspecialchars($_SESSION['expression']) : htmlspecialchars($_SESSION['input']); ?></div>
                <?php if ($_SESSION['result'] !== '' && is_numeric($_SESSION['result'])): ?>
                    <div class="result"><?php echo $_SESSION['result']; ?></div>
                <?php endif; ?>
            </div>
            <div id="cal-body">
                <div style="padding-top: 40px;">
                    <?php foreach ($buttons as $row): ?>
                        <div class="buttons">
                            <?php foreach ($row as $button): ?>
                                <button type="submit" name="button" value="<?= $button ?>"><?= $button ?></button>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
