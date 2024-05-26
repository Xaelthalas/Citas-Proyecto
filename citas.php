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
        $consulta = "SELECT * FROM Citas WHERE DNI_usuario = $id_usuario AND Estado = 'Pendiente'";
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
            echo "<h3>No se ha podido ejecutar la consulta: <pre>$sql</pre></h3><p><u>Errores:</u>:</h3><pre>";
            die("</pre>");
        }

        return $resultado;
    }

    // Método para mostrar las citas del usuario
    public function mostrarCitas($id_usuario) {
        // Consulta SQL para obtener las citas del usuario
        $consulta = "SELECT ID, Fecha, Hora, Estado, Motivo FROM Citas WHERE DNI_usuario = $id_usuario";
        
        // Ejecutamos la consulta
        $resultado = $this->ejecuta_SQL($consulta);
    
        // Verificamos si se obtuvieron resultados
        if ($resultado->num_rows > 0) {
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
            echo "<tr><td colspan='6'>No hay citas disponibles.</td></tr>";
        }
    }
    

    // Método para dar de alta a un nuevo usuario
    public function altaUsuario($dni, $nombre, $apellidos, $contrasena) {
        // Construimos la consulta SQL para insertar un nuevo usuario
        $sql = "INSERT INTO Usuarios (DNI, Nombre, Apellidos, Contraseña) VALUES ('$dni', '$nombre', '$apellidos', '$contrasena')";
        // Ejecutamos la consulta
        return $this->ejecuta_SQL($sql);
    }

    // Método para reservar una cita
    public function reservarCita($id_usuario, $fecha, $hora, $estado, $motivo) {
        // Consulta SQL para insertar una nueva cita
        $consulta = "INSERT INTO Citas (DNI_usuario, Fecha, Hora, Estado, Motivo) VALUES ('$id_usuario', '$fecha', '$hora', '$estado', '$motivo')";
        // Ejecutamos la consulta
        $resultado = $this->ejecuta_SQL($consulta);
    
        // Verificamos si la consulta se ejecutó correctamente
        if ($resultado) {
            // Cita reservada correctamente
            return true;
        } else {
            // Error al reservar la cita
            echo "Error al reservar la cita: " . $this->conexion->error;
            return false;
        }
    }

    // Método para eliminar una cita
    public function eliminarCita($id_cita) {
        // Consulta SQL para eliminar la cita con el ID especificado
        $consulta = "DELETE FROM Citas WHERE ID = $id_cita";
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
    public function obtenerNombreUsuario($id_usuario) {
        // Consulta SQL para obtener el nombre del usuario por su ID
        $consulta = "SELECT Nombre FROM Usuarios WHERE DNI = $id_usuario";
        // Ejecutamos la consulta
        $resultado = $this->ejecuta_SQL($consulta);

        // Verificamos si se obtuvieron resultados
        if ($resultado && $resultado->num_rows > 0) {
            $fila = $resultado->fetch_assoc();
            
            return $fila['Nombre'];
        } else {
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
                $consulta_actualizar = "UPDATE Citas SET Estado = 'Finalizada' WHERE ID = $id_cita";
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
$consulta = "UPDATE Citas SET Fecha = '$nueva_fecha', Hora = '$nueva_hora' WHERE ID = $cita_id";
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


}

// Aquí finaliza la clase Citas

?>
