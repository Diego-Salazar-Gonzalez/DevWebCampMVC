<main class="auth">

    <h2 class="auth__heading"><?php echo $titulo;?></h2>
    <p class="auth__text">Recupera tu acceso a DevWebcamp</p>
    <?php
        require_once __DIR__ . '/../templates/alertas.php';
    ?>
    <form method="POST" action="/olvide" class="formulario">
        <div class="formulario__campo">
            <label for="email" class="formulario__label">Correo</label>
            <input
                type="email"
                class="formulario__input"
                placeholder="Tu Correo"
                id="email"
                name="email"
            />
        </div>

        <input type="submit" class="formulario__submit" value="Recuperar Contraseña"/>
    </form>
    <div class="acciones">
        <a href="/registro" class="acciones__enlace">¿Aún no tienes Cuenta? Crea una</a>
        <a href="/login" class="acciones__enlace">Iniciar Sesion</a>
    </div>

</main>