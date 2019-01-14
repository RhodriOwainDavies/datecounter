<?php
date_default_timezone_set( 'UTC' );
require("DateCalculator.class.php");

/**
1. Find out the number of days between two datetime parameters.
1. Find out the number of weekdays between two datetime parameters.
1. Find out the number of complete weeks between two datetime parameters.
1. Accept a third parameter to convert the result of (1, 2 or 3) into one of seconds, minutes, hours, years.
1. Allow the specification of a timezone for comparison of input parameters from different timezones.
*/

$defaultStart = date('d/m/Y', strtotime('01/01/2019'));
$defaultEnd = date('d/m/Y', strtotime('today'));
if (isset($_GET['start'])) {
	$start = $_GET['start'];	
}
if (isset($_GET['end'])) {
	$end = $_GET['end'];
}

$timezones = DateTimeZone::listIdentifiers(DateTimeZone::ALL);

?>

<html>
	<head>
		<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  		<link rel="stylesheet" href="/resources/demos/style.css">
  		<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( ".datepicker" ).datepicker({
    	"dateFormat": "dd/mm/yy"
    });
  } );
  </script>
		<title>A Date Calculator Exercise</title>
	</head>
	<body>
		<h1>A Date Calculator Exercise</h1>
		<form method="GET">
			<h2>Start Date</h2>
			<div>
				<input class="datepicker" type="text" name="start" value="<?php echo isset($start) ? $start : $defaultStart;?>"/>
			</div>
			<div>
				<select name="startTimezone">
					<?php foreach ($timezones as $key=>$value): ?>
						<?php echo '<option value="'.$key.'">'.$value.'</option>';?>
        			<?php endforeach; ?>
				</select>
			</div>
			<h2>End Date</h2>
			<div>
				<input class="datepicker" type="text" name="end" value="<?php echo isset($end) ? $end : $defaultEnd;?>"/>
			</div>
			<div>
				<select name="endTimezone">
					<?php foreach ($timezones as $key=>$value): ?>
						<?php echo '<option value="'.$key.'">'.$value.'</option>';?>
        			<?php endforeach; ?>
				</select>
			</div>
			<h2>Unit</h2>
			<div>
				<select name="unit">
					<option value="seconds">Seconds</option>
					<option value="minutes">Minutes</option>
					<option value="hours">Hours</option>
					<option value="years">Years</option>				
				</select>
			</div>
			<div>
				<input type="submit" value="Submit" />
			</div>
		</form>
		<?php if (isset($start) && isset($end)):


			$utc = new DateTime();

			$startParts = explode('/', $start);
			$endParts = explode('/', $end);
			$unit = $_GET['unit'];

			$startOffset = timezone_offset_get(timezone_open($timezones[$_GET['startTimezone']]), $utc);
			$endOffset = timezone_offset_get(timezone_open($timezones[$_GET['endTimezone']]), $utc);

			$startTimestamp = mktime(0, 0, $startOffset, $startParts[1], $startParts[0], $startParts[2]);
			$endTimestamp = mktime(0, 0, $endOffset, $endParts[1], $endParts[0], $endParts[2]);

			$dateCalculator = new DateCalculator($startTimestamp, $endTimestamp);
		?>
			<hr/>
			<h2>Start Date</h2>
			<div><?php echo date('r', $startTimestamp);?></div>

			<h2>End Date</h2>
			<div><?php echo date('r', $endTimestamp);?></div>
			
			<hr/>
			
			<h3>Number of Days</h3>
			<div>
				<p><?php echo $dateCalculator->getNumberOfDays(); ?> days</p>
				<p><?php echo $dateCalculator->getNumberOfDays($unit) . ' ' . $unit; ?></p>
			</div>
			
			<h3>Weekdays</h3>
			<div>
				<p><?php echo $dateCalculator->getWeekdays(); ?> week days</p>
				<p><?php echo $dateCalculator->getWeekdays($unit) . ' ' . $unit; ?></p>
			</div>

			<h3>Complete Weeks (Sunday to Saturday)</h3>
			<div>
				<p><?php echo $dateCalculator->getCompleteWeeks(); ?> complete weeks</p>
				<p><?php echo $dateCalculator->getCompleteWeeks($unit) . ' ' . $unit; ?></p>
			</div>

		<?php endif; ?>
	</body>
</html>