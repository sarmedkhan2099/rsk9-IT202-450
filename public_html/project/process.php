<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Array Manipulation Results</title>
</head>
<body>
    <h1>Array Manipulation Results</h1>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['names'])) {
        $array = $_POST['names'];
        
        function printArray($array, $withKeys = false) {
            echo "<pre>";
            if ($withKeys) {
                print_r($array);
            } else {
                foreach ($array as $value) {
                    echo "$value ";
                }
            }
            echo "</pre>";
        }

        echo "<h2>Original Array:</h2>";
        echo "<p>Without indexes:</p>";
        printArray($array);
        echo "<p>With indexes:</p>";
        printArray($array, true);

        array_splice($array, 2, 1); 
        array_splice($array, 4, 1);

        echo "<h2>Array after Deleting Two Elements:</h2>";
        echo "<p>Without indexes:</p>";
        printArray(array_values($array));
        echo "<p>With indexes:</p>";
        printArray($array, true);

        $array = array_values($array);

        echo "<h2>Array after Removing Gaps:</h2>";
        echo "<p>Without indexes:</p>";
        printArray($array);
        echo "<p>With indexes:</p>";
        printArray($array, true);

        $sortedArray = $array;
        sort($sortedArray);

        echo "<h2>Array Sorted in Ascending Order:</h2>";
        echo "<p>Without indexes:</p>";
        printArray($sortedArray);
        echo "<p>With indexes:</p>";
        printArray($sortedArray, true);

     
        $sortedDescArray = $array;
        rsort($sortedDescArray);

        echo "<h2>Array Sorted in Descending Order:</h2>";
        echo "<p>Without indexes:</p>";
        printArray($sortedDescArray);
        echo "<p>With indexes:</p>";
        printArray($sortedDescArray, true);

        $sortedAscArray = $array;
        asort($sortedAscArray);

        echo "<h2>Array Sorted in Ascending Order (Keep Keys):</h2>";
        echo "<p>Without indexes:</p>";
        printArray(array_values($sortedAscArray));
        echo "<p>With indexes:</p>";
        printArray($sortedAscArray, true);

        ksort($sortedAscArray);

        echo "<h2>Array Sorted in Ascending Order by Keys:</h2>";
        echo "<p>Without indexes:</p>";
        printArray(array_values($sortedAscArray));
        echo "<p>With indexes:</p>";
        printArray($sortedAscArray, true);
    } else {
        echo "<p>No data was submitted.</p>";
    }
    ?>

</body>
</html>
