(function () {
  const config = window.CEAA_CHATBOT_CONFIG || { baseUri: '', userName: 'Usuario', rolId: 0 };

  const toggleBtn = document.getElementById('chatbotToggle');
  const widget = document.getElementById('chatbotWidget');
  const closeBtn = document.getElementById('chatbotClose');
  const form = document.getElementById('chatbotForm');
  const input = document.getElementById('chatbotInput');
  const messages = document.getElementById('chatbotMessages');
  const quick = document.getElementById('chatbotQuick');

  if (!toggleBtn || !widget || !form || !input || !messages || !quick) return;

  const quickOptions = [
    'No puedo iniciar sesión',
    'Recuperar contraseña',
    'Cómo editar inventario',
    'Generar reporte PDF',
    'Permisos de usuarios',
    'Abrir manual técnico'
  ];

  function normalize(text) {
    return (text || '')
      .toLowerCase()
      .normalize('NFD')
      .replace(/[\u0300-\u036f]/g, '')
      .trim();
  }

  function link(path, label) {
    return `<a href="${config.baseUri}/index.php?${path}">${label}</a>`;
  }

  function manualUrl() {
    return `${config.baseUri}/index.php?controller=manual&action=ver`;
  }

  function responseFor(message) {
    const msg = normalize(message);

    if (/hola|buenas|ayuda|soporte/.test(msg)) {
      return {
        text: `Hola ${config.userName}. Te puedo ayudar con login, contraseñas, inventario, reportes, formatos y permisos.`
      };
    }

    if (/no puedo iniciar|login|iniciar sesion|credencial|acceso/.test(msg)) {
      return {
        text:
          'Si no puedes iniciar sesión:\n1) Verifica correo y contraseña.\n2) Revisa mayúsculas/minúsculas.\n3) Si persiste, solicita al administrador validar que tu usuario esté activo.',
        links: [
          link('controller=auth&action=login', 'Ir a inicio de sesión'),
          link('controller=dashboard&action=perfil', 'Revisar mi perfil')
        ]
      };
    }

    if (/password|contrasena|contraseña|recuperar|cambiar clave/.test(msg)) {
      return {
        text:
          'Para cambiar contraseña entra a Perfil. Si olvidaste la contraseña, pide a un administrador que restablezca tu usuario desde Gestión de Usuarios.',
        links: [
          link('controller=dashboard&action=perfil', 'Ir a Perfil'),
          link('controller=users&action=index', 'Gestión de Usuarios')
        ]
      };
    }

    if (/inventario|editar inventario|captura inventario|recurso/.test(msg)) {
      return {
        text:
          'En Inventario puedes crear, editar y consultar recursos. Si no te guarda cambios, revisa que los campos clave y nombre no estén vacíos.',
        links: [
          link('controller=inventario&action=form', 'Abrir Inventario'),
          link('controller=reportes&action=inventario', 'Reporte de Inventario')
        ]
      };
    }

    if (/manual|guia|documentacion|documentación|instructivo|como uso|cómo uso/.test(msg)) {
      return {
        text:
          'Puedes consultar el manual técnico para pasos detallados, solución de fallas comunes y flujos del sistema.',
        links: [
          `<a href="${manualUrl()}" target="_blank" rel="noopener noreferrer">Abrir manual técnico (PDF)</a>`
        ]
      };
    }

    if (/reporte|pdf|anual|municipio|excel/.test(msg)) {
      return {
        text:
          'Para reportes usa el módulo de reportes de inventario o Formatos. Si no se genera PDF, valida que existan datos y permisos de escritura en /public/pdf.',
        links: [
          link('controller=reportes&action=inventario', 'Ir a Reportes de Inventario'),
          link('controller=formatos&action=index', 'Ir a Formatos')
        ]
      };
    }

    if (/eca|ficha|formato/.test(msg)) {
      return {
        text:
          'Las Fichas ECA se capturan en Formatos. Puedes crear, editar y consultar fichas por municipio desde el mismo módulo.',
        links: [
          link('controller=formatos&action=capturaECA', 'Capturar Ficha ECA'),
          link('controller=formatos&action=consultaECA', 'Consultar Fichas ECA')
        ]
      };
    }

    if (/permiso|rol|usuario|administrador|no autorizado|403/.test(msg)) {
      return {
        text:
          'Ese problema suele ser de rol/permisos. Verifica tu rol de usuario y que la sesión siga activa. Solo el rol administrador puede gestionar usuarios.',
        links: [
          link('controller=users&action=index', 'Gestión de Usuarios'),
          link('controller=dashboard&action=perfil', 'Ver mi perfil')
        ]
      };
    }

    if (/error 500|pantalla en blanco|no carga|falla|falla sistema|bug/.test(msg)) {
      return {
        text:
          'Si el sistema falla: \n1) Recarga la página.\n2) Cierra e inicia sesión.\n3) Verifica conexión y datos obligatorios.\n4) Si continúa, reporta módulo, acción y hora exacta al administrador para revisar logs de PHP/Apache.'
      };
    }

    return {
      text:
        'No encontré una respuesta exacta. Intenta preguntar por: login, contraseña, inventario, reportes, formatos, ECA o permisos.'
    };
  }

  function addMessage(type, text, links) {
    const bubble = document.createElement('div');
    bubble.className = `chatbot-msg ${type}`;
    bubble.textContent = text;

    if (links && links.length) {
      const linksWrap = document.createElement('div');
      linksWrap.className = 'chatbot-links';
      linksWrap.innerHTML = links.join('');
      bubble.appendChild(linksWrap);
    }

    messages.appendChild(bubble);
    messages.scrollTop = messages.scrollHeight;
  }

  function ask(message) {
    addMessage('user', message);
    const answer = responseFor(message);
    setTimeout(() => addMessage('bot', answer.text, answer.links), 200);
  }

  function openWidget() {
    widget.classList.add('is-open');
    widget.setAttribute('aria-hidden', 'false');
    input.focus();
  }

  function closeWidget() {
    widget.classList.remove('is-open');
    widget.setAttribute('aria-hidden', 'true');
  }

  toggleBtn.addEventListener('click', function () {
    if (widget.classList.contains('is-open')) {
      closeWidget();
    } else {
      openWidget();
    }
  });

  closeBtn?.addEventListener('click', closeWidget);

  form.addEventListener('submit', function (event) {
    event.preventDefault();
    const message = input.value.trim();
    if (!message) return;
    ask(message);
    input.value = '';
  });

  quickOptions.forEach(function (option) {
    const button = document.createElement('button');
    button.type = 'button';
    button.textContent = option;
    button.addEventListener('click', function () {
      if (normalize(option) === 'abrir manual tecnico') {
        window.open(manualUrl(), '_blank', 'noopener,noreferrer');
        addMessage('bot', 'Abrí el manual técnico en una nueva pestaña.');
        return;
      }
      ask(option);
    });
    quick.appendChild(button);
  });

  addMessage(
    'bot',
    `Hola ${config.userName}. Soy tu asistente de soporte CEAA. Pregúntame cualquier duda del sistema o qué hacer cuando algo falla.`
  );
})();
