<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Calculator</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            text-align: center; 
            display: flex;
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
            height: 80px;
            width: 100%;
            border-radius: 10px;
            background: #dde1e7;
            box-shadow: inset -5px -5px 9px rgba(255,255,255,0.45), inset 5px 5px 9px rgba(94,104,121,0.3);
            border: 0;
            color: rgb(60, 60, 60);
            font-size: 2.5rem;
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
    <div class="input">
        <input type="text" id="operation" value="<?php echo $_SESSION['operation'] ?? ''; ?>" readonly>
    </div>
    <div class="input" style="margin-top: 10px;">
        <input type="text" id="result" value="<?php echo $_SESSION['result'] ?? '0'; ?>" readonly>
    </div>

    <div class="buttons">
        <button onclick="sendInput('C')">C</button>
        <button onclick="sendInput('CE')">CE</button>
        <button onclick="sendInput('(')">(</button>
        <button onclick="sendInput(')')">)</button>

        <button onclick="sendInput('7')">7</button>
        <button onclick="sendInput('8')">8</button>
        <button onclick="sendInput('9')">9</button>
        <button onclick="sendInput('/')">÷</button>

        <button onclick="sendInput('4')">4</button>
        <button onclick="sendInput('5')">5</button>
        <button onclick="sendInput('6')">6</button>
        <button onclick="sendInput('*')">×</button>

        <button onclick="sendInput('1')">1</button>
        <button onclick="sendInput('2')">2</button>
        <button onclick="sendInput('3')">3</button>
        <button onclick="sendInput('-')">−</button>

        <button onclick="sendInput('0')">0</button>
        <button onclick="sendInput('.')">.</button>
        <button onclick="sendInput('^')">^</button>
        <button onclick="sendInput('+')">+</button>

        <button onclick="sendInput('√')">√</button>
        <button onclick="sendInput('!')">!</button>
        <button class="equal" onclick="sendInput('=')">=</button>
    </div>
</div>

<script>
    function sendInput(value) 
    {
        fetch("Calculator.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "button=" + encodeURIComponent(value)
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById("operation").value = data.operation;
            document.getElementById("result").value = data.result;
        })
        .catch(error => console.error("Error:", error));
    }
</script>

</body>
</html>
