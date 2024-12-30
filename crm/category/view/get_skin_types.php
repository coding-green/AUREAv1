<?php
include '../../config.php';

$sql = "SELECT * FROM SkinTypes";
$result = mysqli_query($conn, $sql);

$productTypes = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $productTypes[] = $row;
    }
}

echo json_encode($productTypes);
mysqli_close($conn);
?>

