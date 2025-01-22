<?php
$str = 'one|two|three|four';

// positive limit
print_r(explode('|', $str, 2));

// negative limit
print_r(explode('|', $str, -1));
?>


<!-- explode() is used to split a string into an array using a specified delimiter.
It returns an array where each element is a part of the string split at the delimiter.
You can optionally limit the number of elements returned using the $limit parameter.
It's commonly used for tasks like parsing CSV data, extracting URL parameters, or splitting sentences into words. -->