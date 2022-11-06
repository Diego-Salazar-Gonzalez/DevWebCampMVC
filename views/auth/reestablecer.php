<main class="auth">

    <h2 class="auth__heading"><?php echo $titulo;?></h2>
    <p class="auth__text">Reestablecer Contraseña</p>
    <?php
        require_once __DIR__ . '/../templates/alertas.php';
    ?>
    <?php if($token_valido) { ?>
    <form method="POST" class="formulario">
        <div class="formulario__campo">
            <label for="passsword" class="formulario__label">Nueva Contraseña</label>
            <input
                type="password"
                class="formulario__input"
                placeholder="Nueva Contraseña"
                id="password"
                name="password"
            />
        <div class="formulario__campo">
            <label for="passsword2" class="formulario__label">Repite Contraseña</label>
            <input
                type="password"
                class="formulario__input"
                placeholder="Repetir Contraseña"
                id="password2"
                name="password2"
            />
        </div>

        <input type="submit" class="formulario__submit" value="Recuperar Contraseña"/>
    </form>
<?php 
    }
?>
    <div class="acciones">
        <a href="/registro" class="acciones__enlace">¿Aún no tienes Cuenta? Crea una</a>
        <a href="/login" class="acciones__enlace">Iniciar Sesion</a>
    </div>

</main>