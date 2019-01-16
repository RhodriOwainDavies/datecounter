<?php
date_default_timezone_set( 'UTC' );
require("DateCalculator.class.php");
require("DateCalculatorForm.class.php");

$form = new DateCalculatorForm(
    array_key_exists('start', $_GET) ? $_GET['start'] : null,
    array_key_exists('end', $_GET) ? $_GET['end'] : null,
    array_key_exists('startTimezone', $_GET) ? $_GET['startTimezone'] : null,
    array_key_exists('endTimezone', $_GET) ? $_GET['endTimezone'] : null,
    array_key_exists('unit', $_GET) ? $_GET['unit'] : null       
);    
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
                <input
                    class="datepicker"
                    type="text"
                    name="start"
                    value="<?php echo $form->getStartDate();?>"
                />
            </div>
            <div>
                <select name="startTimezone">
                <?php foreach ($form->getTimezones() as $key=>$value):
                    if($key == $form->getStartTimezone()):
                        echo '<option value="'.$key.'" selected>'.$value.'</option>';
                    else:
                        echo '<option value="'.$key.'">'.$value.'</option>';
                    endif;
                endforeach;?>
                </select>
            </div>
            <h2>End Date</h2>
            <div>
                <input
                    class="datepicker"
                    type="text"
                    name="end"
                    value="<?php echo $form->getEndDate()?>"
                />
            </div>
            <div>
                <select name="endTimezone">
                <?php foreach ($form->getTimezones() as $key=>$value):
                    if($key == $form->getEndTimezone()):
                        echo '<option value="'.$key.'" selected>'.$value.'</option>';
                    else:
                        echo '<option value="'.$key.'">'.$value.'</option>';
                    endif;
                endforeach;?>
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
        <?php
        $dateCalculator = new DateCalculator(
            $form->getStartDate(),
            $form->getEndDate(),
            $form->getStartTimezone('value'),
            $form->getEndTimezone('value'),
            $form->getUnit()
        );
        ?>
        <hr/>

        <h3>Number of Days</h3>
        <div>
            <p><?php echo $dateCalculator->getNumberOfDays('days'); ?> days</p>
            <p><?php echo $dateCalculator->getNumberOfDays($form->getUnit()) . ' ' . $form->getUnit(); ?></p>
        </div>

        <h3>Weekdays</h3>
        <div>
            <p><?php echo $dateCalculator->getWeekdays('days'); ?> week days</p>
            <p><?php echo $dateCalculator->getWeekdays($form->getUnit()) . ' ' . $form->getUnit(); ?></p>
        </div>

        <h3>Complete Weeks</h3>
        <div>
            <p><?php echo $dateCalculator->getCompleteWeeks('weeks'); ?> complete weeks</p>
            <p><?php echo $dateCalculator->getCompleteWeeks($form->getUnit()) . ' ' . $form->getUnit(); ?></p>
        </div>
    </body>
</html>