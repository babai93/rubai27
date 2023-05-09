<?php
// Get the amount of free disk space on the server's root partition
$free_space = disk_free_space('/');

// Get the total amount of disk space on the server's root partition
$total_space = disk_total_space('/');

// Get the amount of memory used by the script
$memory_usage = memory_get_usage();

// Get the hostname of the server
$hostname = gethostname();

// Get the operating system information of the server
$os_info = php_uname();
?>

<?php
echo php_uname();
echo PHP_OS;

/* Some possible outputs:
Linux localhost 2.4.21-0.13mdk #1 Fri Mar 14 15:08:06 EST 2003 i686
Linux

FreeBSD localhost 3.2-RELEASE #15: Mon Dec 17 08:46:02 GMT 2001
FreeBSD

Windows NT XN1 5.1 build 2600
WINNT
*/

if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    echo 'This is a server using Windows!';
} else {
    echo 'This is a server not using Windows!';
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    // Output the hostname
    echo "Hostname: $hostname\n";
    echo "<br>";
    // Output the operating system information
    echo "Operating System: $os_info\n";
    echo "<br>";
    // Output the disk space and memory information
    echo "Free Disk Space: " . round($free_space / (1024 * 1024), 2) . " MB\n";
    echo "<br>";
    echo "Total Disk Space: " . round($total_space / (1024 * 1024), 2) . " MB\n";
    echo "<br>";
    echo "Memory Usage: " . round($memory_usage / (1024 * 1024), 2) . " MB\n";
    ?>
</body>
</html>