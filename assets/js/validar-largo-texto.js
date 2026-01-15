function validarLargoTexto(idInput, min, max, idError) {
    const input = document.getElementById(idInput);
    const error = document.getElementById(idError);

    const texto = input.value.trim();

    if (texto.length < min) {
        error.textContent = `Debe tener al menos ${min} caracteres`;
        return false;
    }

    if (texto.length > max) {
        error.textContent = `No puede tener más de ${max} caracteres`;
        return false;
    }

    error.textContent = "";
    return true;
}
// Función para validar que solo se ingresen números en un campo
function validarNumeros(input) {
    // Elimina todo lo que no sea número
    input.value = input.value.replace(/[^0-9kK]/g, '').toUpperCase();;

    // Limita a 9 caracteres por seguridad
    if (input.value.length > 9) {
        input.value = input.value.slice(0, 9);
    }
}