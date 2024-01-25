<div class="contenedor olvide">
    <?php include_once __DIR__ .'/../templates/nombre-sitio.php' ?>

    <div class="contenedor-sm">
        <p class="descripcion-paguina">Recupera tu Accesos a UpTask</p>


        <form class="formulario" method="POST" action="/olvide" >
            

            <div class="campo">
                <label for="email">Email</label>
                <input 
                    type="email"
                    id="email"
                    placeholder="Tu Email"
                    name="email"
                    
                />
            </div>


            <input type="submit" class="boton" value="Enviar Instrucciones">
        </form>
        <!--Rautin-->
        <div class="acciones">
            <a href="/">¿Ya tienes una cuenta? Iniciar Sesión</a>
            <a href="/crear">¿Aún no tienes una cuenta? obtener una cuneta</a>

        </div>
    </div> <!--.contenedor-sm-->


</div>