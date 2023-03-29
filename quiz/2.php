<?php

declare(strict_types=1);

function isBalanced($str): bool {
    $stack = [];
    $openBrackets = ['(', '[', '{'];
    $closeBrackets = [')', ']', '}'];
    $bracketMap = [
        ')' => '(',
        ']' => '[',
        '}' => '{'
    ];

    for ($i = 0; $i < strlen($str); $i++) {
        $ch = $str[$i];

        if (in_array($ch, $openBrackets)) {
            $stack[] = $ch;
        }
        elseif (in_array($ch, $closeBrackets)) {
            if (empty($stack) || $stack[count($stack)-1] != $bracketMap[$ch]) {
                return false;
            }
            else {
                array_pop($stack);
            }
        }
    }

    return empty($stack);
}

var_dump(isBalanced('([])[]{[()]}({})')); //true
var_dump(isBalanced('([)]')); //false
var_dump(isBalanced('((()')); //false
