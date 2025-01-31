document.addEventListener("DOMContentLoaded", () => {
    const formulario = document.getElementById("formulario");
    const planSelect = document.getElementById("plan");
    const duracionSelect = document.getElementById("duracion");
    const paquetesCheckboxes = document.querySelectorAll("input[name='paquetes[]']");
    const precioTotalInput = document.getElementById("precioTotal");


    function calcularPrecio() {
        const plan = planSelect.value;
        const duracion = duracionSelect.value;
        const paquetes = Array.from(paquetesCheckboxes).filter(checkbox => checkbox.checked).map(checkbox => checkbox.value);

        let precioTotal = 0;

        if (plan && duracion) {
            const precioPlanMensual = preciosPlan[plan];
            const multiplicadorDuracion = duracion === 'anual' ? 12 : 1;
            precioTotal += precioPlanMensual * multiplicadorDuracion;
        }

        paquetes.forEach(paquete => {
            const precioPaqueteMensual = preciosPaquetes[paquete];
            const multiplicadorDuracion = duracion === 'anual' ? 12 : 1;
            precioTotal += precioPaqueteMensual * multiplicadorDuracion;
        });

        precioTotalInput.value = `€${precioTotal.toFixed(2)}`;
    }

    planSelect.addEventListener("change", calcularPrecio);
    duracionSelect.addEventListener("change", calcularPrecio);
    paquetesCheckboxes.forEach(checkbox => checkbox.addEventListener("change", calcularPrecio));
    
    // Inicializar el precio total al cargar la página
    calcularPrecio();
});