document.querySelector("#agregar-tarea").addEventListener("click",(function(){const e=document.createElement("DIV");e.classList.add("modal"),e.innerHTML='\n         <form class="formulario nueva-tarea">\n            <legend>Añade una nueva Tarea</legend>\n            <div class="campo"> \n                <label for="tarea">Tarea:</label>\n                <input\n                    type="text" \n                    name="tarea" \n                    placeholder="Añadir Tarea al Proyecto Actual"\n                    id="tarea"\n                />\n            </div>\n                <div class="opciones" >\n                    <input type="submit" class="submit-nueva-tarea"  value="Agregar Tarea" />\n                    <button type="button" class="cerrar-modal">Cancelar</button>\n\n                </div>\n\n         </form>\n        ',setTimeout(()=>{document.querySelector(".formulario").classList.add("animar")},0),e.addEventListener("click",(function(a){a.preventDefault(),a.target.classList.contains("cerrar-modal")&&(document.querySelector(".formulario").classList.add("cerrar"),setTimeout(()=>{e.remove()},1e3)),console.log(a.target.classList)})),document.querySelector("body").appendChild(e)}));