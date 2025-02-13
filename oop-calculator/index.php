<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP OOP Calculator</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            text-align: center; 
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #dde1e7;
        }

        #cal-body {
            width: 400px;
            border-radius: 20px;
            background: #dde1e7;
            box-shadow: -5px -5px 9px rgba(255,255,255,0.45), 5px 5px 9px rgba(94,104,121,0.3);
            padding: 30px;
        }

        .input input {
            height: 60px;
            width: 100%;
            border-radius: 10px;
            background: #dde1e7;
            box-shadow: inset -5px -5px 9px rgba(255,255,255,0.45), inset 5px 5px 9px rgba(94,104,121,0.3);
            border: 0;
            color: rgb(60, 60, 60);
            font-size: 2rem;
            text-align: right;
            padding: 10px;
        }

        .buttons {
            padding-top: 20px;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
        }

        .buttons button {
            cursor: pointer;
            height: 60px;
            width: 60px;
            border: 0;
            font-size: 1.5rem;
            border-radius: 50px;
            background: #dde1e7;
            box-shadow: -5px -5px 9px rgba(255,255,255,0.45), 5px 5px 9px rgba(94,104,121,0.3);
            color: rgb(60, 60, 60);
            transition: all 0.2s ease-in-out;
        }

        .buttons button:active {
            transform: scale(0.95);
        }

        .buttons .equal {
            width: 100%;
            grid-column: span 2;
        }
    </style>
</head>
<body>

<div id="cal-body">
    <form action="process.php" method="POST">
        <div class="input">
            
            <input type="text" name="operation" value="<?php echo $_SESSION['operation'] ?? ''; ?>" readonly>
        
        
            <input type="text" name="result" value="<?php echo $_SESSION['result'] ?? '0'; ?>" readonly>
        </div>

        <div class="buttons">
            <button type="submit" name="button" value="C">C</button>
            <button type="submit" name="button" value="CE">CE</button>
            <button type="submit" name="button" value="(">(</button>
            <button type="submit" name="button" value=")">)</button>

            <button type="submit" name="button" value="7">7</button>
            <button type="submit" name="button" value="8">8</button>
            <button type="submit" name="button" value="9">9</button>
            <button type="submit" name="button" value="/">÷</button>

            <button type="submit" name="button" value="4">4</button>
            <button type="submit" name="button" value="5">5</button>
            <button type="submit" name="button" value="6">6</button>
            <button type="submit" name="button" value="*">×</button>

            <button type="submit" name="button" value="1">1</button>
            <button type="submit" name="button" value="2">2</button>
            <button type="submit" name="button" value="3">3</button>
            <button type="submit" name="button" value="-">−</button>

            <button type="submit" name="button" value="0">0</button>
            <button type="submit" name="button" value=".">.</button>
            <button type="submit" name="button" value="^">^</button>
            <button type="submit" name="button" value="+">+</button>

            <button type="submit" name="button" value="√">√</button>
            <button type="submit" name="button" value="!">!</button>
            <button type="submit" class="equal" name="button" value="=">=</button>
        </div>
    </form>
</div>

</body>
</html>
