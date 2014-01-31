<?php
include ("connections.php");

// Set Name here
$name = 'BergdoffGoodman';

$query_new_table = "CREATE TABLE `$name` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ProdID` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
)";

if(mysqli_query($link, $query_new_table)){
	echo "Database $name created successfully";
} else {
	echo "Error creating database: " . mysqli_error($link);
}

// Processes products.tsv file
$handle = @fopen("products.tsv", "r");
if ($handle) {
    while (($buffer = fgets($handle)) !== false) {
    $buffer = substr($buffer, 0, strpos($buffer, "	"));
        $query_insert_ids = "INSERT INTO $name (ProdID) values ('$buffer')";
        $result = mysqli_query($link, $query_insert_ids);
    }
    if (!feof($handle)) {
        echo "Error: unexpected fgets() fail\n";
    }
    fclose($handle);
}

// Writes file to same directory with all the duplicates
/*
$sql = mysqli_query($link, "SELECT ProdID, count(*) FROM $name GROUP BY ProdID HAVING count(*) > 1");
echo $sql;
$content = "";

while($row = mysqli_fetch_array($sql)){
  $id = $row["ProdID"];
  $count = $row["count(*)"];

  $accounts = "$id	$count<br>";
  $content .= $accounts;

}

$file = "$name".Dups.".txt";
file_put_contents($file, $content);

*/


// SQL query to get duplicates:
//		Select ProdID, count(*) from SaksFifth group by ProdID having count(*) > 1

?>