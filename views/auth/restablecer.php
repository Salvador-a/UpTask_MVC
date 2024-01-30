<div class="contenedor restablecer">
<?php include_once __DIR__ .'/../templates/nombre-sitio.php' ?>

    <div class="contenedor-sm">
        <p class="descripcion-paguina">Coloca tu nuevo password</p>
        
        <?php include_once __DIR__ .'/../templates/alertas.php' ?>

        <?php if ($mostrar) { ?>


        <form class="formulario" method="POST" >
           

            <div class="campo">
                <label for="password">Password</label>
                <input 
                    type="password"
                    id="password"
                    placeholder="Tu Password"
                    name="password"
                />
            </div>

            <input type="submit" class="boton" value="Guardar Pasword">
        </form>
        <?php } ?>
        <!--Rautin-->
        <div class="acciones">
            <a href="/crear">¿Aún no tienes una cuenta? obtener una cuneta</a>
            <a href="/olvide">¿Olvidaste tu contraseña?</a>

        </div>
    </div> <!--.contenedor-sm-->


</div>