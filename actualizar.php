<?php
    // Incluimos el archivo citas.php para poder utilizar la clase Citas
    require "citas.php";

            $citas = new Citas();
            $citas->actualizarEstadoCitas();
          
    ?>