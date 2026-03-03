let currentLang = localStorage.getItem("lotli-lang") || "es";
let isDarkMode = localStorage.getItem("lotli-theme") === "dark";

const translations = {
  es: {
    greeting: "¡Hola! Soy Lotli, tu asistente virtual.😊 ¿Sobre qué te gustaría saber más?",
    services: "Servicios",
    contact: "Contacto",
    portfolio: "Portafolio",
    unknown: "Lo siento, aún estoy aprendiendo. Puedes preguntarme sobre nuestros servicios, contacto o ubicación."
  },
  en: {
    greeting: "Hi! I'm Lotli, your virtual assistant.😊 What would you like to know about?",
    services: "Services",
    contact: "Contact",
    portfolio: "Portfolio",
    unknown: "Sorry, I'm still learning. You can ask about our services, contact or location."
  }
};

function toggleChat() {
  const chatContainer = document.getElementById("chat-container");
  const isVisible = chatContainer.style.display === "flex";

  if (!isVisible) {
    chatContainer.style.display = "flex";
    chatContainer.classList.add("lotli-animate-in");
    setTimeout(() => chatContainer.classList.remove("lotli-animate-in"), 300);
  } else {
    chatContainer.classList.add("lotli-animate-out");
    setTimeout(() => {
      chatContainer.style.display = "none";
      chatContainer.classList.remove("lotli-animate-out");
    }, 300);
  }
}

function sendMessage(message = null) {
  const input = document.getElementById("user-input");
  const userMessage = message || input.value.trim();
  if (!userMessage) return;

  appendMessage("user", userMessage);
  saveMessage("user", userMessage);
  input.value = "";

  const response = getBotResponse(userMessage.toLowerCase());

  setTimeout(() => {
    appendMessage("bot", response.text, response.html);
    saveMessage("bot", response.text);
    if (response.options?.length) showQuickOptions(response.options);
  }, 500);
}

function enlazarTexto(texto) {
  const urlRegex = /(https?:\/\/[^\s]+)/g;
  return texto.replace(urlRegex, (url) => {
    return `<a href="${url}" target="_blank" class="chat-link">${url}</a>`;
  });
}

function appendMessage(sender, content, html = null) {
  const chatBox = document.getElementById("chat-box");
  const messageDiv = document.createElement("div");
  messageDiv.classList.add("message", sender === "user" ? "user-message" : "bot-message");

  if (sender === "bot") {
    const logo = document.createElement("img");
    logo.src = "img/logonegro.png";
    logo.alt = "Lotli";
    logo.classList.add("bot-logo");
    messageDiv.appendChild(logo);
  }

  if (typeof content === "object" && content !== null && content.type) {
    if (content.type === "image" || content.type === "gif") {
      const img = document.createElement("img");
      img.src = content.src;
      img.alt = content.alt || "imagen";
      img.classList.add("chat-image");
      messageDiv.appendChild(img);
    }
  } else if (typeof content === "string" && content.trim() !== "") {
    const span = document.createElement("span");
    span.innerHTML = enlazarTexto(content);
    messageDiv.appendChild(span);
  }

  if (html) {
    const htmlContainer = document.createElement("div");
    htmlContainer.innerHTML = html;
    messageDiv.appendChild(htmlContainer);

    if (html.includes("contact-form")) {
      setTimeout(() => {
        document.getElementById("contact-form")?.addEventListener("submit", handleFormSubmit);
      }, 100);
    }
  }

  chatBox.appendChild(messageDiv);
  chatBox.scrollTop = chatBox.scrollHeight;
}

function showQuickOptions(options) {
  const chatBox = document.getElementById("chat-box");
  const optionsDiv = document.createElement("div");
  optionsDiv.classList.add("bot-message");

  options.forEach(opt => {
    const button = document.createElement("button");
    button.classList.add("quick-option");
    button.textContent = opt;
    button.onclick = () => {
      sendMessage(opt);
      optionsDiv.remove();
    };
    optionsDiv.appendChild(button);
  });

  chatBox.appendChild(optionsDiv);
  chatBox.scrollTop = chatBox.scrollHeight;
}

document.getElementById("user-input").addEventListener("keydown", function (event) {
  if (event.key === "Enter") {
    event.preventDefault();
    sendMessage();
  }
});

function getBotResponse(msg) {
  const lang = currentLang;
  const t = translations[lang];

  if (msg.includes("hola") || msg.includes("hello") || msg.includes("lotli")) {
    return {
      text: t.greeting,
      options: [t.services, t.contact, t.portfolio]
    };
  } else if (msg.includes("servicio") || msg.includes("services")) {
    return {
      text: lang === "es"
        ? "Ofrecemos desarrollo de software a la medida, sitios web, apps móviles y soluciones empresariales."
        : "We offer custom software development, websites, mobile apps, and business solutions.",
      options: lang === "es" ? ["Tecnologías", "¿Tienen precios?"] : ["Technologies", "Do you have prices?"]
    };
  } else if (msg.includes("contacto") || msg.includes("contact")) {
    return {
      text: lang === "es"
        ? "¿Cómo te gustaría contactarnos? 😊"
        : "How would you like to contact us? 😊",
      html: `
        <div class="contact-buttons">
          <a href="https://wa.me/5217721005528?text=Hola%20Lotli,%20quiero%20más%20información" target="_blank" class="contact-btn">
            <i class="fab fa-whatsapp"></i> WhatsApp
          </a>
          <a href="https://t.me/share/url?url=https://lotlware.com&text=Hola%20Lotli,%20quiero%20más%20información" target="_blank" class="contact-btn">
            <i class="fab fa-telegram"></i> Telegram
          </a>
          <a href="mailto:LotlwareSolutions@gmail.com?subject=Contacto&body=Hola,%20quiero%20información" class="contact-btn">
            <i class="fas fa-envelope"></i> Correo
          </a>
        </div>
      `
    };
  } else if (msg.includes("formulario") || msg.includes("cotización") || msg.includes("mensaje")) {
    return {
      text: "",
      html: `
        <div class="formulario-wrapper">
          <p class="formulario-texto">Por favor, llena el siguiente formulario y te responderemos pronto.</p>
          <form id="contact-form" class="lotli-form">
            <input type="text" name="nombre" placeholder="Tu nombre" required />
            <input type="email" name="correo" placeholder="Tu correo" required />
            <textarea name="mensaje" placeholder="Escribe tu mensaje aquí..." required></textarea>
            <button type="submit" class="quick-option">Enviar</button>
          </form>
        </div>
      `
    };
  } else if (msg.includes("portafolio") || msg.includes("portfolio") || msg.includes("proyectos")) {
    return {
      text: lang === "es"
        ? "Muy pronto podrás ver nuestros proyectos destacados en la sección 'Portafolio'."
        : "Soon you'll be able to see our featured projects in the 'Portfolio' section."
    };
  } else if (msg.includes("gif") || msg.includes("imagen") || msg.includes("muestra")) {
    return {
      text: "Aquí tienes una imagen de muestra 📸",
      html: `
        <img src="https://media.giphy.com/media/3oEjI6SIIHBdRxXI40/giphy.gif" alt="Ejemplo" class="chat-image" />
      `
    };
  } else {
    return {
      text: t.unknown,
      options: [t.services, t.contact, "Ubicación"]
    };
  }
}

function handleFormSubmit(event) {
  event.preventDefault();
  const form = event.target;
  const formData = new FormData(form);

  fetch("enviar-correo.php", {
    method: "POST",
    body: formData
  })
    .then(response => response.text())
    .then(data => {
      appendMessage("bot", "✅ ¡Gracias! Hemos recibido tu mensaje. Te responderemos pronto.");
    })
    .catch(error => {
      appendMessage("bot", "❌ Ocurrió un error al enviar el mensaje.");
      console.error("Error:", error);
    });

  form.remove();
}

function toggleTheme() {
  document.body.classList.toggle("dark-mode");
  isDarkMode = document.body.classList.contains("dark-mode");
  localStorage.setItem("lotli-theme", isDarkMode ? "dark" : "light");
}
document.getElementById("theme-toggle")?.addEventListener("click", toggleTheme);
if (isDarkMode) document.body.classList.add("dark-mode");

function toggleLanguage() {
  currentLang = currentLang === "es" ? "en" : "es";
  localStorage.setItem("lotli-lang", currentLang);
  sendMessage("hola");
}
document.getElementById("lang-toggle")?.addEventListener("click", toggleLanguage);

function saveMessage(sender, text) {
  const history = JSON.parse(localStorage.getItem("lotli-history") || "[]");
  history.push({ sender, text });
  localStorage.setItem("lotli-history", JSON.stringify(history));
}

function loadChatHistory() {
  const history = JSON.parse(localStorage.getItem("lotli-history") || "[]");
  history.forEach(entry => appendMessage(entry.sender, entry.text));
}

loadChatHistory();
