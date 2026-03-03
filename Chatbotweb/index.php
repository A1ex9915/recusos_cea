<!-- index.php (simplificado) -->
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Chatbot Lotli</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<!-- Bot flotante -->
<div id="chat-toggle" class="chat-toggle" onclick="toggleChat()">
  <img src="img/incono.png" alt="Lotli Logo" class="lotli-icon" />
</div>

<!-- Ventana del chatbot -->
<div class="chat-container" id="chat-container">
  <div class="chat-header">
    <div class="left">
      <img src="img/incono.png" alt="Lotli">
      <span>Asistente Lotli</span>
    </div>
    <div class="chat-controls">
      <button id="lang-toggle" title="Cambiar idioma">🌐</button>
      <button id="theme-toggle" title="Modo oscuro/claro">🌗</button>
      <button onclick="toggleChat()"><i class="fas fa-times"></i></button>
    </div>
  </div>

  <div id="chat-box" class="chat-box"></div>
  <div id="quick-options" class="quick-options"></div>

  <div class="input-container">
    <input type="text" id="user-input" placeholder="Escribe tu mensaje..." maxlength="100" />
    <button onclick="sendMessage()" id="send-btn"><i class="fas fa-paper-plane"></i></button>
  </div>
</div>

<script src="script.js"></script>
</body>
</html>
