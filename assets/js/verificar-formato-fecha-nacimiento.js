function calcularEdadDesdeFormulario() {
    const fechaInput = document.getElementById("fecha_nac").value;

    if (!fechaInput) {
        alert("Debe ingresar una fecha de nacimiento");
        return false;
    }

    const fechaNacimiento = new Date(fechaInput);
    const hoy = new Date();

    let edad = hoy.getFullYear() - fechaNacimiento.getFullYear();
    const mes = hoy.getMonth() - fechaNacimiento.getMonth();

    if (mes < 0 || (mes === 0 && hoy.getDate() < fechaNacimiento.getDate())) {
        edad--;
    }

    if (edad < 0) {
        alert("La fecha de nacimiento no es válida");
        return false;
    }

    // Si NO tienes input edad, solo validas
    console.log("Edad calculada:", edad);

    // Ejemplo: mínimo 18 años
    if (edad < 18) {
        alert("Debe ser mayor de 18 años");
        return false;
    }

    return true;
}
