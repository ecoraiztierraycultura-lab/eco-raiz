<?php include "inc/cabecera.php"; ?>

<div class="contenedor">
    <div class="tarjeta" style="text-align: center;">
        <div class="area-logo">
            <div class="icono-logo">🌱</div>
            <h1 class="logo">Eco Raíz</h1>
            <p class="eslogan">Conectamos campo y ciudad</p>
        </div>

        <h2 class="titulo-formulario">Bienvenido</h2>
        
        <?php if(isset($_SESSION['usuario_id'])): ?>
            <p class="subtitulo-formulario">Hola, <?php echo $_SESSION['usuario_nombre']; ?></p>
            <a href="panel.php" class="btn-primario" style="display: inline-block; text-decoration: none;">Mi panel</a>
            <a href="cerrar.php" class="btn-primario" style="display: inline-block; text-decoration: none; background: #6c757d;">Cerrar sesión</a>
        <?php else: ?>
            <p class="subtitulo-formulario">Productos frescos, sin intermediarios</p>
            <a href="login.php" class="btn-primario" style="display: inline-block; text-decoration: none;">Iniciar sesión</a>
            <a href="registro.php" class="btn-primario" style="display: inline-block; text-decoration: none; background: #52b788;">Registrarse</a>
        <?php endif; ?>
    </div>
</div>

<?php include "inc/pie.php"; ?>