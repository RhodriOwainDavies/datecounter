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
                <?php foreach ($form->getUnits() as $key=>$value):
                    if($key == $form->getUnit()):
                        echo '<option value="'.$key.'" selected>'.$value.'</option>';
                    else:
                        echo '<option value="'.$key.'">'.$value.'</option>';
                    endif;
                endforeach;?>                    				
                </select>
            </div>
            <div>
                <input type="submit" value="Submit" />
            </div>
        </form>
        <hr/>
        <?php if($form->validate()): ?>
            <?php foreach($form->getDateCalculationData() as $key=>$data): ?>
            <h3><?php echo $data['label'];?></h3>
            <p><?php echo $data['value']; ?> <?php echo $data['default_unit']; ?></p>
            <p><?php echo $data['value_in_unit']; ?> <?php echo $form->getUnit(); ?></p>
            <?php endforeach; ?>
        <?php else: ?>    
            <div class="error">Invalid Form Data</div>
        <?php endif; ?>
    </body>
</html>