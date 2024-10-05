
<?php
  @session_start();
  include '../../models/conexion.php';
  include '../../controllers/controllersFunciones.php';
  $conn = conectar_db();
  $id_usuario = $_GET['id_usuario'];
  $sql = "SELECT * FROM usuarios WHERE id_usuario = '$id_usuario'";
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
  $nombre = $row['nombre'];
  $apellido = $row['apellido'];
  $usuario = $row['usuario'];  
  $estado = $row['estado'];
  $vestado = ($estado == 1)? 'Activo':'Inactivo';
  $tipo = $row['tipo'];
  $vtipo = ($tipo == 1)? 'Administrador':'Operador';  
?>
<input type="hidden" id="id_usuario" name="id_usuario" value="<?php echo $id_usuario;?>">
<div class="form-group">
    <label>Nombre</label>
    <input type="text" class="form-control" name="nombre" id="nombre" value="<?php echo $nombre;?>"required>
</div>
<div class="form-group">
    <label>Apellido</label>
    <input type="text" class="form-control" name="apellido" id="apellido" required value="<?php echo $apellido;?>">
</div>
                    <div class="form-group">
                        <label>Usuario</label>
                        <input type="text" class="form-control" name="usuario" id="usuario"required value="<?php echo $usuario;?>" readonly>
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
  <label class="input-group-text" for="inputGroupSelect01"><b>Tipo</b></label>
  <select class="form-select" name="tipo" id="tipo">
    <option value="<?php echo $tipo;?>" selected><?php echo $vtipo;?></option>
    <?php if($tipo == 1):?>
        <option value="2">Veterinario/Asistente</option>
    <?php else:?>
    <option value="1">Administrador</option>
    <?php endif?>
  </select>
</div>
<div class="input-group mb-3">
  <label class="input-group-text" for="inputGroupSelect01"><b>Estado</b></label>
  <select class="form-select" name="estado" id="estado">
    <option value="<?php echo $estado;?>" selected><?php echo $vestado?></option>
    <?php if($estado == 1):?>
      <option value="2">Inactivo</option>
    <?php else:?>
      <option value="1">Activo</option>
    <?php endif?>
  </select>
</div>
        
</form>