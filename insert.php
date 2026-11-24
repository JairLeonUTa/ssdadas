<?php
include "conexion.php";

if ($_POST["tipo"] === "cliente") {
    $sql = "INSERT INTO clientes (cliID, cliNombre, cliApellido, cliDireccion, cliTelefono)
            VALUES (?, ?, ?, ?, ?)";
    $datos = [$_POST["cliID"], $_POST["cliNombre"], $_POST["cliApellido"],
              $_POST["cliDireccion"], $_POST["cliTelefono"]];
} elseif ($_POST["tipo"] === "producto") {
    $sql = "INSERT INTO productos (proID, proNombre) VALUES (?, ?)";
    $datos = [$_POST["proID"], $_POST["proNombre"]];
} else {
    $sql = "INSERT INTO pedidos (pedClienteID, pedProductoID, pedFecha) VALUES (?, ?, ?)";
    $datos = [$_POST["pedClienteID"], $_POST["pedProductoID"], $_POST["pedFecha"]];
}

$consulta = $conn->prepare($sql);
$consulta->execute($datos);
echo json_encode(["id" => $conn->insert_id]);
?>