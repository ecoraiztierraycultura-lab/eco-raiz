<?php include "inc/cabecera.php"; ?>

<div class="contenedor">
    <div class="tarjeta">
        <div class="area-logo">
            <div class="icono-logo">🌱</div>
            <h1 class="logo">Crear Cuenta</h1>
            <p class="eslogan">Únete a nuestra comunidad</p>
        </div>

        <h2 class="titulo-formulario">Registro</h2>
        <p class="subtitulo-formulario">Completa tus datos</p>

        <?php if(isset($_SESSION['error'])): ?>
            <div class="mensaje mensaje-error">
                <i class="fas fa-exclamation-circle"></i> <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST" class="formulario">
            <div class="grupo-formulario">
                <label class="etiqueta">Nombre completo</label>
                <input type="text" name="nombre" class="campo" placeholder="Ej. María Gómez" required>
            </div>

            <div class="grupo-formulario">
                <label class="etiqueta">Correo electrónico</label>
                <input type="email" name="email" class="campo" placeholder="correo@ejemplo.com" required>
            </div>

            <div class="grupo-formulario">
                <label class="etiqueta">Contraseña</label>
                <div class="contenedor-password">
                    <input type="password" name="password" id="password" class="campo" placeholder="••••••••" required>
                    <span class="ver-password" onclick="mostrarPassword('password')">
                        <i class="fa-regular fa-eye"></i>
                    </span>
                </div>
            </div>

            <div class="grupo-formulario">
                <label class="etiqueta">Confirmar contraseña</label>
                <div class="contenedor-password">
                    <input type="password" name="confirmar_password" id="confirmar_password" class="campo" placeholder="••••••••" required>
                    <span class="ver-password" onclick="mostrarPassword('confirmar_password')">
                        <i class="fa-regular fa-eye"></i>
                    </span>
                </div>
            </div>

            <div class="grupo-formulario">
                <label class="etiqueta">Teléfono</label>
                <input type="tel" name="telefono" class="campo" placeholder="300 123 4567">
            </div>

            <div class="grupo-formulario">
                <label class="etiqueta">Documento de identidad</label>
                <input type="text" name="documento" class="campo" placeholder="Ej. 123456789">
            </div>

            <button type="submit" name="registro_btn" class="btn-primario">Crear cuenta</button>
        </form>

        <p class="pie-formulario">
            ¿Ya tienes cuenta? <a class="enlace-registro" href="login.php">Iniciar sesión</a>
        </p>
    </div>
</div>

<script>
function mostrarPassword(campoId) {
    var x = document.getElementById(campoId);
    var icono = document.querySelector("#" + campoId).parentElement.querySelector(".ver-password i");
    if (x.type === "password") {
        x.type = "text";
        icono.classList.remove("fa-eye");
        icono.classList.add("fa-eye-slash");
    } else {
        x.type = "password";
        icono.classList.remove("fa-eye-slash");
        icono.classList.add("fa-eye");
    }
}
</script>

<?php 
if(isset($_POST['registro_btn'])){
    $nombre = mysqli_real_escape_string($db, $_POST['nombre']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
    $confirmar = mysqli_real_escape_string($db, $_POST['confirmar_password']);
    $telefono = mysqli_real_escape_string($db, $_POST['telefono']);
    $documento = mysqli_real_escape_string($db, $_POST['documento']);
    
    // Validaciones
    if($password != $confirmar){
        $_SESSION['error'] = "Las contraseñas no coinciden";
        header("Location: registro.php");
        exit();
    }
    
    if(strlen($password) < 4){
        $_SESSION['error'] = "La contraseña debe tener al menos 4 caracteres";
        header("Location: registro.php");
        exit();
    }
    
    // Verificar si el email ya existe
    $verificar = mysqli_query($db, "SELECT * FROM usuarios WHERE email='$email'");
    if(mysqli_num_rows($verificar) > 0){
        $_SESSION['error'] = "Este correo ya está registrado";
        header("Location: registro.php");
        exit();
    }
    
    $passwordEncriptada = sha1($password);
    
    $sql = "INSERT INTO usuarios (nombre, email, password, telefono, documento, rol, estado) 
            VALUES ('$nombre', '$email', '$passwordEncriptada', '$telefono', '$documento', 'comprador', 1)";
    
    if(mysqli_query($db, $sql)){
        $_SESSION['exito'] = "¡Registro exitoso! Ahora puedes iniciar sesión";
        header("Location: login.php");
        exit();
    } else {
        $_SESSION['error'] = "Error al registrar: " . mysqli_error($db);
        header("Location: registro.php");
        exit();
    }
}
?>

<?php include "inc/pie.php"; ?>