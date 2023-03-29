<?php

declare(strict_types=1);

function permuteUnique(array $nums) {

    sort($nums); // sort to handle duplicates

    $n = count($nums);

    if ($n < 1 || $n > 8) {
        throw new Exception('Input array length should be between 1 and 8');
    }

    $validatedNums = array_filter($nums, function ($value) {
        return is_int($value) && $value >= -10 && $value <= 10;
    });

    if (count($validatedNums) < $n) {
        throw new Exception('Input array values should be an integer between -10 and 10');
    }

    $visited = array_fill(0, $n, false);
    $result = [];

    $backtrack = function ($path, $visited) use (&$result, &$nums, &$backtrack, $n) {
        if(count($path) == $n) {
            $result[] = $path;
            return;
        }

        $used = [];

        for($i = 0; $i < $n; $i++) {
            if($visited[$i] || in_array($nums[$i], $used)) {
                continue;
            }

            $used[] = $nums[$i];
            $visited[$i] = true;
            $backtrack(array_merge($path, array($nums[$i])), $visited);
            $visited[$i] = false;
        }
    };

    $backtrack([], $visited);

    return $result;
}

print_r(permuteUnique([1,2,3]));