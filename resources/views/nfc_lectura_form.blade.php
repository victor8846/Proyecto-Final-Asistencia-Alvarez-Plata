<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8" />
<title>Registrar UID NFC</title>
</head>
<body>

<h2>Registrar UID NFC</h2>

<form id="formRegistrar" onsubmit="return false;">
  <label for="uid_input">UID NFC:</label>
  <input type="text" id="uid_input" name="uid_nfc" readonly />
  <input type="hidden" id="registro_id" />
  <button id="btnRegistrar">Registrar</button>
</form>

<script>
  // Consultar último UID no registrado cada 2 segundos
  setInterval(() => {
    fetch('/api/nfc-lectura/ultimo')
      .then(res => res.json())
      .then(data => {
        if (data.uid_nfc) {
          document.getElementById('uid_input').value = data.uid_nfc;
          document.getElementById('registro_id').value = data.id;
        }
      })
      .catch(console.error);
  }, 2000);

  // Al hacer clic en "Registrar"
  document.getElementById('btnRegistrar').addEventListener('click', () => {
    const id = document.getElementById('registro_id').value;
    if (!id) {
      alert('No hay UID para registrar');
      return;
    }

    fetch('/api/nfc-lectura/confirmar', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-API-KEY': 'INCOS2025'  // si tu API requiere esta cabecera, sino quítala
      },
      body: JSON.stringify({ id })
    })
    .then(res => res.json())
    .then(data => {
      alert(data.message);
      document.getElementById('uid_input').value = '';
      document.getElementById('registro_id').value = '';
    })
    .catch(err => {
      alert('Error al registrar UID');
      console.error(err);
    });
  });
</script>

</body>
</html>
