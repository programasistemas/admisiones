<?php
require_once 'regex.inc.php';

$output = '';

foreach (getRegexExpressions() as $i => $exp) {
    $output .= "{$i}:{$exp}, ";
}

echo '<script>const expressions = {' . $output . ' }</script>';
