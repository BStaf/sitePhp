<html>
<body>

User: <?php echo $_POST["user"]; ?><br>
Pass: <?php echo $_POST["passw"]; ?><br>
<br>
Writes:<br>
<?php
$string = preg_replace("/\r/\n", "<br>", $_POST["bentry"]);
echo $string;

?>

</body>
</html>