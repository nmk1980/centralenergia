<?php
$servername = "web603.webfaction.com";
$username = "nmk";
$password = "Banco001";
$dbname = "energia";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT c.Nombre_Combustibles as combustible,
                    TIMESTAMPDIFF(HOUR,'2016-01-01 00:00:00',g.FechayHora_Generacion_Hr) as hora,
                    sum(g.Energia_Generacion_Hr) as energia                
            FROM energia.Combustibles c
            INNER JOIN energia.Generacion_Hr g ON g.id_Combustibles_Generacion_Hr= c.id_Combustibles
            WHERE (g.FechayHora_Generacion_Hr BETWEEN '2016-01-01 00:00:00' AND '2016-01-01 23:00:00')
            GROUP BY c.id_Combustibles, g.FechayHora_Generacion_Hr
            ORDER BY c.Nombre_Combustibles, g.FechayHora_Generacion_Hr;";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        echo "Combustible: " .$row["combustible"]. ", Hora: " .$row["hora"]. ", Energia: " .$row["energia"]. "<br>";
    }
} else {
    echo "0 results";
}

mysqli_close($conn);
    
?>