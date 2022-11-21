<?php
    include_once __DIR__."/database.php";


    //Se crea el arreglo en forma de json que se regresara al cliente
    $data = array();

    // SE REALIZA LA QUERY DE BÚSQUEDA Y AL MISMO TIEMPO SE VALIDA SI HUBO RESULTADOS
    if ( $result = $conexion->query("SELECT s.id, s.titulo, s.rutaPortada, 'tabla1' FROM Serie AS s WHERE eliminado='0' UNION SELECT p.id, p.titulo, p.rutaPortada, 'tabla2' FROM Pelicula AS p WHERE eliminado='0'")) {
        // SE OBTIENEN LOS RESULTADOS
        $rows = $result->fetch_all(MYSQLI_ASSOC);

        if(!is_null($rows)) {
            // SE CODIFICAN A UTF-8 LOS DATOS Y SE MAPEAN AL ARREGLO DE RESPUESTA
            foreach($rows as $num => $row) {
                foreach($row as $key => $value) {
                    $data[$num][$key] = utf8_encode($value);
                }
            }
        }
        $result->free();
    } else {
        die('Query Error: '.mysqli_error($conexion));
    }
    $conexion->close();

    //Se hace la conversion de array a JSON
    echo json_encode($data, JSON_PRETTY_PRINT);
?>