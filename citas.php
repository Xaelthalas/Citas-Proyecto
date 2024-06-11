<?php
// Clase Citas para gestionar las consultas a la base de datos
class Citas {
    // Propiedades para la conexión a la base de datos
    private $host = "localhost";
    private $usuario = "root";
    private $contraseña = "";
    private $base_de_datos = "ReservasCitas"; // Reemplaza por el nombre de tu base de datos

    // Propiedad para la conexión a la base de datos
    private $conexion;

    // Método constructor para conectar a la base de datos al crear el objeto
    public function __construct() {
        // Intentamos conectar a la base de datos
        $this->conexion = new mysqli($this->host, $this->usuario, $this->contraseña, $this->base_de_datos);

        // Verificamos si hubo un error de conexión
        if ($this->conexion->connect_error) {
            die("Error de conexión a la base de datos: " . $this->conexion->connect_error);
        }
    }

    public function tieneCitaPendiente($id_usuario) {
        $consulta = "SELECT * FROM Citas WHERE DNI_usuario = '$id_usuario' AND Estado = 'Pendiente'";
        $resultado = $this->ejecuta_SQL($consulta);

        // Verificar si se obtuvo algún resultado
        return $resultado->num_rows > 0;
    }

    // Método para comprobar las credenciales de inicio de sesión
    public function comprobarCredenciales($username, $password) {
        // Consulta SQL para verificar las credenciales
        $consulta = "SELECT * FROM Usuarios WHERE DNI = '$username' AND Contraseña = '$password'";
        
        // Ejecutamos la consulta
        $resultado = $this->conexion->query($consulta);

        // Verificamos si se obtuvieron resultados
        if ($resultado && $resultado->num_rows > 0) {
            return true; // Credenciales correctas
        } else {
            return false; // Credenciales incorrectas
        }
    }

    // Método para ejecutar una consulta SQL
public function ejecuta_SQL($sql) {
    $resultado = $this->conexion->query($sql);

    // Si no se obtiene resultado, mostrar el error
    if (!$resultado) {
        // Mostrar el error de la consulta SQL
        echo "<h3>No se ha podido ejecutar la consulta: <pre>$sql</pre></h3><p><u>Errores:</u></p><pre>";
        echo $this->conexion->error; // Mostrar el mensaje de error de la base de datos
        die("</pre>");
    }

    return $resultado;
}

    public function mostrarTodasLasCitas() {
        // Consulta SQL para obtener todas las citas
        $consulta = "SELECT ID, Fecha, Hora, Estado, Motivo, DNI_usuario FROM Citas";
        
        // Ejecutamos la consulta
        $resultado = $this->ejecuta_SQL($consulta);
    
        // Verificamos si se obtuvieron resultados
        if ($resultado && $resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                echo "<tr>";
                
                // Formatear la fecha en el formato "día mes año"
                $fecha_formateada = date("d/m/Y", strtotime($fila['Fecha']));
                
                echo "<td>" . $fecha_formateada . "</td>";
                echo "<td>" . $fila['Hora'] . "</td>";
                echo "<td>" . $fila['Motivo'] . "</td>";
                echo "<td>" . $fila['Estado'] . "</td>";
    
                // Obtener el nombre del usuario si hay un DNI asociado
                $dni_usuario = $fila['DNI_usuario'];
                if (!empty($dni_usuario)) {
                    $nombre_usuario = $this->obtenerNombreUsuario($dni_usuario);
                    echo "<td>" . $nombre_usuario . "</td>";
                } else {
                    echo "<td>-</td>"; // Mostrar un guion si no hay DNI asociado
                }
                
                // Mostrar los enlaces "Eliminar" y "Modificar"
                echo "<td><a href='eliminar_cita.php?id=" . $fila['ID'] . "'>Eliminar</a>  </td>";
                    
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No hay citas disponibles.</td></tr>";
        }
    }
    public function insertarComentario($dni_usuario, $asunto, $cuerpo) {
        $stmt = $this->conexion->prepare("INSERT INTO Comentarios (DNI_usuario, Asunto, Cuerpo) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $dni_usuario, $asunto, $cuerpo);
        return $stmt->execute();
    }
    
    // Método para mostrar todos los comentarios
// Método para mostrar todos los comentarios
public function mostrarTodosLosComentarios() {
    // Consulta SQL para obtener todos los comentarios
    $consulta = "SELECT * FROM Comentarios";
    
    // Ejecutamos la consulta
    $resultado = $this->ejecuta_SQL($consulta);

    // Verificamos si se obtuvieron resultados
    if ($resultado && $resultado->num_rows > 0) {
        while ($fila = $resultado->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $fila['DNI_usuario'] . "</td>";
            // Asunto como un enlace que lleva a la página mostrar_comentario.php
            echo "<td><a href='mostrar_comentario.php?id=" . $fila['ID'] . "'>" . $fila['Asunto'] . "</a></td>";
    
            echo "<td><a href='eliminar_comentario.php?id=" . $fila['ID'] . "'>Eliminar</a></td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='4'>No hay comentarios disponibles.</td></tr>";
    }
}
// Método para obtener un comentario por su ID
public function obtenerComentarioPorID($comentario_id) {
    // Consulta SQL para obtener el comentario por su ID
    $consulta = "SELECT * FROM Comentarios WHERE ID = '$comentario_id'";
    
    // Ejecutamos la consulta
    $resultado = $this->ejecuta_SQL($consulta);

    // Verificamos si se obtuvieron resultados
    if ($resultado && $resultado->num_rows > 0) {
        // Devolvemos el comentario como un array asociativo
        return $resultado->fetch_assoc();
    } else {
        // Si no se encuentra el comentario, devolvemos NULL
        return NULL;
    }
}


    // Método para mostrar las citas del usuario
    public function mostrarCitas($id_usuario) {
        // Consulta SQL para obtener las citas del usuario
        $consulta = "SELECT ID, Fecha, Hora, Estado, Motivo FROM Citas WHERE DNI_usuario = '$id_usuario'";
        
        // Ejecutamos la consulta
        $resultado = $this->ejecuta_SQL($consulta);
    
        // Verificamos si se obtuvieron resultados
        if ($resultado && $resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                echo "<tr>";
                
                // Formatear la fecha en el formato "día mes año"
                $fecha_formateada = date("d/m/Y", strtotime($fila['Fecha']));
                
                echo "<td>" . $fecha_formateada . "</td>";
                echo "<td>" . $fila['Hora'] . "</td>";
                echo "<td>" . $fila['Motivo'] . "</td>";
                echo "<td>" . $fila['Estado'] . "</td>";
                
                // Verificar si el estado es "Finalizada"
                if ($fila['Estado'] !== 'Finalizada') {
                    // Mostrar los enlaces "Eliminar" y "Modificar"
                    echo "<td><a href='eliminar_cita.php?id=" . $fila['ID'] . "'>Eliminar</a> &nbsp; <a href='modificar_cita.php?id=" . $fila['ID'] . "'>Modificar</a></td>";
                } else {
                    // Si el estado es "Finalizada", mostrar un mensaje sin enlaces
                    echo "<td>Cita finalizada</td>";
                }
                
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No hay citas disponibles.</td></tr>";
        }
    }
    public function obtenerCorreoUsuarioPorComentario($comentario_id) {
        // Consulta SQL para obtener la dirección de correo electrónico del usuario asociado al comentario
        $consulta = "SELECT Usuarios.Email 
                     FROM Comentarios 
                     JOIN Usuarios ON Comentarios.DNI_usuario = Usuarios.DNI 
                     WHERE Comentarios.ID = '$comentario_id'";
                     
        // Ejecutamos la consulta
        $resultado = $this->ejecuta_SQL($consulta);
    
        // Verificamos si se obtuvieron resultados
        if ($resultado && $resultado->num_rows > 0) {
            $fila = $resultado->fetch_assoc();
            return $fila['Email'];
        } else {
            return ""; // Devuelve una cadena vacía si no se encuentra el correo electrónico del usuario
        }
    }
    
    
    // Método para obtener la dirección de correo electrónico del usuario por su ID
public function obtenerCorreoUsuario($id_usuario) {
    // Consulta SQL para obtener la dirección de correo electrónico del usuario por su ID
    $consulta = "SELECT Email FROM Usuarios WHERE DNI = '$id_usuario'";
    // Ejecutamos la consulta
    $resultado = $this->ejecuta_SQL($consulta);

    // Verificamos si se obtuvieron resultados
    if ($resultado && $resultado->num_rows > 0) {
        $fila = $resultado->fetch_assoc();
        
        return $fila['Email'];
    } else {
        return ""; // Devuelve una cadena vacía si no se encuentra el correo electrónico del usuario
    }
}


    // Método para dar de alta a un nuevo usuario
public function altaUsuario($dni, $nombre, $apellidos, $email, $contrasena, $rol) {
    // Validar el formato del email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "El email no tiene un formato válido.";
        return false; // El email no tiene un formato válido
    }

    // Validar el formato del DNI español (8 dígitos seguidos de una letra)
    if (!$this->validarDNI($dni)) {
        echo "El DNI no tiene un formato válido español.";
        return false; // El DNI no tiene un formato válido español
    }

    // Construimos la consulta SQL para insertar un nuevo usuario
    $sql = "INSERT INTO Usuarios (DNI, Nombre, Apellidos, Email, Contraseña, Rol) VALUES ('$dni', '$nombre', '$apellidos', '$email', '$contrasena', '$rol')";
    // Ejecutamos la consulta
    return $this->ejecuta_SQL($sql);
}

// Método para validar el DNI español
private function validarDNI($dni) {
    // Comprobamos que tenga 9 caracteres (8 dígitos y 1 letra)
    if (strlen($dni) != 9) {
        return false;
    }

    // Extraemos el número del DNI (los primeros 8 caracteres)
    $numeroDNI = substr($dni, 0, 8);

    // Extraemos la letra del DNI (el último caracter)
    $letraDNI = strtoupper(substr($dni, -1));

    // Calculamos la letra correspondiente al número del DNI
    $letrasValidas = 'TRWAGMYFPDXBNJZSQVHLCKE';
    $letraCalculada = $letrasValidas[$numeroDNI % 23];

    // Comparamos la letra calculada con la letra del DNI proporcionada
    if ($letraDNI != $letraCalculada) {
        return false;
    }

    return true;
}

    

    // Método para reservar una cita
    public function reservarCita($id_usuario, $fecha, $hora, $estado, $motivo) {
      
        
    
        // Verificar que el usuario exista
        $consulta_verificacion = "SELECT DNI FROM Usuarios WHERE DNI = '$id_usuario'";
        $resultado_verificacion = $this->ejecuta_SQL($consulta_verificacion);
    
        if ($resultado_verificacion && $resultado_verificacion->num_rows > 0) {
            // Si el usuario existe, inserta la cita
            $consulta_insertar = "INSERT INTO Citas (DNI_usuario, Fecha, Hora, Estado, Motivo) VALUES ('$id_usuario', '$fecha', '$hora', '$estado', '$motivo')";
            $resultado_insertar = $this->ejecuta_SQL($consulta_insertar);
    
            // Verificamos si la consulta se ejecutó correctamente
            if ($resultado_insertar) {
                // Cita reservada correctamente
                return true;
            } else {
                // Error al reservar la cita
                echo "Error al reservar la cita: " . $this->conexion->error;
                return false;
            }
        } else {
            // Si el usuario no existe, lanza un error
            echo "Error: El usuario con DNI $id_usuario no existe.";
            return false;
        }
    }
    

    public function eliminarComentario($id_comentario) {
        // Consulta SQL para eliminar el comentario con el ID especificado
        $consulta = "DELETE FROM Comentarios WHERE ID = '$id_comentario'";
        // Ejecutamos la consulta
        $resultado = $this->conexion->query($consulta);

        // Verificamos si la consulta se ejecutó correctamente
        if ($resultado) {
            // Comentario eliminado correctamente
            return true;
        } else {
            // Error al eliminar el comentario
            echo "Error al eliminar el comentario: " . $this->conexion->error;
            return false;
        }
    }
    // Método para eliminar una cita
    public function eliminarCita($id_cita) {
        // Consulta SQL para eliminar la cita con el ID especificado
        $consulta = "DELETE FROM Citas WHERE ID = '$id_cita'";
        // Ejecutamos la consulta
        $resultado = $this->ejecuta_SQL($consulta);
    
        // Verificamos si la consulta se ejecutó correctamente
        if ($resultado) {
            // Cita eliminada correctamente
            return true;
        } else {
            // Error al eliminar la cita
            echo "Error al eliminar la cita: " . $this->conexion->error;
            return false;
        }
    }

    // Método para obtener el nombre del usuario por su ID
  // Método para obtener el nombre del usuario por su ID
public function obtenerNombreUsuario($id_usuario) {
    // Consulta SQL para obtener el nombre del usuario por su ID
    $consulta = "SELECT Nombre FROM Usuarios WHERE DNI = '$id_usuario'";
    // Ejecutamos la consulta
    $resultado = $this->ejecuta_SQL($consulta);

    // Verificamos si se obtuvieron resultados
    if ($resultado && $resultado->num_rows > 0) {
        $fila = $resultado->fetch_assoc();
        
        return $fila['Nombre'];
    } else {
        // Manejar el error
        echo "Error al obtener el nombre del usuario: " . $this->conexion->error;
        return ""; // Devuelve una cadena vacía si no se encuentra el usuario
    }
}


    // Método para verificar y actualizar el estado de las citas pendientes
    public function actualizarEstadoCitas() {
        // Obtener la fecha y hora actual
        $fecha_actual = date("Y-m-d");
        $hora_actual = date("H:i");

        // Consulta SQL para seleccionar todas las citas pendientes
        $consulta = "SELECT ID, Fecha, Hora FROM Citas WHERE Estado = 'Pendiente'";
        // Ejecutar la consulta
        $resultado = $this->ejecuta_SQL($consulta);

        // Verificar cada cita pendiente
        while ($fila = $resultado->fetch_assoc()) {
            $id_cita = $fila['ID'];
            $fecha_cita = $fila['Fecha'];
            $hora_cita = $fila['Hora'];

            // Verificar si la fecha y hora de la cita han pasado
            if ($fecha_cita < $fecha_actual || ($fecha_cita == $fecha_actual && $hora_cita < $hora_actual)) {
                // Actualizar el estado de la cita a "Finalizada"
                $consulta_actualizar = "UPDATE Citas SET Estado = 'Finalizada' WHERE ID = '$id_cita'";
                $this->ejecuta_SQL($consulta_actualizar);
            }
        }
    }

    // Método para verificar la disponibilidad de una cita para una nueva fecha y hora
    public function verificarDisponibilidadCita($fecha, $hora) {
        // Consulta SQL para verificar si existe alguna cita para la nueva fecha y hora
        $consulta = "SELECT * FROM Citas WHERE Fecha = '$fecha' AND Hora = '$hora'";
        // Ejecutamos la consulta
        $resultado = $this->ejecuta_SQL($consulta);

        // Si se obtienen resultados, significa que la cita ya existe para cualquier usuario
        if ($resultado->num_rows > 0) {
            return false; // La cita no está disponible
        } else {
            return true; // La cita está disponible
        }
    }
    public function modificarCita($cita_id, $nueva_fecha, $nueva_hora, $nuevo_motivo) {
// Consulta SQL para actualizar la fecha y hora de la cita
$consulta = "UPDATE Citas SET Fecha = '$nueva_fecha', Hora = '$nueva_hora' WHERE ID = '$cita_id'";
// Ejecutamos la consulta
$resultado = $this->ejecuta_SQL($consulta);

// Verificamos si la consulta se ejecutó correctamente
if ($resultado) {
    return true; // La cita se ha modificado correctamente
} else {
    return false; // Error al modificar la cita
}
}

// Método para obtener todas las citas reservadas
public function obtenerCitasReservadas() {
    // Consulta SQL para obtener todas las citas reservadas
    $consulta = "SELECT Fecha, Hora FROM Citas";
    // Ejecutamos la consulta
    $resultado = $this->ejecuta_SQL($consulta);

    $citas = [];
    // Recorremos el resultado y lo añadimos al array de citas
    if ($resultado->num_rows > 0) {
        while ($fila = $resultado->fetch_assoc()) {
            $citas[] = $fila;
        }
    }

    return $citas;
}
public function obtenerHorasOcupadas($fecha) {
    // Consulta SQL para obtener las citas ocupadas en un día específico
    $consulta = "SELECT Hora FROM Citas WHERE Fecha = '$fecha'";
    
    // Ejecutar la consulta
    $resultado = $this->ejecuta_SQL($consulta);

    // Arreglo para almacenar las horas ocupadas
    $horas_ocupadas = array();

    // Verificar si se obtuvieron resultados
    if ($resultado->num_rows > 0) {
        while ($fila = $resultado->fetch_assoc()) {
            // Agregar la hora al arreglo de horas ocupadas
            $horas_ocupadas[] = $fila['Hora'];
        }
    }

    // Devolver el arreglo de horas ocupadas
    return $horas_ocupadas;
}

public function eliminarUsuario($dni_usuario) {
    // Consulta SQL para obtener todas las citas asociadas al usuario
    $consulta_citas = "SELECT ID FROM Citas WHERE DNI_usuario = '$dni_usuario'";
    
    // Ejecutar la consulta para obtener las citas
    $resultado_citas = $this->ejecuta_SQL($consulta_citas);

    // Verificar si se obtuvieron citas asociadas al usuario
    if ($resultado_citas && $resultado_citas->num_rows > 0) {
        // Iterar sobre cada cita y eliminarla
        while ($fila_cita = $resultado_citas->fetch_assoc()) {
            $id_cita = $fila_cita['ID'];
            // Consulta SQL para eliminar la cita actual
            $consulta_eliminar_cita = "DELETE FROM Citas WHERE ID = '$id_cita'";
            // Ejecutar la consulta para eliminar la cita actual
            $resultado_eliminar_cita = $this->ejecuta_SQL($consulta_eliminar_cita);
            // Verificar si se eliminó la cita actual correctamente
            if (!$resultado_eliminar_cita) {
                echo "Error al eliminar la cita con ID: $id_cita";
                return; // Terminar la función si hay un error al eliminar una cita
            }
        }
    }

    // Consulta SQL para obtener todos los comentarios asociados al usuario
    $consulta_comentarios = "SELECT ID FROM Comentarios WHERE DNI_usuario = '$dni_usuario'";
    
    // Ejecutar la consulta para obtener los comentarios
    $resultado_comentarios = $this->ejecuta_SQL($consulta_comentarios);

    // Verificar si se obtuvieron comentarios asociados al usuario
    if ($resultado_comentarios && $resultado_comentarios->num_rows > 0) {
        // Iterar sobre cada comentario y eliminarlo
        while ($fila_comentario = $resultado_comentarios->fetch_assoc()) {
            $id_comentario = $fila_comentario['ID'];
            // Consulta SQL para eliminar el comentario actual
            $consulta_eliminar_comentario = "DELETE FROM Comentarios WHERE ID = '$id_comentario'";
            // Ejecutar la consulta para eliminar el comentario actual
            $resultado_eliminar_comentario = $this->ejecuta_SQL($consulta_eliminar_comentario);
            // Verificar si se eliminó el comentario actual correctamente
            if (!$resultado_eliminar_comentario) {
                echo "Error al eliminar el comentario con ID: $id_comentario";
                return; // Terminar la función si hay un error al eliminar un comentario
            }
        }
    }

    // Consulta SQL para eliminar el usuario
    $consulta_eliminar_usuario = "DELETE FROM Usuarios WHERE DNI = '$dni_usuario'";
    $resultado_eliminar_usuario = $this->ejecuta_SQL($consulta_eliminar_usuario);

    // Verificar si se eliminó el usuario correctamente
    if (!$resultado_eliminar_usuario) {
        echo "Error al eliminar el usuario con DNI: $dni_usuario";
        return; // Terminar la función si hay un error al eliminar el usuario
    }

    echo "Usuario y todos sus datos asociados eliminados con éxito.";
}




// Método para mostrar los usuarios (excluyendo al administrador)
public function mostrarUsuarios() {
    // Consulta SQL para obtener todos los usuarios excepto el administrador
    $consulta = "SELECT * FROM Usuarios WHERE Rol != 'admin'";
    
    // Ejecutamos la consulta
    $resultado = $this->ejecuta_SQL($consulta);

    // Verificamos si hay usuarios para mostrar
    if ($resultado && $resultado->num_rows > 0) {
        while ($fila = $resultado->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $fila['DNI'] . "</td>";
            echo "<td>" . $fila['Nombre'] . " " . $fila['Apellidos'] . "</td>";
            echo "<td>" . $fila['Email'] . "</td>"; // Agregamos el campo Email
            echo "<td><a href='eliminar_usuario.php?dni=" . $fila['DNI'] . "'>Eliminar</a></td>"; // Corregimos el parámetro a 'dni'
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='4'>No hay usuarios registrados</td></tr>"; // Ajustamos colspan a 4 para incluir el campo Email y el enlace de eliminar
    }
}

public function esAdmin($id_usuario) {
    // Consulta SQL para verificar si el usuario es administrador
    $consulta = "SELECT Rol FROM Usuarios WHERE DNI = '$id_usuario' AND Rol = 'admin'";
    
    // Ejecutamos la consulta
    $resultado = $this->conexion->query($consulta);

    // Verificamos si se obtuvieron resultados
    if ($resultado && $resultado->num_rows > 0) {
        return true; // El usuario es administrador
    } else {
        return false; // El usuario no es administrador
    }
}


// Método para obtener todas las fechas y horas ocupadas
public function obtenerFechasHorasOcupadas() {
    // Consulta SQL para obtener todas las citas reservadas
    $consulta = "SELECT Fecha, Hora FROM Citas";
    // Ejecutamos la consulta
    $resultado = $this->ejecuta_SQL($consulta);

    $citas = [];
    // Recorremos el resultado y lo añadimos al array de citas
    if ($resultado->num_rows > 0) {
        while ($fila = $resultado->fetch_assoc()) {
            $citas[] = $fila;
        }
    }

    return $citas;
}

// Método para obtener el rol de un usuario por su ID
public function obtenerRolUsuario($id_usuario) {
    // Consulta SQL para obtener el rol del usuario por su ID
    $consulta = "SELECT Rol FROM Usuarios WHERE DNI = '$id_usuario'";
    // Ejecutamos la consulta
    $resultado = $this->ejecuta_SQL($consulta);

    // Verificamos si se obtuvieron resultados
    if ($resultado && $resultado->num_rows > 0) {
        $fila = $resultado->fetch_assoc();
        
        return $fila['Rol'];
    } else {
        return ""; // Devuelve una cadena vacía si no se encuentra el usuario
    }
}



}

// Aquí finaliza la clase Citas

?>