<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BMI Calculator</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <section class="wrapper">
        <div class= "inner">
            <h2>BMI Calculator <span>&hearts;</span></h2>
        </div>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
    <div class="section1">
        <span>Height</span>
        <div class="input-group">
		<input id="height" class="form-control" name="height" type="number" step="any" value="<?php if(!empty($Height)){echo $Height;}?>">
			<select class="form-select" name="heightUnit">
				<option value="centimeter" <?php if(isset($HeightUnit) && $HeightUnit=='centimeter'){echo "selected";}?>>Centimeter</option>
				<option value="inch" <?php if(isset($HeightUnit) && $HeightUnit=='inch'){echo "selected";}?>>Inch</option>
				<option value="foot" <?php if(isset($HeightUnit) && $HeightUnit=='foot' || !isset($HeightUnit)){echo "selected";}?>>Foot</option>
				<option value="meter" <?php if(isset($HeightUnit) && $HeightUnit=='meter'){echo "selected";}?>>Meter</option>
			</select>
        </div>
    </div>
    <div class="section2">
        <span>Weight</span>
        <div class="input-group">
			<input id="weight" class="form-control" name="weight" type="number" step="any" value="<?php if(!empty($Weight)){echo $Weight;}?>">
				<select class="form-select" name="weightUnit">
					<option value="kilogram" <?php if(isset($WeightUnit) && $WeightUnit=='kilogram'){echo "selected";}?>>Kilogram</option>
					<option value="pound" <?php if(isset($WeightUnit) && $WeightUnit=='pound'){echo "selected";}?>>Pound</option>
				</select>
		</div>
    </div>    
    <div class="submit">
        <input type="submit" name="submit" value="Calculate">
        <input type="reset" value="Clear">
    </div>
</form>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$Height=$_POST['height'];
	$HeightUnit=$_POST['heightUnit'];
	$Weight=$_POST['weight'];
	$WeightUnit=$_POST['weightUnit'];
	if($Height == '' || $Weight == '' || $HeightUnit == '' || $WeightUnit == ''){
		$Error = "The input values are required.";
	}
	elseif (filter_var($Height, FILTER_VALIDATE_FLOAT) === false || filter_var($Weight, FILTER_VALIDATE_FLOAT) === false) {
		$Error = "The input value must be a number only.";
	}
	else{
		/*Convert cm to inch -> foot to inch -> meter to inch */
		$HInches = ($HeightUnit=='centimeter')?$Height*0.393701:(($HeightUnit=='foot')?$Height*12:(($HeightUnit=='meter')?$Height*39.3700787:$Height));
		/*Convert kg to pound*/
		$WPound = ($WeightUnit=='kilogram')?$Weight*2.2:$Weight;
		$BMIIndex = round($WPound/($HInches*$HInches)* 703,2);

		/*Set Message*/
		if ($BMIIndex < 18.5) {
			$Message="Underweight | Low body weight. You need to gain weight by eating moderately.";
			echo "<span style='display:block; margin-top:5px ;margin-right:50px'></span>";?>
			<img src="img/UW.png" class="one" >
            <?php
		} else if ($BMIIndex <= 24.9) {
			$Message="Normal | The standard of good health.";
			echo "<span style='display:block; margin-top:5px ;margin-right:50px'></span>";?>
            <img src="img/NM.png" class="two"><?php
		} else if ($BMIIndex <= 29.9) {
			$Message="Overweight | Excess body weight. Exercise needs to reduce excess weight.";
			echo "<span style='display:block; margin-top:5px ;margin-right:50px'></span>";?>
            <img src="img/OW.png" class="three"><?php
		} else {
			$Message="Obese | The first stage of obesity. It is necessary to choose food and exercise.";
			echo "<span style='display:block; margin-top:5px ;margin-right:50px'></span>";?>
            <img src="img/OB.png" class="four"><?php
		}	
	}
	
} ?>


<?php if(isset($BMIIndex) && is_numeric($BMIIndex)){?><!-- Result -->
		<div class="row">
			<div class="col">
				<label for="Result" class="result">Result</label>
				<input id="Result" name="Result" class="form-control2" value="<?php echo $BMIIndex.' '.$Message; ?>">
			</div>
		</div>
		<?php } if(isset($Error)){?><!-- Error Messages -->
		<div class="row">
			<div class="col">
				<div class="alert" role="alert">Error: <?php echo $Error; ?></div>
			</div>
		</div>
	<?php } ?>
</section>


</body>
</html>