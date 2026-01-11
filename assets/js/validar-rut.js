function validarRut(rut) {
    rut = limpiarRut(rut);
    if (rut.length < 2) return false;

    let cuerpo = rut.slice(0, -1);
    let dv = rut.slice(-1);

    let suma = 0;
    let multiplo = 2;

    for (let i = cuerpo.length - 1; i >= 0; i--) {
        suma += cuerpo[i] * multiplo;
        multiplo = multiplo === 7 ? 2 : multiplo + 1;
    }

    let resto = suma % 11;
    let dvEsperado = 11 - resto;

    if (dvEsperado === 11) dvEsperado = '0';
    if (dvEsperado === 10) dvEsperado = 'K';

    return dv === dvEsperado.toString();
}

const rutInput = document.getElementById('rut');
const errorRut = document.getElementById('errorRut');

rutInput.addEventListener('input', () => {
    let limpio = limpiarRut(rutInput.value);
    rutInput.value = formatearRut(limpio);

    if (limpio.length >= 8 && !validarRut(limpio)) {
        errorRut.textContent = 'RUT chileno inválido';
    } else {
        errorRut.textContent = '';
    }
});