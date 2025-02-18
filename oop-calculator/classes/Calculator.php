<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class Calculator {
    private $operation;
    private $memory;
    private static $instance = null;

    private function __construct() 
    {
        $this->operation = $_SESSION['operation'] ?? '';
        $this->memory = $_SESSION['memory'] ?? 0;
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Calculator();
        }
        return self::$instance;
    }

    public function clear() {
        $this->operation = '';
        $_SESSION['result'] = '0';
    }

    public function backspace() {

        $this->operation = substr($this->operation, 0, -1);
    }

    public function appendToOperation($input) {
        if ($this->validateInput($input)) {
            $this->operation .= $input;
        }
    }

    private function validateInput($input) {
        return !preg_match('/[\+\-\*\/\^!]{2,}/', $this->operation . $input);
    }

    public function evaluate() {
        if (empty($this->operation)) return 'Error: Empty expression';
        $tokens = $this->tokenize($this->operation);
        if (empty($tokens)) return 'Error: Invalid input';

        $result = 0;
        $stack = [];
        foreach ($tokens as $token) {
            if (is_numeric($token)) {
                $stack[] = $token;
            } else {
                $operation = OperationFactory::create($token);
                if (count($stack) < 2) return 'Error: Invalid expression';
                $b = array_pop($stack);
                $a = array_pop($stack);
                $stack[] = $operation->execute($a, $b);
            }
        }
        return $stack[0] ?? 'Error';
    }

    private function tokenize($expression) {
        preg_match_all('/\d+(\.\d+)?|[+\-*/^√!()]/', $expression, $matches);
        return $matches[0] ?? [];
    }

    public function saveToSession() {
        $_SESSION['operation'] = $this->operation;
        $_SESSION['memory'] = $this->memory;
    }
}
?>
