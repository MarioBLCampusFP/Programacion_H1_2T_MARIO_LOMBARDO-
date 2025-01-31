formulario.addEventListener("submit", (e) => {
    const edad = parseInt(document.getElementById("edad").value, 10);
    const plan = document.getElementById("plan").value.toLowerCase();
    const duracion = document.getElementById("duracion").value.toLowerCase();
    const paquetes = [...document.querySelectorAll("input[name='paquetes[]']:checked")].map(paquete => paquete.value.toLowerCase());
    
    // Validaciones
    if (edad < 18 && (!paquetes.includes("infantil") && paquetes.length > 0)) {
        alert("Los usuarios menores de 18 años solo pueden contratar el Pack Infantil.");
        e.preventDefault();
        return;
    }
    if (plan === "básico" && paquetes.length > 1) {
        alert("Los usuarios del Plan Básico solo podrán seleccionar un paquete adicional.");
        e.preventDefault();
        return;
    }
    if (paquetes.includes("deporte") && duracion !== "anual") {
        alert("El Pack Deporte solo puede ser contratado si la duración de la suscripción es de 1 año.");
        e.preventDefault();
        return;
    }
});