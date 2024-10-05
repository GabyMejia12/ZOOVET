<div class="form-group">
    <label>Nombre</label>
    <input type="text" class="form-control" name="nombre" id="nombre" required oninput="generarUsuario()">
</div>
<div class="form-group">
    <label>Apellido</label>
    <input type="text" class="form-control" name="apellido" id="apellido" required oninput="generarUsuario()">
</div>
<div class="form-group">
    <label>Usuario</label>
    <input type="text" class="form-control" name="usuario" id="usuario" required readonly>
</div>
<div class="form-group">
    <label>Contraseña</label>
    <div class="input-group">
        <input type="password" class="form-control" placeholder="Ingrese Contraseña" name="password" id="password" minlength="6" required>
        <div class="input-group-append">
            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                <i class="fa fa-eye"></i>
            </button>
        </div>
    </div>
    <small id="mensaje-password" style="color:red;"></small>
</div>
<div class="form-group">
    <label>Confirmar contraseña</label>
    <div class="input-group">
        <input type="password" class="form-control" placeholder="Confirmar Contraseña" name="confirm_password" id="confirm_password" minlength="6" required>
        <div class="input-group-append">
            <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                <i class="fa fa-eye"></i>
            </button>
        </div>
    </div>
    <small id="mensaje-confirmacion" style="color:red;"></small>
</div>
<div class="input-group mb-3">                        
    <label class="input-group-text" for="inputGroupSelect01">Tipo</label>
    <select class="form-select" name="tipo" id="tipo">
        <option disabled selected>Tipo</option>
        <option value="1">Administrador</option>
        <option value="2">Veterinario/Asistente</option>
    </select>
</div>
<div class="input-group mb-3">
    <label class="input-group-text" for="inputGroupSelect01"><b>Estado</b></label>
    <select class="form-select" name="estado" id="estado">
        <option value="1" selected>Activo</option>
        <option value="2">Inactivo</option>
    </select>
</div>

<!--Validar que la contraseña contenga los caracteres y longitud solicitados-->
<script>
document.getElementById("clave").addEventListener("input", function() {
    var password = document.getElementById("clave").value;
    var mensaje = document.getElementById("mensaje-password");
    var pattern = /^(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{6,}$/;

    if (!pattern.test(password)) {
        mensaje.innerHTML = "La contraseña debe contener al menos 6 caracteres, una mayúscula y un número.";
    } else {
        mensaje.innerHTML = "";
    }
});
</script>

<!-- Agregar función de ocultar y mostrar contraseña-->
<script>
document.getElementById("togglePassword").addEventListener("click", function() {
    var passwordInput = document.getElementById("password");
    var icon = document.querySelector("#togglePassword i");

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    } else {
        passwordInput.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    }
});

document.getElementById("toggleConfirmPassword").addEventListener("click", function() {
    var confirmPasswordInput = document.getElementById("confirm_password");
    var icon = this.querySelector("i");

    if (confirmPasswordInput.type === "password") {
        confirmPasswordInput.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    } else {
        confirmPasswordInput.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    }
});
</script>

<!-- Comparar contraseñas -->
<script>
document.getElementById("confirm_password").addEventListener("input", function() {
    var passwordInput = document.getElementById("password");
    var confirmPasswordInput = document.getElementById("confirm_password");
    var messageBox = document.getElementById("mensaje-confirmacion");

    var password = passwordInput.value;
    var confirmPassword = confirmPasswordInput.value;

    if (password === confirmPassword) {
        messageBox.innerHTML = "Las contraseñas coinciden";
        messageBox.style.color = "green";
    } else {
        messageBox.innerHTML = "Las contraseñas no coinciden";
        messageBox.style.color = "red";
    }
});
</script>

<!-- Función para generar el usuario -->
<script>
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
</script>
