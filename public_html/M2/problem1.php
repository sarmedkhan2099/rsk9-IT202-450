<?php
require_once "base.php";

$ucid = "rsk9"; // <-- set your ucid

// Don't edit the arrays below, they are used to test your code
$array1 = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
$array2 = [9, 8, 7, 6, 5, 4, 3, 2, 1, 0];
$array3 = [0, 0, 1, 1, 2, 2, 3, 3, 4, 4, 5, 5, 6, 6, 7, 7, 8, 8, 9, 9];
$array4 = [9, 9, 8, 8, 7, 7, 6, 6, 5, 5, 4, 4, 3, 3, 2, 2, 1, 1, 0, 0];

function printOdds($arr, $arrayNumber)
{
    // Only make edits between the designated "Start" and "End" comments
    printArrayInfo($arr, $arrayNumber);

    // Challenge: Print odd values only in a single line separated by commas
    // Step 1: sketch out plan using comments (include ucid and date)
    // Step 2: Add/commit your outline of comments (required for full credit)
    // Step 3: Add code to solve the problem (add/commit as needed)

    echo "Output Array: ";
    // Start Solution Edits

    // rsk9 6-8-2025

    //step 1: Iterate through the array using a foreach loop
    //step 2: Check if each number is odd (use modulo operator)
    //step 3: If it is odd, store it in a new array
    //step 4: Join the odd numbers using implode to display them comma-separated

    $odds = [];
    foreach ($arr as $num) {
        if ($num % 2 !== 0) {
            $odds[] = $num;
        }
    }

    echo implode(", ", $odds);

    // End Solution Edits
    echo "<br>______________________________________<br>";
}

// Run the problem
printHeader($ucid, 1);
printOdds($array1, 1);
printOdds($array2, 2);
printOdds($array3, 3);
printOdds($array4, 4);
printFooter($ucid, 1);