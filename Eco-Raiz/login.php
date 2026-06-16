<?php include "inc/cabecera.php"; ?>

<div class="contenedor">
    <div class="tarjeta">
        <div class="area-logo">
            <div class="icono-logo">🌱</div>
            <h1 class="logo">Eco Raíz</h1>
            <p class="eslogan">Conectamos campo y ciudad</p>
        </div>

        <h2 class="titulo-formulario">Iniciar sesión</h2>
        <p class="subtitulo-formulario">Ingresa tu correo y contraseña</p>

        <?php if(isset($_SESSION['error'])): ?>
            <div class="mensaje mensaje-error">
                <i class="fas fa-exclamation-circle"></i> <?php 
                echo $_SESSION['error']; 
                unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <?php if(isset($_SESSION['exito'])): ?>
            <div class="mensaje">
                <i class="fas fa-check-circle"></i> <?php 
                echo $_SESSION['exito']; 
                unset($_SESSION['exito']); ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST" class="formulario">
            <div class="grupo-formulario">
                <label class="etiqueta">Correo electrónico</label>
                <input type="email" name="email" class="campo" 
                       placeholder="campesino@ecoraiz.com" required 
                       value="<?php echo isset($_COOKIE['recordar_email']) ? $_COOKIE['recordar_email'] : ''; ?>">
            </div>

            <div class="grupo-formulario">
                <label class="etiqueta">Contraseña</label>
                <div class="contenedor-password">
                    <input type="password" name="password" id="password" class="campo" placeholder="••••••••" required>
                    <span class="ver-password" onclick="mostrarPassword()">
                        <i class="fa-regular fa-eye"></i>
                    </span>
                </div>
            </div>

            <div class="opciones">
                <label class="label-checkbox">
                    <input type="checkbox" name="recordarme" id="recordarme" 
                           <?php echo isset($_COOKIE['recordar_email']) ? 'checked' : ''; ?>> Recordarme
                </label>
                <a class="enlace-recuperar" href="recuperar.php">¿Olvidaste tu contraseña?</a>
            </div>

            <button type="submit" name="login_btn" class="btn-primario">Iniciar sesión</button>
        </form>

        <p class="pie-formulario">
            ¿No tienes cuenta? <a class="enlace-registro" href="registro.php">Crear cuenta</a>
        </p>
    </div>
</div>

<script>
function mostrarPassword() {
    var x = document.getElementById("password");
    var icono = document.querySelector(".ver-password i");
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
// Procesar login
if(isset($_POST['login_btn'])){
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
    $hashedPass = sha1($password);
    $recordarme = isset($_POST['recordarme']) ? true : false;
    
    // Buscar usuario
    $sql = "SELECT * FROM usuarios WHERE email='$email' AND password='$hashedPass' AND estado=1";
    $resultado = mysqli_query($db, $sql);
    
    if(mysqli_num_rows($resultado) == 1){
        $usuario = mysqli_fetch_assoc($resultado);
        
        // Guardar sesión
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nombre'] = $usuario['nombre'];
        $_SESSION['usuario_email'] = $usuario['email'];
        $_SESSION['usuario_rol'] = $usuario['rol'];
        
        // Guardar cookie si recordarme está marcado
        if($recordarme){
            setcookie('recordar_email', $email, time() + (86400 * 30), "/");
        } else {
            setcookie('recordar_email', '', time() - 3600, "/");
        }
        
        // Redirigir según rol
        if($usuario['rol'] == 'admin'){
            header("Location: admin/panel.php");
        } elseif($usuario['rol'] == 'productor'){
            header("Location: productor/panel.php");
        } else {
            header("Location: index.php");
        }
        exit();
    } else {
        $_SESSION['error'] = "Correo o contraseña incorrectos";
        header("Location: login.php");
        exit();
    }
}
?>

<?php include "inc/pie.php"; ?>