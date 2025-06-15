<?php

require_once "base.php";

$ucid = "rsk9"; // <-- set your ucid

// Don't edit the arrays below, they are used to test your code
$array1 = [42, -17, 89, -256, 1024, -4096, 50000, -123456];
$array2 = [3.14159265358979, -2.718281828459, 1.61803398875, -0.5772156649, 0.0000001, -1000000.0];
$array3 = [1.1, -2.2, 3.3, -4.4, 5.5, -6.6, 7.7, -8.8];
$array4 = ["123", "-456", "789.01", "-234.56", "0.00001", "-99999999"];
$array5 = [-1, 1, 2.0, -2.0, "3", "-3.0"];

function bePositive($arr, $arrayNumber)
{
    // Only make edits between the designated "Start" and "End" comments
    printArrayInfoMixed($arr, $arrayNumber);

    // Challenge 1: Make each value positive
    // Challenge 2: Convert the values back to their original data type and assign it to the proper slot of the `output` array
    // Step 1: sketch out plan using comments (include ucid and date)
    // Step 2: Add/commit your outline of comments (required for full credit)
    // Step 3: Add code to solve the problem (add/commit as needed)

    $output = array_fill(0, count($arr), null); // Initialize output array
    // Start Solution Edits

    // rsk9 - 6/8/2025

    // Step 1: Loop through each element in the array
    // Step 2: Convert to numeric value using (float) or (int), get absolute value
    // Step 3: Check the original type: is it int, float, or string?
    // Step 4: Convert back to original type:
    //         - if int: cast to int
    //         - if float: cast to float
    //         - if string: keep as string using abs() on float-casted value and convert back to string

    foreach ($arr as $i => $val) {
        $absVal = abs($val); // get absolute value

        if (is_int($val)) {
            $output[$i] = (int)$absVal;
        } elseif (is_float($val)) {
            $output[$i] = (float)$absVal;
        } elseif (is_string($val)) {
            // preserve number format in string by converting to float first
            $output[$i] = (string)abs((float)$val);
        }
    }

    // End Solution Edits
    echo "<span>Output: </span>";
    printOutputWithType($output);
    echo "<br>______________________________________<br>";
}

// Run the problem
printHeader($ucid, 3);
bePositive($array1, 1);
bePositive($array2, 2);
bePositive($array3, 3);
bePositive($array4, 4);
bePositive($array5, 5);
printFooter($ucid, 3);