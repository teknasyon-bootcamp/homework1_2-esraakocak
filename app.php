<?php

$gender = "female"; // gender (male/female)
$weight = 48; // weight (kg)
$height = 160; // height (cm)
$age = 24; // age 

$guess = "1470"; // estimated value
if ($gender == "female") { 
    $bmr =   447.593 + (9.247 * $weight) + (3.098 * $height) - (4.330 * $age);
} else { 
    $bmr = 88.362 + (13.397 * $weight) + (4.799 * $height) - (5.677 * $age);
}
echo "BMR: $bmr <pre>";    // <pre> used to move to a bottom line.
echo "Estimated value: $guess <pre>";   


if ($guess < $bmr)
echo "The calculated value is greater than the predicted value.";
else if ($guess == $bmr)
echo "values are equal. ";
else if ($guess > $bmr)
echo "The calculated value is less than the estimated value.";



// backupAnswer.php kısmında ilk yazdığım kod bulunmaktadır.Değerlendirirken app.php kısmını baz alınız.