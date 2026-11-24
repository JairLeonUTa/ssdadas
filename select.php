<?php
include "conexion.php";

if (isset($_GET["vista"])) {
    $clientes = $conn->query("SELECT cliID, cliNombre, cliApellido FROM clientes");
    $productos = $conn->query("SELECT proID, proNombre FROM productos");
    $resultado = [
        "clientes" => $clientes->fetch_all(MYSQLI_ASSOC),
        "productos" => $productos->fetch_all(MYSQLI_ASSOC)
    ];
} else {
    $cliente = trim($_GET["cliente"] ?? "");
    $pedido = trim($_GET["pedido"] ?? "");

    $sql = "SELECT pedID, pedFecha, cliID, cliNombre, cliApellido, proNombre
            FROM pedidos
            JOIN clientes ON cliID = pedClienteID
            JOIN productos ON proID = pedProductoID
            WHERE (? = '' OR pedID = ?)
              AND (LOCATE(?, cliID) OR LOCATE(?, CONCAT(cliNombre, ' ', cliApellido)))
            ORDER BY pedFecha DESC, pedID DESC";
    $consulta = $conn->prepare($sql);
    $consulta->execute([$pedido, $pedido, $cliente, $cliente]);
    $resultado = ["pedidos" => $consulta->get_result()->fetch_all(MYSQLI_ASSOC)];
}

echo json_encode($resultado);
?>