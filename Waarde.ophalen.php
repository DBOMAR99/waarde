<?php
$port = 3306;
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "studiekeuze10daagse";

// Maak verbinding met de database
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Controleer de verbinding
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Verwerk de POST-aanvraag
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $woord = $_POST['woord'];
    $categorie = $_POST['categorie'];

    // Controleer of de gegevens niet leeg zijn
    if (!empty($woord) && !empty($categorie)) {
        // Beveilig invoerdata
        $woord = $conn->real_escape_string($woord);
        $categorie = $conn->real_escape_string($categorie);

        // SQL-query om gegevens in de database op te slaan
        $sql = "INSERT INTO waarden (Name, categorie) VALUES ('$woord', '$categorie')";

        if ($conn->query($sql) === TRUE) {
            echo "Data succesvol opgeslagen!";
        } else {
            echo "Fout bij opslaan: " . $conn->error;
        }
    } else {
        echo "Alle velden moeten worden ingevuld!";
    }
}

$conn->close();
?>
