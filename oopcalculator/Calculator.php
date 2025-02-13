<?php
session_start();

class Calculator {
    private $operation;
    private $memory;

    public function __construct() 
    {
        $this->operation = $_SESSION['operation'] ?? '';
        $this->memory = $_SESSION['memory'] ?? 0;
    }
    public function clear() 
    {
        $this->operation = '';
        $_SESSION['result'] = '0';
    }
    
    public function backspace() 
    {
        
        $this->operation = substr($this->operation, 0, -1);
        $_SESSION['operation'] = $this->operation;
    }


    public function appendToOperation($input) 
    {
        if ($this->validateInput($input)) 
        {
            if ($input === "." && (empty($this->operation) || preg_match('/[^\d]$/', $this->operation))) {
                $this->operation .= "0.";
            } elseif ($input === "." && preg_match('/\d+\.\d*$/', $this->operation)) {
                return;
            } elseif ($input === "." && preg_match('/\.$/', $this->operation)) {
                return;
            } elseif ($input === "." && preg_match('/\d+\.\d+$/', $this->operation)) {
                return;
            } else {
                $this->operation .= $input;
            }
        }
    }

    private function validateInput($input) 
    {
        return !preg_match('/[\+\-\*\/\^!]{2,}/', $this->operation . $input);
    }

    private function tokenize($expression)
     {
        preg_match_all('/√|-?\d+(\.\d+)?|[\+\-\*\/\^\(\)]|!/', $expression, $matches);
        return $matches[0] ?? [];
    }

    private function convertToPostfix($tokens)
     {
        $precedence = ['+' => 1, '-' => 1, '*' => 2, '/' => 2, '^' => 3, '√' => 4, '!' => 5];
        $rightAssociative = ['^', '√', '!'];
        $output = [];
        $operators = [];

        foreach ($tokens as $token) 
        {
            if (is_numeric($token)) 
            {
                $output[] = $token;
            } elseif ($token === '√' || $token === '!') 
            {
                $operators[] = $token;
            } elseif (isset($precedence[$token])) 
            {
                while (!empty($operators) && isset($precedence[end($operators)]) &&
                      (($precedence[end($operators)] > $precedence[$token]) ||
                       ($precedence[end($operators)] == $precedence[$token] && !in_array($token, $rightAssociative)))) {
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
                if (count($stack) < 1) return 'Error: Invalid expression';
                $b = array_pop($stack);
                if ($b < 0) return 'Error: Square root of negative number';
                $stack[] = sqrt($b);
            } elseif ($token === '!') 
            {
                if (count($stack) < 1) return 'Error: Invalid expression';
                $b = array_pop($stack);
                if ($b < 0 || floor($b) != $b) return 'Error: Factorial requires non-negative integers';
                $stack[] = gmp_intval(gmp_fact($b));
            } else 
            {
                if (count($stack) < 2) return 'Error: Invalid expression';

                $b = array_pop($stack);
                $a = array_pop($stack);

                switch ($token) {
                    case '+': $stack[] = $a + $b; break;
                    case '-': $stack[] = $a - $b; break;
                    case '*': $stack[] = $a * $b; break;
                    case '/': 
                        if ($b == 0) return 'Error: Division by zero';
                        $stack[] = $a / $b; 
                        break;
                    case '^': $stack[] = pow($a, $b); break;
                }
            }
        }

        return $stack[0] ?? 'Error';
    }

    public function evaluate() 
    {
        if (empty($this->operation)) return 'Error: Empty expression';
        $tokens = $this->tokenize($this->operation);
        if (empty($tokens)) return 'Error: Invalid input';
        $postfix = $this->convertToPostfix($tokens);
        return $this->evaluatePostfix($postfix);
    }

    public function getOperation() 
    {
        return $this->operation;
    }

    public function saveToSession() 
    {
        $_SESSION['operation'] = $this->operation;
        $_SESSION['memory'] = $this->memory;
    }
}

$calculator = new Calculator();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['button'])) 
{
    $button = $_POST['button'];

    if (is_numeric($button) || in_array($button, ['+', '-', '*', '/', '(', ')', '.', '^', '√', '!']))
     {
        $calculator->appendToOperation($button);
    } elseif ($button === "C") {
        $calculator->clear();
    } elseif ($button === "CE") {
        $calculator->backspace();
    } elseif ($button === "=") {
        $_SESSION['result'] = $calculator->evaluate();
    }

    $calculator->saveToSession();

    
    echo json_encode([
        "operation" => $_SESSION['operation'] ?? '',
        "result" => $_SESSION['result'] ?? '0'
    ]);
    exit;
} 
?>