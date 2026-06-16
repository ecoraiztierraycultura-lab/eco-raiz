<?php include "inc/cabecera.php"; ?>

<div class="contenedor">
    <div class="tarjeta">
        <div class="area-logo">
            <div class="icono-logo">🌱</div>
            <h1 class="logo">Eco Raíz</h1>
            <p class="eslogan">Recupera tu acceso</p>
        </div>

        <h2 class="titulo-formulario">Recuperar contraseña</h2>
        <p class="subtitulo-formulario">Te enviaremos un correo con los pasos</p>

        <?php if(isset($_SESSION['error'])): ?>
            <div class="mensaje mensaje-error">
                <i class="fas fa-exclamation-circle"></i> <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <?php if(isset($_SESSION['exito'])): ?>
            <div class="mensaje">
                <i class="fas fa-check-circle"></i> <?php echo $_SESSION['exito']; unset($_SESSION['exito']); ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST" class="formulario">
            <div class="grupo-formulario">
                <label class="etiqueta">Correo electrónico</label>
                <input type="email" name="email" class="campo" placeholder="tu@correo.com" required>
            </div>

            <div class="grupo-formulario">
                <label class="etiqueta">Documento de identidad</label>
                <input type="text" name="documento" class="campo" placeholder="Ej. 123456789" required>
            </div>

            <button type="submit" name="recuperar_btn" class="btn-primario">Enviar código</button>
        </form>

        <p class="pie-formulario">
            <a href="login.php">← Volver a inicio</a>
        </p>
    </div>
</div>

<?php 
if(isset($_POST['recuperar_btn'])){
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $documento = mysqli_real_escape_string($db, $_POST['documento']);
    
    // Verificar si existe el usuario
    $sql = "SELECT * FROM usuarios WHERE email='$email' AND documento='$documento'";
    $resultado = mysqli_query($db, $sql);
    
    if(mysqli_num_rows($resultado) == 1){
        // Aquí enviarías un correo electrónico
        $_SESSION['exito'] = "Te hemos enviado un correo para recuperar tu contraseña";
        header("Location: recuperar.php");
        exit();
    } else {
        $_SESSION['error'] = "No encontramos un usuario con esos datos";
        header("Location: recuperar.php");
        exit();
    }
}
?>

<?php include "inc/pie.php"; ?>