(function(){
    // Boton para mostrar el modal de Agregar Tarea
    const nuevaTareaBtn = document.querySelector('#agregar-tarea');
    nuevaTareaBtn.addEventListener('click', mostrarFormulario);

    
    function mostrarFormulario(){
        const modal = document.createElement('DIV');
        modal.classList.add('modal');
        modal.innerHTML = `
         <form class="formulario nueva-tarea">
            <legend>Añade una nueva Tarea</legend>
            <div class="campo"> 
                <label for="tarea">Tarea:</label>
                <input
                    type="text" 
                    name="tarea" 
                    placeholder="Añadir Tarea al Proyecto Actual"
                    id="tarea"
                />
            </div>
                <div class="opciones" >
                    <input type="submit" class="submit-nueva-tarea"  value="Agregar Tarea" />
                    <button type="button" class="cerrar-modal">Cancelar</button>

                </div>

         </form>
        `;

        setTimeout(() => {
            const formulario = document.querySelector('.formulario');
            formulario.classList.add('animar');
        }, 0);

        // Cerrar el modal
        modal.addEventListener('click', function(e) {
             e.preventDefault();

                if(e.target.classList.contains ('cerrar-modal')) {

                    const formulario = document.querySelector('.formulario');
                    formulario.classList.add('cerrar');
                    
                    setTimeout(() => {
                        modal.remove();
                    }, 1000);
                }
                
                if(e.target.classList.contains('submit-nueva-tarea') ) {
                    submitFormularioNuevaTarea();
                }

        });
        document.querySelector('.dashboard').appendChild(modal);  
   
    }

    function submitFormularioNuevaTarea() {
        const tarea = document.querySelector('#tarea').value.trim();

        if(tarea === '') {

            // Mostrar Alerta de error
            mostrarAlerta('El nombre de la tarea es Obligatorio', 'error', document.querySelector('.formulario legend'));
            return;
        }

       agregarTarea(tarea);
    }  
    // Mostrar una alerta en pantalla
    function mostrarAlerta (mensaje, tipo, referencia) {

        // Si hay una alerta previa, no crear otra
        const alertaPrevia = document.querySelector('.alerta');
        if(alertaPrevia) {
            alertaPrevia.remove();
        }

        const alerta = document.createElement('DIV');
        alerta.classList.add('alerta', tipo);
        alerta.textContent = mensaje;

       // Insertar alerta antes del legend
       referencia.parentElement.insertBefore(alerta, referencia.nextElementSibling);

         // Ocultar la alerta despues de 5 segundos
         setTimeout(() => {
            alerta.remove();
         }, 5000);




    }

    // Consulta el Servidor para añadir la nueva tarea al proyecto actual
    async function agregarTarea(tarea) {

        // Construir la petición
        const datos = new FormData();
        datos.append('nombre', tarea);
        datos.append('proyectoId', obtenerProyecto());


        try {
            const url = 'http://localhost:3000/api/tarea';
            const respuesta = await fetch(url, {
                method: 'POST',
                body: datos
            });
            
            const resultado = await respuesta.json();
            
            
        } catch (error) {
            console.log(error);
        }

    }

    function obtenerProyecto() {
        const proyectoParams = new URLSearchParams(window.location.search); 
        const proyecto = Object.fromEntries(proyectoParams.entries()); 
        return proyecto.id;
    }

})();