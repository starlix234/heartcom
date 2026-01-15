function limpiarRut(rut) {
    return rut.replace(/[^0-9kK]/g, '').toUpperCase();
}

function formatearRUT(input) {
    let rut = input.value.replace(/[^0-9kK]/g, '').toUpperCase();
    
    if (rut.length > 9) {
        rut = rut.slice(0, 9);
    }
    
    if (rut.length < 2) {
        input.value = rut;
        return;
    }

    let cuerpo = rut.slice(0, -1);
    let dv = rut.slice(-1);

    cuerpo = cuerpo.replace(/\B(?=(\d{3})+(?!\d))/g, ".");

    input.value = cuerpo + "-" + dv;
}



