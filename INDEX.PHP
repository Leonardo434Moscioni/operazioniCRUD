<?php
header("Content-Type: application/json");
include 'db.php';

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

 
    case 'GET':
        $result = $conn->query("SELECT * FROM persona");
        $data = [];

        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        echo json_encode($data);
        break;

    case 'POST':
        $input = json_decode(file_get_contents("php://input"), true);

        $nome = $input['nome'];
        $cognome = $input['cognome'];
        $email = $input['email'];

        $sql = "INSERT INTO persona (nome, cognome, email) 
                VALUES ('$nome', '$cognome', '$email')";

        if ($conn->query($sql)) {
            echo json_encode(["message" => "Persona creata"]);
        } else {
            echo json_encode(["error" => $conn->error]);
        }
        break;

    case 'PUT':
        $input = json_decode(file_get_contents("php://input"), true);

        $id = $input['id'];
        $nome = $input['nome'];
        $cognome = $input['cognome'];
        $email = $input['email'];

        $sql = "UPDATE persona 
                SET nome='$nome', cognome='$cognome', email='$email'
                WHERE id=$id";

        if ($conn->query($sql)) {
            echo json_encode(["message" => "Persona aggiornata"]);
        } else {
            echo json_encode(["error" => $conn->error]);
        }
        break;

    case 'DELETE':
        parse_str(file_get_contents("php://input"), $input);
        $id = $input['id'];

        $sql = "DELETE FROM persona WHERE id=$id";

        if ($conn->query($sql)) {
            echo json_encode(["message" => "Persona eliminata"]);
        } else {
            echo json_encode(["error" => $conn->error]);
        }
        break;

    default:
        echo json_encode(["message" => "Metodo non supportato"]);
        break;
}

$conn->close();
?>
