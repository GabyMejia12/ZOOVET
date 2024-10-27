<?php
@session_start();
include '../../models/conexion.php';
include '../../controllers/controllersFunciones.php';
$conn = conectar_db();
$sqlProp = "SELECT * FROM propietario";
$DataPropietarios = $conn->query($sqlProp);
?>


<div class="input-group mb-3">
  <span class="input-group-text"><b>Nombre Mascota</b></span>
  <input type="text" class="form-control" placeholder="nombres" name="nombre_mascota" id="nombre_mascota">
</div>
<div class="input-group mb-3">
  <span class="input-group-text"><b>Peso</b></span>
  <input type="text" class="form-control" placeholder="peso" name="peso" id="peso">
</div>
<div class="input-group mb-3">
  <span class="input-group-text"><b>Edad</b></span>
  <input type="text" class="form-control" placeholder="edad" name="edad" id="edad">
</div>
<div class="input-group mb-3">
  <span class="input-group-text"><b>Especie</b></span>
  <input type="text" class="form-control" placeholder="especie" name="especie" id="especie">
</div>

<div class="input-group mb-3">
  <span class="input-group-text"><b>Raza</b></span>
  <input type="text" class="form-control" placeholder="raza" name="raza" id="raza">
</div>
<div class="input-group mb-3">
  <span class="input-group-text"><b>Sexo</b></span>
  <select class="form-select" name="sexo" id="sexo" required>
    <option disabled selected>Seleccione Sexo</option>
    <option value="macho">Macho</option>
    <option value="hembra">Hembra</option>
  </select>
</div>


<div class="input-group mb-3">
  <span class="input-group-text"><b>Descripción</b></span>
  <textarea class="form-control" name="descripcion" placeholder="Descripción de la mascota" id="descripcion" ></textarea>
</div>
<div class="input-group mb-3">
      <label class="input-group-text" for="inputGroupSelect01"><b>Propietario</b></label>
      <select class="form-select" id="id_propietario" name="id_propietario">
        <option disabled selected>Seleccione Propietario</option>
        <?php foreach ($DataPropietarios as $result) : ?>
          <option value="<?php echo $result['id_propietario']; ?>"><?php echo $result['nombre']; ?></option>
        <?php endforeach ?>
      </select>
</div>

<div class="input-group mb-3">
  <span class="input-group-text" id="basic-addon1"><b>Codigo Mascota</b></span>
  <input type="text" class="form-control" placeholder="Código mascota" name="codigo_mascota" id="codigo_mascota" readonly>
</div>
<script>
  // Funciones JavaScript
  let codigosGenerados = new Set(); // Para almacenar los códigos generados

function generarUsuario() {
    var nombre = document.getElementById("nombre").value.toLowerCase(); // Convertir a minúsculas
    var apellido = document.getElementById("apellido").value.toLowerCase(); // Convertir a minúsculas
    var numerosAleatorios = Math.floor(1000 + Math.random() * 9000); // Genera un número entre 1000 y 9999

    if (nombre && apellido) {
        var primerLetraApellido = apellido.charAt(0);
        var usuarioGenerado = nombre + '.' + primerLetraApellido + numerosAleatorios;
        document.getElementById("usuario").value = usuarioGenerado;
    }
}

// Función para generar el código de la mascota
function generarCodigoMascota() {
    var nombreMascota = document.getElementById("nombre_mascota").value.toLowerCase(); // Nombre en minúsculas
    var especie = document.getElementById("especie").value.toLowerCase(); // Especie en minúsculas

    if (nombreMascota && especie) {
        let letraNombre = nombreMascota.charAt(0).toUpperCase(); // Primera letra del nombre en mayúscula
        let letraEspecie = especie.charAt(0).toUpperCase(); // Primera letra de la especie en mayúscula
        let letras = letraNombre + letraEspecie; // Concatenar las dos letras

        let numeros;

        // Generar 4 números aleatorios únicos
        do {
            numeros = Math.floor(1000 + Math.random() * 9000); // Genera un número entre 1000 y 9999
        } while (codigosGenerados.has(letras + numeros)); // Repetir hasta que sea único

        codigosGenerados.add(letras + numeros); // Agregar el código al conjunto
        var codigoMascotaGenerado = letras + numeros; // Código final
        document.getElementById("codigo_mascota").value = codigoMascotaGenerado; // Mostrar en el campo correspondiente
    }
}

// Agregar event listeners para generar el código automáticamente
document.getElementById("nombre_mascota").addEventListener("input", generarCodigoMascota);
document.getElementById("especie").addEventListener("input", generarCodigoMascota);


</script>


