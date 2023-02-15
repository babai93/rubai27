<?php
echo '<p style="text-align: right;">';
echo '<input onclick="parent.window.close();" value="Close [x]" type="button">';
echo '</p>';
// Show all information, defaults to INFO_ALL
phpinfo();

// Show just the module information.
// phpinfo(8) yields identical results.
phpinfo(INFO_MODULES);
?>
