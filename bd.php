<?php

//Función para conectar a la base de datos
    function conectarBD() {
        $mysqli = new mysqli("database", "user1", "contraseña", "SIBW");
        if ($mysqli->connect_errno) {
            echo ("Fallo al conectar: " . $mysqli->connect_error);
        }
        return $mysqli;
    }

  
    //Función para obtener los datos de la actividad
    function getActividad($idEv,$mysqli) {

        $res = $mysqli->query("SELECT nombreAct, lugarAct, costeAct, fechaAct, descripcionAct, publicada FROM Actividades WHERE idAct=" . $idEv);
        
        $evento = array('nombreAct' => 'XXX', 'lugarAct' => 'XXX', 'costeAct' => 'XXX','fechaAct' => 'XXX','descripcionAct' => 'XXX');
        
        if ($res->num_rows > 0) {
        $row = $res->fetch_assoc();
        
        $evento = array('nombreAct' => $row['nombreAct'], 'lugarAct' => $row['lugarAct'], 'costeAct' => $row['costeAct'],'fechaAct' => $row['fechaAct'],'descripcionAct' => $row['descripcionAct'], 'publicada' => $row['publicada']);
        }
        
        return $evento;
  }

  //Función para obtener los comentarios de la actividad
  function getComentarios($idEv, $mysqli) {
    
    $res = $mysqli->query("SELECT c.idCom,c.idUser, u.nombreUser, c.textoCom, c.fechaCom FROM comentarios c JOIN Usuarios u ON c.idUser = u.idUser WHERE c.idAct=" . $idEv);
    
    $comentarios = array();
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $comentario = array(
                'idCom' => $row['idCom'],
                'nombreUser' => $row['nombreUser'],
                'textoCom' => $row['textoCom'],
                'fechaCom' => $row['fechaCom']
            );
            $comentarios[] = $comentario;
        }
    }
    
    return $comentarios;
}

//Función para obtener las palabras prohibidas
function getPalabrasProhibidas($mysqli) {
    $res = $mysqli->query("SELECT palabra FROM PalabrasProhibidas");
    
    $palabrasProhibidas = array();
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $palabrasProhibidas[] = $row['palabra'];
        }
    }
    
    return $palabrasProhibidas;
}

//Función para obtener las imágenes de la actividad
function getImagenes($idEv, $mysqli) {
    $res = $mysqli->query("SELECT path FROM Imagenes WHERE idAct=" . $idEv);
    
    $imagenes = array();
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $imagenes[] = $row['path'];
        }
    }
    
    return $imagenes;
}

//Función para obtener los pies de foto de las imágenes de la actividad
function getPieImagenes($idEv, $mysqli) {
    $res = $mysqli->query("SELECT pieFoto FROM Imagenes WHERE idAct=" . $idEv);
    
    $pies = array();
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $pies[] = $row['pieFoto'];
        }
    }
    
    return $pies;
}

//Función para obtener las imágenes de portada
function getImagenesPortada($mysqli) {
    $res = $mysqli->query("SELECT `path` FROM Imagenes WHERE `portada`=1 ORDER BY idAct");
   
    
    $imagenes = array();
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $imagenes[] = $row['path'];
        }
    }
    
    return $imagenes;
}

//Función para obtener los iconos
function getIconos($mysqli) {
    $res = $mysqli->query("SELECT `pathIco` FROM Iconos");
    
    $icono = array();
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $icono[] = $row['pathIco'];
        }
    }
    
    return $icono;
}

//Funcion para subir los comentarios
function insertarComentarios($email,$texto,$fecha, $idEv, $mysqli) {
   
    $result = $mysqli->query("SELECT idUser FROM Usuarios WHERE correoUser = '$email'");


    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $idUser = $row['idUser'];

        $fechaFormateada = date('Y-m-d', strtotime($fecha));

        $mysqli->query("INSERT INTO comentarios (idUser, idAct, textoCom, fechaCom) VALUES ('$idUser', '$idEv', '$texto', '$fechaFormateada')");

        if ($mysqli->affected_rows == 1) {
            echo "Comentario insertado correctamente.";
        } else {
            echo "Error al insertar el comentario.";
        }
    } else {
        echo "El usuario no existe.";
    }
    
}

function checkLogin($nick, $pass, $mysqli){
    $res = $mysqli->query("SELECT * FROM Usuarios WHERE nombreUser='$nick'");

    if ($res->num_rows == 1) {
        $row = $res->fetch_assoc();
        return password_verify($pass, $row['passUser']);
    }
}

function getUser($nick, $mysqli){
    $res = $mysqli->query("SELECT * FROM Usuarios WHERE nombreUser='$nick'");
    
    if ($res->num_rows == 1) {
        $row = $res->fetch_assoc();
        $datos = array(
            'idUser' => $row['idUser'], 
            'nombreUser' => $row['nombreUser'],
            'correoUser' => $row['correoUser'],
            'tipoUser' => $row['tipoUser']
        );
        return $datos;
    }

    
}

function logearse($nick, $pass,$correo, $mysqli){
    $contraseña = password_hash($pass, PASSWORD_DEFAULT);
    $res = $mysqli->query("SELECT * FROM Usuarios WHERE nombreUser='$nick'");
    
   
    
    if ($res->num_rows == 0) {
        $mysqli->query("INSERT INTO Usuarios (correoUser, nombreUser, passUser,tipoUser) VALUES ('$correo', '$nick', '$contraseña',0)");

       


    }else{
        echo "El usuario ya existe";
    }


    
}

function obtenerComentario($idCom, $mysqli) {

    $res = $mysqli->query("SELECT * FROM comentarios WHERE idCom= '$idCom'");
    if ($res->num_rows == 1) {
        $row = $res->fetch_assoc();
        $comentario = array(
            'idCom' => $row['idCom'],
            'idUser' => $row['idUser'],
            'idAct' => $row['idAct'],
            'textoCom' => $row['textoCom'],
            'fechaCom' => $row['fechaCom']
        );
        return $comentario;
    }
    
}

function actualiazrComentario($idCom, $textoCom, $mysqli) {

    $mysqli->query("UPDATE comentarios SET textoCom='$textoCom' WHERE idCom='$idCom'");
    
    
}

function eliminarComentario($idCom, $mysqli) {
    $mysqli->query("DELETE FROM comentarios WHERE idCom='$idCom'");

    
}
function getUserID($id, $mysqli){
    $res = $mysqli->query("SELECT * FROM Usuarios WHERE idUser='$id'");
    
    if ($res->num_rows == 1) {
        $row = $res->fetch_assoc();
        $datos = array(
            'nombreUser' => $row['nombreUser'],
            'correoUser' => $row['correoUser'],
            'tipoUser' => $row['tipoUser']
        );
        return $datos;
    }

    
}

function getTodosComentarios($mysqli) {
    $res = $mysqli->query("SELECT * FROM comentarios");
    
    
    $comentarios = array();
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $user = getUserID($row['idUser'], $mysqli);

            $nombreUser = $user['nombreUser'];

            $comentario = array(
                'idCom' => $row['idCom'],
                'idAct' => $row['idAct'],
                'nombreUser' => $nombreUser,
                'textoCom' => $row['textoCom'],
                'fechaCom' => $row['fechaCom']
            );
            $comentarios[] = $comentario;
        }
    }
    
    return $comentarios;
}

function getActividades($mysqli) {
    $res = $mysqli->query("SELECT * FROM Actividades");
    
    $actividades = array();
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $idAct = $row['idAct'];
            $imagenes = getImagenes($idAct, $mysqli);
            $imgAct = null;
            if (!empty($imagenes)) {
                $imgAct = $imagenes[0];
            }
            
            $actividad = array(
                'idAct' => $idAct,
                'imagen' => $imgAct,
                'nombreAct' => $row['nombreAct'],
                'descripcionAct' => $row['descripcionAct'],
                'publicada' => $row['publicada']

            );
            $actividades[] = $actividad;
        }
    }
    
    return $actividades;
}

function actualiazrActividad($idAct,$nombre, $lugarAct, $costeAct, $fechaAct, $descripcionAct, $publicada, $mysqli){
    $mysqli->query("UPDATE Actividades SET nombreAct='$nombre', lugarAct='$lugarAct', costeAct='$costeAct', fechaAct='$fechaAct', descripcionAct='$descripcionAct', publicada ='$publicada' WHERE idAct='$idAct'");
}

function eliminarActividad($idAct, $mysqli) {
    $mysqli->query("DELETE FROM comentarios WHERE idAct='$idAct'");
    $mysqli->query("DELETE FROM Imagenes WHERE idAct='$idAct'");
    $mysqli->query("DELETE FROM Actividades WHERE idAct='$idAct'");
    
}

function añadirActividad($nombre, $lugarAct, $costeAct, $fechaAct, $descripcionAct, $publicada, $mysqli){
    $fechaFormateada = date('Y-m-d', strtotime($fechaAct));
    $mysqli->query("INSERT INTO Actividades (nombreAct, lugarAct, costeAct, fechaAct, descripcionAct, publicada) VALUES ('$nombre', '$lugarAct', '$costeAct', '$fechaFormateada', '$descripcionAct', '$publicada')");
}

function añadirImagen($nombre, $imagen, $pieImagen, $mysqli){
    $res = $mysqli->query("SELECT idAct FROM Actividades WHERE nombreAct='$nombre'");
    if ($res->num_rows == 1) {
        $row = $res->fetch_assoc();
        $idAct = $row['idAct'];
        $mysqli->query("INSERT INTO Imagenes (idAct, path, portada, pieFoto) VALUES ('$idAct', '$imagen','1','$pieImagen')");
    }
}

function getUsers($mysqli){
    $res = $mysqli->query("SELECT * FROM Usuarios");
    
    $users = array();
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $user = array(
                'idUser' => $row['idUser'],
                'nombreUser' => $row['nombreUser'],
                'correoUser' => $row['correoUser'],
                'tipoUser' => $row['tipoUser']
            );
            $users[] = $user;
        }
    }
    
    return $users;
}

function actualizarUser($idUser,$tipoUser,$mysqli){
    $mysqli->query("UPDATE Usuarios SET tipoUser='$tipoUser' WHERE idUser='$idUser'");
    

}

function editarUser($idUser,$nombreUser,$correoUser,$mysqli){
    $mysqli->query("UPDATE Usuarios SET nombreUser='$nombreUser', correoUser='$correoUser' WHERE idUser='$idUser'");
}


function buscarActividades($nombre, $mysqli, $tipouser) {
    if ($tipouser == 3 || $tipouser == 4) {
        $query = "SELECT idAct, nombreAct , publicada FROM Actividades WHERE nombreAct LIKE ?";
    } else {
        $query = "SELECT idAct, nombreAct FROM Actividades WHERE nombreAct LIKE ? AND publicada = True";
    }
    
    $stmt = $mysqli->prepare($query);
    $searchTerm = "%" . $nombre . "%";
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $actividades = array();
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $actividades[] = $row;
        }
    }
    
    return $actividades;
}


?>