<?php
// functions.php
require_once 'config/config.php';

function evaluateExpression($expression)
{
    $expression = str_replace(' ', '', $expression);
    preg_match_all('/(\d+\.\d+|\d+|[+\-*\/()])/', $expression, $matches);
    $tokens = $matches[0];

    $operands = [];
    $operators = [];
    $precedence = ['+' => 1, '-' => 1, '*' => 2, '/' => 2];

    function applyOperator(&$operators, &$operands)
    {
        if (count($operands) < 2)
            return;
        $operator = array_pop($operators);
        $right = array_pop($operands);
        $left = array_pop($operands);

        switch ($operator) {
            case '+':
                $operands[] = $left + $right;
                break;
            case '-':
                $operands[] = $left - $right;
                break;
            case '*':
                $operands[] = $left * $right;
                break;
            case '/':
                $operands[] = ($right == 0) ? 'Error' : $left / $right;
                break;
        }
    }

    foreach ($tokens as $token) {
        if (is_numeric($token)) {
            $operands[] = (float) $token;
        } elseif (isset($precedence[$token])) {
            while (!empty($operators) && $precedence[end($operators)] >= $precedence[$token]) {
                applyOperator($operators, $operands);
            }
            $operators[] = $token;
        } elseif ($token === '(') {
            $operators[] = $token;
        } elseif ($token === ')') {
            while (!empty($operators) && end($operators) !== '(') {
                applyOperator($operators, $operands);
            }
            array_pop($operators);
        }
    }

    while (!empty($operators)) {
        applyOperator($operators, $operands);
    }

    return isset($operands[0]) ? $operands[0] : 'Error';
}

function handleButtonPress($button)
{
    if (!isset($_SESSION['input']))
        $_SESSION['input'] = '';
    if (!isset($_SESSION['result']))
        $_SESSION['result'] = '';
    if (!isset($_SESSION['expression']))
        $_SESSION['expression'] = '';
    if (!isset($_SESSION['memory']))
        $_SESSION['memory'] = 0;

    $input = $_SESSION['input'];
    $lastChar = substr($input, -1);
    $operators = ['+', '-', '*', '/'];

    switch ($button) {
        case 'C':
            $_SESSION['input'] = '';
            $_SESSION['result'] = '';
            $_SESSION['expression'] = '';
            break;

        case 'CE':
            $_SESSION['input'] = '';
            break;

        case 'Back':
            $_SESSION['input'] = substr($input, 0, -1);
            break;

        case '=':
            if ($input === '' || in_array($lastChar, $operators))
                return;
            $_SESSION['expression'] = $_SESSION['input'];
            $_SESSION['result'] = evaluateExpression($_SESSION['input']);
            $_SESSION['input'] = '';
            break;

        case 'M+':
            $_SESSION['memory'] += floatval($_SESSION['result']) ?: floatval($_SESSION['input']);
            break;

        case 'M-':
            $_SESSION['memory'] -= floatval($_SESSION['result']) ?: floatval($_SESSION['input']);
            break;

        case 'MR':
            $_SESSION['input'] = $_SESSION['memory'];
            break;

        case 'MC':
            $_SESSION['memory'] = 0;
            break;

        case '.':
            if (!preg_match('/\d+\.\d*$/', $input)) {
                $_SESSION['input'] .= $button;
            }
            break;
        case '±':
            if ($input === '')
                return;

            // If input ends with a number, toggle its sign
            if (is_numeric($input)) {
                $_SESSION['input'] = (float) $input * -1;
            } else {
                // Check if the last entered token is a number
                preg_match('/[\d.]+$/', $input, $matches);
                if (!empty($matches)) {
                    $number = $matches[0];
                    $toggled = (float) $number * -1;
                    $_SESSION['input'] = substr($input, 0, -strlen($number)) . $toggled;
                }
                // If the last character is an operator, allow "-"" for negative numbers
                elseif (in_array($lastChar, ['+', '-', '*', '/'])) {
                    $_SESSION['input'] .= '-';
                }
            }
            break;



        default:
            if ($_SESSION['result'] !== '') {
                $_SESSION['input'] = '';
                $_SESSION['result'] = '';
                $_SESSION['expression'] = '';
            }

            if (in_array($button, $operators)) {
                if ($input === '' && $button !== '-')
                    return;
                if (in_array($lastChar, $operators))
                    return;
            }
            $_SESSION['input'] .= $button;
    }
}

function getInputAsString($input)
{
    return htmlspecialchars($input);
}
?>