(function(){

    obtenerTareas();

    // Boton para mostrar el modal de Agregar Tarea
    const nuevaTareaBtn = document.querySelector('#agregar-tarea');
    nuevaTareaBtn.addEventListener('click', mostrarFormulario);

    async function obtenerTareas() {

        try {
            const id = obtenerProyecto();
            const url = `/api/tareas?url=${id}`;
            const respuesta = await fetch(url);
            const resultado = await respuesta.json();

            const { tareas } = resultado;
            mostrarTareas(tareas); 

        } catch (error) {
            console.log(error);
        }

    }

    function mostrarTareas(tareas) {
        
        if(tareas.length === 0) {
            const contenedorTareas = document.querySelector('#listado-tareas');

            const textoNoTareas = document.createElement('LI');
            textoNoTareas.textContent = 'No Hay Tareas En Este Proyecto';
            textoNoTareas.classList.add('no-tareas');

            contenedorTareas.appendChild(textoNoTareas);
            return;
        }

        // dicionario de estados
        const estados = {
            0: 'Pendiente',
            1: 'Completa'
        }

        tareas.forEach(tarea => {
            const contenedorTareas = document.createElement('LI');
            contenedorTareas.dataset.tareaId = tarea._id;
            contenedorTareas.classList.add('tarea');

            const nombreTarea = document.createElement('P');
            nombreTarea.textContent = tarea.nombre; 

            const opcionesDiv = document.createElement('DIV');
            opcionesDiv.classList.add('opciones');

            // Botones
            const btnEstadoTarea = document.createElement('BUTTON');
            btnEstadoTarea.classList.add('estado-tarea');
            btnEstadoTarea.classList.add(`${estados[tarea.estado].toLowerCase()}`);
            btnEstadoTarea.textContent = estados[tarea.estado];
            btnEstadoTarea.dataset.estadoTarea = tarea.estado;

            const btnEliminarTarea = document.createElement('BUTTON');
            btnEliminarTarea.classList.add('eliminar-tarea');
            btnEliminarTarea.dataset.idTarea = tarea.id;
            btnEliminarTarea.textContent = 'Eliminar';

            opcionesDiv.appendChild(btnEstadoTarea);
            opcionesDiv.appendChild(btnEliminarTarea);

            contenedorTareas.appendChild(nombreTarea);
            contenedorTareas.appendChild(opcionesDiv);

            const listadoTareas = document.querySelector('#listado-tareas');
            listadoTareas.appendChild(contenedorTareas);
        });

    }
    
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
            

             // Mostrar Alerta de error
             mostrarAlerta(
                resultado.mensaje, 
                resultado.tipo, 
                document.querySelector('.formulario legend')
            );

            if(resultado.tipo === 'exito') {
                const modal = document.querySelector('.modal');
                setTimeout(() => {
                    modal.remove();
                }, 2000);
            }
                        
            
            
        } catch (error) {
            console.log(error);
        }

    }

    function obtenerProyecto() {
        const proyectoParams = new URLSearchParams(window.location.search);
        const proyecto = Object.fromEntries(proyectoParams.entries());
        return proyecto.url;
    }

})();