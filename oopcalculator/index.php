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

        /* History Section */
        #history {
            margin-top: 20px;
            width: 400px;
            max-height: 200px;
            overflow-y: auto;
            background: white;
            border-radius: 10px;
            padding: 10px;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
        }

        #history h3 {
            margin: 0;
            padding-bottom: 10px;
            font-size: 1.2rem;
        }

        #history ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        #history li {
            padding: 5px;
            border-bottom: 1px solid #ccc;
            cursor: pointer;
            user-select: text; /* Allows selection */
        }

        #history li:hover {
            background: #f0f0f0;
        }

        #history li:last-child {
            border-bottom: none;
        }

        #clear-history {
            width: 100%;
            margin-top: 10px;
            padding: 10px;
            font-size: 1rem;
            background: #ff4d4d;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        #clear-history:hover {
            background: #e60000;
        }
    </style>
</head>
<body>
<div class="main-container" style="display:flex; gap:200px; flex-direction:row;">
<div id="cal-body">
    <div class="input">
        <input type="text" id="operation" readonly>
    </div>
    <div class="input" style="margin-top: 10px;">
        <input type="text" id="result" readonly>
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

        <!-- Memory Buttons -->
        <button onclick="sendInput('MR')">MR</button>
        <button onclick="sendInput('M+')">M+</button>
        <button onclick="sendInput('M-')">M-</button>
        <button onclick="sendInput('MC')">MC</button>

        <button class="equal" onclick="sendInput('=')">=</button>
    </div>
</div>

<!-- History Section -->
<div id="history" >
    <h3>Calculation History</h3>
    <ul id="history-list"></ul>
    <button id="clear-history" onclick="clearHistory()">Clear History</button>
</div>
    </div>

<script>
    function sendInput(value) {
        fetch("Calculator.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "button=" + encodeURIComponent(value)
        })
        .then(response => response.json())
        .then(data => {
            if (value === "MR") {
                document.getElementById("operation").value = "";
                document.getElementById("result").value = data.result;
            } else {
                document.getElementById("operation").value = data.operation;
                document.getElementById("result").value = data.result;
            }

            updateHistory(data.history);
        })
        .catch(error => console.error("Error:", error));
    }

    function updateHistory(history) {
        let historyList = document.getElementById("history-list");
        historyList.innerHTML = "";
        history.forEach(entry => {
            let li = document.createElement("li");
            li.textContent = entry;
            li.onclick = function () {
                document.getElementById("operation").value = entry.split(" = ")[0]; // Copy to input
            };
            historyList.prepend(li);
        });
    }

    function clearHistory() {
        fetch("Calculator.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "button=CH"
        })
        .then(response => response.json())
        .then(() => {
            document.getElementById("history-list").innerHTML = "";
        })
        .catch(error => console.error("Error:", error));
    }
</script>

</body>
</html>
