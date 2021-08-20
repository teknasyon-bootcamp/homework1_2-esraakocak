<?php
function bmr_calories_metric($age, $height_cm, $weight_kg, $gender, $kilojoules = false)
{
    $bmr = 0;
    if ($gender == "female") {
        //	Kadınlar için; 447.593 + (9.247 x kilo) + (3.098 x boy) – (4.330 x yaş)
        $bmr = 447.593 + (9.247 * $weight_kg) + (3.098 * $height_cm) - (4.330 * $age);
    }
    if ($gender == "male") {
        // Erkekler için; 88.362 + (13.397 x kilo) + (4.799 x boy) – (5.677 x yaş)
        $bmr = 88.362 + (13.397 * $weight_kg) + (4.799 * $height_cm) - (5.667 * $age);
    }

    return $bmr;
}

$answer = "";
$dob = "";
$height = "";
$weight = "";
$gender = "";
$result = "";
$guess = "1470";
function yeardob($dob_val)
{
    $dob = new DateTime($dob_val);
    $today = new DateTime('today');
    $obj = date_diff($dob, $today, FALSE);
    return $obj->y;
}
if (isset($_POST["bmrsubmit"])) {
    $dob = $_POST['dob'];
    $height = $_POST['height'];
    $weight = $_POST['weight'];
    $gender = $_POST["gender"];
    /* Age */
    $dob = new DateTime($dob);
    $today = new DateTime('today');
    $obj = date_diff($dob, $today, FALSE);
    $age = $obj->y;
    $date = $dob->format("Y-m-d");

    $bmr = bmr_calories_metric($age, $cm, $weight, $gender, false);
    $activity = $_POST["activity_level"];
    $bmrkj = $bmr * 4.184;

    switch ($activity) {
            /*
			 If you are sedentary (little or no exercise) : Calorie-Calculation = BMR x 1.2
			 If you are lightly active (light exercise/sports 1-3 days/week) :
			 Calorie-Calculation = BMR x 1.375
			 If you are moderatetely active (moderate exercise/sports 3-5 days/week) :
			 Calorie-Calculation = BMR x 1.55
			 If you are very active (hard exercise/sports 6-7 days a week) :
			 Calorie-Calculation = BMR x 1.725
			 If you are extra active (very hard exercise/sports & physical job or 2x
			 training) : Calorie-Calculation = BMR x 1.9
			 */
        case 1:
            $activity_type = "No Activity or No Exercise";
            $calories = $bmr * 1.2;
            break;
        case 2:
            $activity_type = "Light Exercise/Sports 1-3 Days/Week";
            $calories = $bmr * 1.375;
            break;
        case 3:
            $activity_type = "Moderate Exercise/Sports 3-5 Days/Week";
            $calories = $bmr * 1.55;
            break;
        case 4:
            $activity_type = "Hard Exercise/Sports 6-7 Days a Week";
            $calories = $bmr * 1.725;
            break;
        case 5:
            $activity_type = "Very Hard Exercise/Sports & Physical Job or 2x Training";
            $calories = $bmr * 1.9;
            break;
        default:
            $activity_type = "No Activity or No Exercise";
            $calories = $bmr * 1.2;
            break;
    }
    $kilojoules = $calories * 4.184;
    $result = "<p>According to the Age $age Weight $weight Kg And Height $height  ($cm Cm) a " . ucfirst($gender) . ". BMR is  " . number_format($bmr) . ".</p><p>prediction value :$guess.</p><p>if you engage in $activity_type for that day. The estimate for maintaining your current weight (based upon your chosen activity level) is " . number_format($calories) . " calories (" . number_format($kilojoules) . "KJ). </p> ";

    if ($guess < $bmr)
        echo "The calculated value is greater than the predicted value. You can see the result below.";
    else if ($guess == $bmr)
        echo "values are equal. You can see the result below";
    else if ($guess > $bmr)
        echo "The calculated value is less than the estimated value. You can see the result below.";
}

?>
<form method='post'>
    <p>Date of Birth : <input type="date" name="dob" value="<?php echo $date; ?>" required /></p>
    <p>height : <input type="number" name="height" value="<?php echo $height; ?>" step="1" required /> </p>
    <p>Gender : <input type="radio" name="gender" value="female" <?php echo ($gender == "female") ? "checked" : ""; ?> required /> Female <input type="radio" name="gender" value="male" <?php echo ($gender == "male") ? "checked" : ""; ?> /> Male </p>
    <p>Weight :<input type="number" name="weight" value="<?php echo $weight; ?>" step="1" required /></p>
    <p>
        <select name="activity_level">
            <option>Select Exercise Type</option>
            <option value="1">No Activity or No Exercise</option>
            <option value="2">Light Exercise/Sports 1-3 Days/Week</option>
            <option value="3">Moderate Exercise/Sports 3-5 Days/Week</option>
            <option value="4">Hard Exercise/Sports 6-7 Days a Week</option>
            <option value="5">Very Hard Exercise/Sports & Physical Job or 2x Training</option>
        </select>
    </p>


    <p><input type="submit" name="bmrsubmit" value="Get Result" /></p>
    <?php
    echo $result;
    ?>
</form>