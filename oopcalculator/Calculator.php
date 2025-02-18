<?php
session_start();

class Calculator 
{
    public function __construct() 
    {
        $_SESSION['operation'] = $_SESSION['operation'] ?? '';
        $_SESSION['memory'] = $_SESSION['memory'] ?? 0;
        $_SESSION['result'] = $_SESSION['result'] ?? '0';
        $_SESSION['history'] = $_SESSION['history'] ?? [];
    }

    public function clear() 
    {
        $_SESSION['operation'] = '';
        $_SESSION['result'] = '0';
    }

    public function backspace() 
    {
        $_SESSION['operation'] = substr($_SESSION['operation'], 0, -1);
    }

    public function appendToOperation($input) 
    {
        // 🔹 FIX: Ensure decimals are properly handled
        if ($input === '.') {
            // If empty or after an operator, add "0."
            if (empty($_SESSION['operation']) || preg_match('/[\+\-\*\/\^]$/', $_SESSION['operation'])) {
                $_SESSION['operation'] .= '0.';
                return;
            }
            // Ensure a number has only one decimal point
            $lastNumber = preg_split('/[\+\-\*\/\^]/', $_SESSION['operation']);
            if (strpos(end($lastNumber), '.') !== false) {
                return;
            }
        }
        
        if ($this->validateInput($input)) 
        {
            $_SESSION['operation'] .= $input;
        }
    }

    private function validateInput($input) 
    {
        return !preg_match('/[\+\-\*\/^]{2,}|\(\)|\d+\(/', $_SESSION['operation'] . $input);
    }

    public function evaluate() 
    {
        if (empty($_SESSION['operation'])) return 'Error: Empty expression';

        $tokens = $this->tokenize($_SESSION['operation']);
        $postfix = $this->convertToPostfix($tokens);
        $result = $this->evaluatePostfix($postfix);

        if ($result === "Error") {
            $_SESSION['result'] = "Error";
        } else {
            $_SESSION['result'] = $result;
            $_SESSION['history'][] = $_SESSION['operation'] . " = " . $result;
        }
        $_SESSION['operation'] = '';

        return $_SESSION['result'];
    }

    private function tokenize($expression) 
    {
        preg_match_all('/\d+\.\d+|\d+|[\+\-\*\/\^\(\)!√]/', $expression, $matches);
        return $matches[0] ?? [];
    }

    private function convertToPostfix($tokens) 
    {
        $precedence = ['+' => 1, '-' => 1, '*' => 2, '/' => 2, '^' => 3, '√' => 4];
        $output = [];
        $operators = [];

        foreach ($tokens as $token) 
        {
            if (is_numeric($token)) 
            {
                $output[] = $token;
            } elseif ($token === '√') 
            {
                $operators[] = $token;
            } elseif (isset($precedence[$token])) 
            {
                while (!empty($operators) && isset($precedence[end($operators)]) &&
                      ($precedence[end($operators)] >= $precedence[$token])) {
                    $output[] = array_pop($operators);
                }
                $operators[] = $token;
            } elseif ($token === '(') 
            {
                $operators[] = $token;
            } elseif ($token === ')') 
            {
                while (!empty($operators) && end($operators) !== '(') 
                {
                    $output[] = array_pop($operators);
                }
                array_pop($operators);
            }
        }

        while (!empty($operators)) 
        {
            $output[] = array_pop($operators);
        }

        return $output;
    }

    private function evaluatePostfix($postfix) 
    {
        $stack = [];

        foreach ($postfix as $token) 
        {
            if (is_numeric($token))
            {
                $stack[] = floatval($token);
            } elseif ($token === '√') 
            {
                if (count($stack) < 1) return 'Error';
                $b = array_pop($stack);
                if ($b < 0) return 'Error: Negative Root';
                $stack[] = sqrt($b);
            } else 
            {
                if (count($stack) < 2) return 'Error';
                $b = array_pop($stack);
                $a = array_pop($stack);
                switch ($token) {
                    case '+': $stack[] = $a + $b; break;
                    case '-': $stack[] = $a - $b; break;
                    case '*': $stack[] = $a * $b; break;
                    case '/': 
                        if ($b == 0) return 'Error: Division by Zero';
                        $stack[] = $a / $b; 
                        break;
                    case '^': $stack[] = pow($a, $b); break;
                }
            }
        }
        return $stack[0] ?? 'Error';
    }

    private function factorial($n) 
    {
        if ($n === 0 || $n === 1) return 1;
        $result = 1;
        for ($i = 2; $i <= $n; $i++) {
            $result *= $i;
        }
        return $result;
    }


    // 🔹 Memory Functions
    public function memoryRecall() 
    {
        $_SESSION['operation'] = '';
        $_SESSION['result'] = $_SESSION['memory'];
    }

    public function memoryAdd() 
    {
        if (isset($_SESSION['result']) && is_numeric($_SESSION['result'])) {
            $_SESSION['memory'] += floatval($_SESSION['result']);
        }
        $_SESSION['operation'] = '';
    }

    public function memorySubtract() 
    {
        if (isset($_SESSION['result']) && is_numeric($_SESSION['result'])) {
            $_SESSION['memory'] -= floatval($_SESSION['result']);
        }
        $_SESSION['operation'] = '';
    }

    public function memoryClear() 
    {
        $_SESSION['memory'] = 0;
        $_SESSION['result'] = '0';
    }

    public function clearHistory() 
    {
        $_SESSION['history'] = [];
    }
}

// Handle POST requests
$calculator = new Calculator();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['button'])) 
{
    $button = $_POST['button'];

    switch ($button) {
        case 'C': $calculator->clear(); break;
        case 'CE': $calculator->backspace(); break;
        case '=': $calculator->evaluate(); break;
        case 'MR': $calculator->memoryRecall(); break;
        case 'M+': $calculator->memoryAdd(); break;
        case 'M-': $calculator->memorySubtract(); break;
        case 'MC': $calculator->memoryClear(); break;
        case 'CH': $calculator->clearHistory(); break;
        default: $calculator->appendToOperation($button);
    }

    echo json_encode([
        "operation" => $_SESSION['operation'] ?? '',
        "result" => $_SESSION['result'] ?? '0',
        "memory" => $_SESSION['memory'] ?? '0',
        "history" => $_SESSION['history'] ?? []
    ]);
    exit;
}
