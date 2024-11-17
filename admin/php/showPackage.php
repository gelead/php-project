<?php
    // Read Operation
    include '../../php/connection.php';
    $sql = "SELECT id, name, description, price FROM packages";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "id: " . $row["id"]. " - Name: " . $row["name"]. " - Description: " . $row["description"]. " - Price: $" . $row["price"]. "<br>";
        }
    } else {
        echo "0 results";
    }
?>
