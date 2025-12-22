
function verificarFormatoCorreo(correo) {
  correo = correo.trim().toLowerCase();

  const regex = /^[a-zA-Z0-9._%+-]+@(gmail\.com|hotmail\.com)$/;
  return regex.test(correo);
}

