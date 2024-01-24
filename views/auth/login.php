<div class="contenedor login">
    <h1 class="uptask">UpTask</h1>
    <p class="tagline">Crea y Administra tus proyectos</p>

    <div class="contenedor-sm">
        <p class="descripcion-paguina">Iniciar Seción</p>


        <form class="formulario" method="POST" action="/" >
            <div class="campo">
                <label for="email">Email</label>
                <input 
                    type="text"
                    id="email"
                    placeholder="Tu Email"
                    name="email"
                    
                />
            </div>

            <div class="campo">
                <label for="password">Password</label>
                <input 
                    type="password"
                    id="password"
                    placeholder="Tu Password"
                    name="password"
                />
            </div>

            <input type="submit" class="boton" value="Iniciar Sesión">
        </form>
        <!--Rautin-->
        <div class="acciones">
            <a href="/crear">¿Aún no tienes una cuenta? obtener una cuneta</a>
            <a href="/olvide">¿Olvidaste tu contraseña?</a>

        </div>
    </div> <!--.contenedor-sm-->


</div>