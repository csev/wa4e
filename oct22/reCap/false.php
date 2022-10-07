<!DOCTYPE html>
<html>
<body>

<?php

$data = array(1, 1., NULL, new stdClass, FALSE, TRUE, 'foo');

foreach ($data as $value) {
    echo gettype($value), "\n";


}

?>

</body>
</html> 