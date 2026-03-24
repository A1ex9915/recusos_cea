/* =========================================================
 *  Asistente CEAA — v3
 *  - Score-based intent matching (elige el tema más probable)
 *  - Respuestas con pasos numerados en HTML
 *  - Chips de seguimiento dinámicos por tema
 *  - Indicador de escritura animado
 *  - Saludos con hora del día, solo una vez por sesión
 *  - Opciones de inicio basadas en el rol (admin / usuario)
 *  - Sugerencias proactivas según el módulo activo (URL)
 *  - Historial persistente en localStorage (7 días)
 *  - Calificación 👍 / 👎 por respuesta del bot
 * ========================================================= */
(function () {
  'use strict';

  var config  = window.CEAA_CHATBOT_CONFIG || { baseUri: '', userName: 'Usuario', rolId: 0 };
  var isAdmin = config.rolId === 1;

  /* ── DOM ────────────────────────────────────────────────── */
  var toggleBtn = document.getElementById('chatbotToggle');
  var widget    = document.getElementById('chatbotWidget');
  var closeBtn  = document.getElementById('chatbotClose');
  var form      = document.getElementById('chatbotForm');
  var input     = document.getElementById('chatbotInput');
  var messages  = document.getElementById('chatbotMessages');
  var quick     = document.getElementById('chatbotQuick');

  if (!toggleBtn || !widget || !form || !input || !messages || !quick) return;

  var hasOpened = false;
  var HIST_KEY  = 'ceaa_chat_v2';
  var HIST_DAYS = 7;

  /* ── Helpers ────────────────────────────────────────────── */
  function normalize(t) {
    return (t || '').toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '').trim();
  }

  function url(qs)         { return config.baseUri + '/index.php?' + qs; }
  function manualUrl()     { return url('controller=manual&action=ver'); }
  function nowTime() {
    var d = new Date();
    return ('0' + d.getHours()).slice(-2) + ':' + ('0' + d.getMinutes()).slice(-2);
  }
  function greeting() {
    var h = new Date().getHours();
    return h < 12 ? 'Buenos días' : h < 19 ? 'Buenas tardes' : 'Buenas noches';
  }

  function lnk(qs, label, icon) {
    return '<a class="cb-lnk" href="' + url(qs) + '">' + (icon ? icon + ' ' : '') + label + '</a>';
  }

  /* ── Base de conocimiento ───────────────────────────────── */
  var intents = [
    {
      id: 'saludo',
      kw: ['hola','buenos','buenas','hey','saludos','hi','que tal','qué tal','inicio','empezar'],
      followUps: ['¿Cómo agrego un recurso?','Generar reporte PDF','No puedo iniciar sesión','Abrir manual técnico'],
      resp: function () {
        return {
          text: greeting() + ', ' + config.userName + '. Estoy aquí para ayudarte. ¿Qué necesitas hoy?',
          steps: null,
          links: []
        };
      }
    },
    {
      id: 'login',
      kw: ['no puedo iniciar','login','iniciar sesion','credencial','acceso','no entro','no me deja','contraseña incorrecta','usuario incorrecto','bloqueo','sesion expirada','sesión expirada'],
      followUps: ['Cambiar contraseña','¿Qué rol tengo?','Abrir manual técnico'],
      resp: function () {
        return {
          text: 'Sigue estos pasos para resolver el problema de acceso:',
          steps: [
            'Verifica que el <strong>correo y contraseña</strong> sean exactamente correctos (respeta mayúsculas y espacios).',
            'Asegúrate de que tu cuenta esté <strong>activa</strong> — solo un administrador puede activarla.',
            'Borra caché del navegador (<kbd>Ctrl + Shift + Del</kbd>) y vuelve a intentarlo.',
            'Si el error sigue apareciendo, pide al administrador que verifique o restablezca tu contraseña.'
          ],
          links: [
            lnk('controller=auth&action=login',      'Ir al inicio de sesión', '🔑'),
            lnk('controller=dashboard&action=perfil', 'Mi perfil',              '👤')
          ]
        };
      }
    },
    {
      id: 'password',
      kw: ['password','contrasena','contraseña','recuperar','cambiar clave','olvide','olvidé','cambiar password','nueva contraseña','resetear'],
      followUps: ['No puedo iniciar sesión','Actualizar mi perfil','Abrir manual técnico'],
      resp: function () {
        return {
          text: 'Para cambiar tu contraseña:',
          steps: [
            'Ve a <strong>Perfil</strong> en el menú lateral izquierdo.',
            'Baja hasta la sección <strong>"Cambiar contraseña"</strong>.',
            'Escribe la contraseña actual y la nueva (mín. 8 caracteres, mayúscula, número y símbolo).',
            'Haz clic en <strong>Cambiar contraseña</strong> — si el botón está gris, faltan requisitos.'
          ],
          links: [
            lnk('controller=dashboard&action=perfil', 'Ir a mi perfil', '👤')
          ]
        };
      }
    },
    {
      id: 'perfil',
      kw: ['perfil','foto','foto perfil','actualizar perfil','mis datos','editar mis datos','cambiar foto','cambiar nombre','cambiar correo'],
      followUps: ['Cambiar contraseña','No puedo iniciar sesión'],
      resp: function () {
        return {
          text: 'Para actualizar tu perfil:',
          steps: [
            'Haz clic en <strong>Perfil</strong> en el menú lateral.',
            'Edita tu nombre o correo y presiona <strong>Actualizar perfil</strong>.',
            'Para cambiar la foto, selecciona una imagen JPG o PNG (máx. recomendado: 2 MB).',
            'La contraseña se cambia en la sección de abajo, en la misma página.'
          ],
          links: [
            lnk('controller=dashboard&action=perfil', 'Ir a mi perfil', '👤')
          ]
        };
      }
    },
    {
      id: 'inventario',
      kw: ['inventario','recurso','bien','activo','crear recurso','editar inventario','captura inventario','agregar recurso','nuevo recurso','alta recurso','actualizar recurso','cantidad','stock','clave recurso'],
      followUps: ['Buscar por municipio','Exportar inventario a Excel','Generar reporte PDF'],
      resp: function () {
        return {
          text: 'Para trabajar con el inventario:',
          steps: [
            'Abre <strong>Inventario</strong> desde el menú lateral.',
            'Para añadir un recurso nuevo, llena el formulario: <strong>clave, nombre, categoría y organismo</strong> son obligatorios.',
            'Para editar uno existente, búscalo y haz clic en el botón de editar.',
            'Guarda los cambios — aparecerá un mensaje de confirmación en verde.',
            'Si no guarda, revisa que no haya campos vacíos o con formato incorrecto.'
          ],
          links: [
            lnk('controller=inventario&action=form',     'Alta / Edición Inventario', '📦'),
            lnk('controller=reportes&action=inventario', 'Reporte de Inventario',     '📊')
          ]
        };
      }
    },
    {
      id: 'reporte_pdf',
      kw: ['reporte','pdf','generar pdf','reporte pdf','reporte municipal','reporte anual','generar reporte','descarga pdf','imprimir','municipio pdf','anual pdf'],
      followUps: ['Listar reportes municipales','Listar reportes anuales','Exportar a Excel'],
      resp: function () {
        return {
          text: 'Para generar un reporte PDF:',
          steps: [
            'Ve a <strong>Formatos / Capturas</strong> en el menú.',
            'Para <strong>PDF Municipal</strong>: elige municipio, organismo y selecciona los recursos a incluir.',
            'Para <strong>PDF Anual</strong>: elige el año y confirma la generación.',
            'El PDF generado se guarda automáticamente en la sección de <strong>Reportes generados</strong>.',
            'Si no se genera, verifica que haya recursos disponibles con ese filtro.'
          ],
          links: [
            lnk('controller=formatos&action=index',                     'Ir a Formatos',          '📋'),
            lnk('controller=reportes&action=listarReportesMunicipales', 'Reportes Municipales',   '🗂️'),
            lnk('controller=reportes&action=listarReportesAnuales',     'Reportes Anuales',       '📅')
          ]
        };
      }
    },
    {
      id: 'excel',
      kw: ['excel','exportar','xlsx','descargar excel','exportar excel','tabla excel','tabla'],
      followUps: ['Filtrar inventario','Generar reporte PDF','Ver manual técnico'],
      resp: function () {
        return {
          text: 'Para exportar el inventario a Excel:',
          steps: [
            'Abre el módulo <strong>Reportes de Inventario</strong>.',
            'Aplica los filtros que necesites: municipio, categoría, estado, año.',
            'Haz clic en el botón <strong>Exportar Excel</strong>.',
            'El archivo .xlsx se descarga automáticamente.'
          ],
          links: [
            lnk('controller=reportes&action=inventario', 'Reportes de Inventario', '📊')
          ]
        };
      }
    },
    {
      id: 'eca',
      kw: ['eca','ficha','ficha tecnica','ficha eca','capturar eca','formato eca','espacio cultura','cultura del agua','editar eca','ver eca','consultar eca'],
      followUps: ['Generar reporte PDF','Ver inventario','Abrir manual técnico'],
      resp: function () {
        return {
          text: 'Para trabajar con Fichas ECA (Espacios de Cultura del Agua):',
          steps: [
            'Ve a <strong>Formatos / Capturas</strong> en el menú lateral.',
            'Selecciona <strong>Capturar Ficha ECA</strong> para registrar una nueva.',
            'Completa los campos: municipio, organismo, tipo de ECA y datos técnicos.',
            'Para editar o consultar fichas existentes, usa <strong>Consultar Fichas ECA</strong>.',
            'Puedes buscar por municipio o por nombre del organismo.'
          ],
          links: [
            lnk('controller=formatos&action=capturaECA',  'Capturar Ficha ECA',    '📝'),
            lnk('controller=formatos&action=consultaECA', 'Consultar Fichas ECA',  '🔍')
          ]
        };
      }
    },
    {
      id: 'usuarios',
      kw: ['usuario','usuarios','gestion usuario','nuevo usuario','crear usuario','editar usuario','rol','permiso','administrador','acceso negado','403','no autorizado','sin permiso','desactivar usuario'],
      followUps: ['Cambiar contraseña','Cambiar mi rol','Abrir manual técnico'],
      resp: function () {
        if (isAdmin) {
          return {
            text: 'Como administrador, puedes gestionar usuarios:',
            steps: [
              'Ve a <strong>Gestión de Usuarios</strong> en el menú lateral.',
              'Crea un usuario con nombre, correo, contraseña y rol.',
              'Edita perfiles, cambia roles o activa/desactiva cuentas.',
              'Solo el <strong>rol Administrador (1)</strong> tiene acceso a esta sección.'
            ],
            links: [
              lnk('controller=users&action=index',  'Gestión de Usuarios', '👥'),
              lnk('controller=users&action=create', 'Crear Usuario',       '➕')
            ]
          };
        }
        return {
          text: 'Los permisos de usuario los gestiona el administrador del sistema.',
          steps: [
            'Si ves un error <strong>403 / No autorizado</strong>, contacta al administrador.',
            'El administrador puede cambiar tu rol desde Gestión de Usuarios.',
            'Tu rol actual se muestra en tu perfil.'
          ],
          links: [
            lnk('controller=dashboard&action=perfil', 'Ver mi perfil', '👤')
          ]
        };
      }
    },
    {
      id: 'manual',
      kw: ['manual','guia','documentacion','documentación','instructivo','como uso','cómo uso','ayuda sistema','tutorial','ver manual','manual usuario','manual de usuario','manual tecnico'],
      followUps: ['No puedo iniciar sesión','¿Cómo agrego recursos?','Generar reporte PDF'],
      resp: function () {
        return {
          text: 'El manual de usuario describe cada módulo e interfaz del sistema con instrucciones paso a paso.',
          steps: [
            'Explica cómo navegar el sistema: login, perfil, fichas ECA, inventario y reportes.',
            'Incluye los campos de cada formulario y qué hace cada botón.',
            'Consulta la sección de <strong>Roles y permisos</strong> si ves opciones bloqueadas.',
            'Al final encontrarás respuestas a las preguntas más frecuentes.'
          ],
          links: [
            '<a class="cb-lnk" href="' + manualUrl() + '" target="_blank" rel="noopener noreferrer">📖 Abrir manual de usuario (PDF)</a>'
          ]
        };
      }
    },
    {
      id: 'municipio_organismo',
      kw: ['municipio','organismo','operador','catalogo','catálogo','municipios','organismos','filtrar municipio','buscar municipio'],
      followUps: ['Filtrar inventario por municipio','Reporte por municipio','Abrir manual técnico'],
      resp: function () {
        return {
          text: 'Municipios y organismos son catálogos del sistema CEAA.',
          steps: [
            'Se usan para filtrar inventario, reportes y fichas ECA.',
            'Al registrar un recurso, selecciona el <strong>municipio y organismo</strong> correspondiente.',
            'Para ver todo el inventario de un municipio, usa el filtro en Reportes de Inventario.',
            'Para generar un PDF por municipio, ve a Formatos → Reporte Municipal.'
          ],
          links: [
            lnk('controller=formatos&action=index',      'Formatos / Reportes',      '📋'),
            lnk('controller=reportes&action=inventario', 'Filtrar por municipio',    '📊')
          ]
        };
      }
    },
    {
      id: 'error_sistema',
      kw: ['error 500','pantalla en blanco','no carga','falla','bug','problema sistema','error sistema','no funciona','roto','no guarda','no aparece','página vacía','pagina vacia','se cayó','se cayo'],
      followUps: ['Cerrar e iniciar sesión','Ver manual técnico','Contactar administrador'],
      resp: function () {
        return {
          text: 'Para diagnosticar un fallo del sistema:',
          steps: [
            '<strong>Recarga la página</strong> con <kbd>F5</kbd> o <kbd>Ctrl + R</kbd>.',
            '<strong>Cierra sesión y vuelve a entrar</strong> — la sesión puede haber expirado.',
            'Verifica que los <strong>campos obligatorios</strong> estén bien llenados.',
            'Si el error es <strong>500</strong>, hay un fallo de servidor — reporta al administrador: módulo, acción y hora exacta.',
            'El administrador revisa los logs en <code>/scripts/err.txt</code> o los logs de Apache/XAMPP.'
          ],
          links: []
        };
      }
    },
    {
      id: 'bitacora',
      kw: ['bitacora','bitácora','log','historial','auditoria','auditoría','registro acciones','quien hizo','quién hizo'],
      followUps: ['Gestión de usuarios','Ver manual técnico'],
      resp: function () {
        return {
          text: 'La bitácora registra todas las acciones clave del sistema.',
          steps: [
            'Se guarda automáticamente en la tabla <code>bitacora</code> de la base de datos.',
            'Registra: acción, módulo, usuario, IP y fecha/hora.',
            'Un administrador con acceso a la BD puede consultar el historial completo.',
            'Busca por <strong>accion, modulo, usuario_id o creado_en</strong> para filtrar.'
          ],
          links: []
        };
      }
    }
  ];

  /* ── Matching por puntuación ─────────────────────────────
     Cada keyword que aparezca en el mensaje suma puntos.
     Las frases más largas valen más (número de palabras).
     Gana el intent con mayor puntuación total.
  ─────────────────────────────────────────────────────────── */
  function findIntent(msg) {
    var norm  = normalize(msg);
    var best  = null;
    var bestScore = 0;
    intents.forEach(function (intent) {
      var score = 0;
      intent.kw.forEach(function (kw) {
        if (norm.indexOf(normalize(kw)) !== -1) {
          score += kw.split(' ').length; // frase larga = más puntos
        }
      });
      if (score > bestScore) { bestScore = score; best = intent; }
    });
    return bestScore > 0 ? best : null;
  }

  /* ── Quick options según rol ─────────────────────────────── */
  function defaultQuick() {
    if (isAdmin) {
      return ['Crear usuario','Generar reporte PDF','Ver fichas ECA','Exportar a Excel','Abrir manual técnico'];
    }
    return ['No puedo iniciar sesión','Cambiar contraseña','¿Cómo agrego un recurso?','Generar reporte PDF','Abrir manual técnico'];
  }

  /* ── Sugerencias proactivas por módulo activo (URL) ─────── */
  function pageContext() {
    var ctrl = 'dashboard';
    try {
      var m = location.search.match(/[?&]controller=([^&]+)/);
      if (m) ctrl = m[1];
    } catch(e) {}
    var map = {
      'inventario': ['Estado del inventario','Buscar por folio','Exportar a Excel','Generar reporte PDF','Filtrar por municipio'],
      'reportes':   ['Generar reporte PDF','Exportar a Excel','Listar reportes municipales','Reporte anual PDF'],
      'formatos':   ['Capturar Ficha ECA','Consultar fichas ECA','Generar reporte PDF','Ver manual técnico'],
      'users':      isAdmin
                      ? ['Crear usuario','Editar usuario','Cambiar contraseña','¿Qué es el rol administrador?']
                      : ['¿Qué rol tengo?','Cambiar contraseña','No puedo iniciar sesión'],
      'manual':     ['No puedo iniciar sesión','Cambiar contraseña','Generar reporte PDF','Exportar a Excel']
    };
    return map[ctrl] || defaultQuick();
  }

  /* ── Render chips de sugerencias ────────────────────────── */
  function setQuick(options) {
    quick.innerHTML = '';
    (options || []).slice(0, 5).forEach(function (label) {
      var btn = document.createElement('button');
      btn.type = 'button';
      btn.textContent = label;
      btn.addEventListener('click', function () { handleMessage(label); });
      quick.appendChild(btn);
    });
  }

  /* ── Historial persistente en localStorage ───────────────── */
  function pushHistory(type, inner) {
    var arr = readHistory();
    arr.push({ type: type, inner: inner, ts: Date.now() });
    if (arr.length > 60) arr = arr.slice(-60);
    try { localStorage.setItem(HIST_KEY, JSON.stringify(arr)); } catch(e) {}
  }
  function readHistory() {
    try {
      var raw    = localStorage.getItem(HIST_KEY);
      if (!raw) return [];
      var parsed = JSON.parse(raw);
      var cutoff = Date.now() - (HIST_DAYS * 86400000);
      return parsed.filter(function(e) { return e.ts && e.ts > cutoff; });
    } catch(e) { return []; }
  }
  function loadHistory() {
    var arr = readHistory();
    if (!arr.length) return false;
    arr.forEach(function(entry) {
      var b = document.createElement('div');
      b.className  = 'chatbot-msg ' + entry.type;
      b.innerHTML  = entry.inner;
      messages.appendChild(b);
    });
    messages.scrollTop = messages.scrollHeight;
    return true;
  }
  function clearHistory() {
    try { localStorage.removeItem(HIST_KEY); } catch(e) {}
  }

  /* ── Indicador de escritura ─────────────────────────────── */
  function showTyping() {
    var el = document.createElement('div');
    el.className = 'chatbot-msg bot chatbot-typing';
    el.id = 'cb-typing';
    el.innerHTML = '<span></span><span></span><span></span>';
    messages.appendChild(el);
    messages.scrollTop = messages.scrollHeight;
  }
  function removeTyping() {
    var el = document.getElementById('cb-typing');
    if (el) el.parentNode.removeChild(el);
  }

  /* ── Calificación 👍 / 👎 ───────────────────────────────── */
  function storeRating(intentId, vote) {
    var key = 'ceaa_ratings';
    var arr = [];
    try { arr = JSON.parse(localStorage.getItem(key) || '[]'); } catch(e) {}
    arr.push({ intent: intentId, vote: vote, ts: new Date().toISOString() });
    if (arr.length > 500) arr = arr.slice(-500);
    try { localStorage.setItem(key, JSON.stringify(arr)); } catch(e) {}
  }
  function addRating(intentId) {
    var row = document.createElement('div');
    row.className = 'cb-rating';
    var lbl = document.createElement('span');
    lbl.textContent = '¿Útil?';
    row.appendChild(lbl);
    ['👍', '👎'].forEach(function(icon, idx) {
      var btn = document.createElement('button');
      btn.type = 'button';
      btn.setAttribute('aria-label', idx === 0 ? 'Sí, me fue útil' : 'No, no me fue útil');
      btn.textContent = icon;
      btn.addEventListener('click', function() {
        var vote = idx === 0 ? 1 : 0;
        row.innerHTML = '<span class="cb-rated">' +
          (vote ? '¡Gracias! 😊' : '¡Gracias, mejoraremos! 🙏') + '</span>';
        storeRating(intentId, vote);
        fetch(config.baseUri + '/index.php?controller=chatbot&action=rating', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ intent: intentId, vote: vote, _csrf_token: config.csrfToken || '' })
        }).catch(function() {});
      });
      row.appendChild(btn);
    });
    messages.appendChild(row);
    messages.scrollTop = messages.scrollHeight;
  }

  /* ── Añadir burbuja al chat ─────────────────────────────── */
  function addMessage(type, data) {
    var bubble = document.createElement('div');
    bubble.className = 'chatbot-msg ' + type;

    if (typeof data === 'string') {
      bubble.textContent = data;
    } else {
      var html = '<p>' + data.text + '</p>';
      if (data.steps && data.steps.length) {
        html += '<ol class="cb-steps">';
        data.steps.forEach(function (s) { html += '<li>' + s + '</li>'; });
        html += '</ol>';
      }
      if (data.links && data.links.length) {
        html += '<div class="cb-links">' + data.links.join('') + '</div>';
      }
      bubble.innerHTML = html;
    }

    var ts = document.createElement('span');
    ts.className = 'cb-time';
    ts.textContent = nowTime();
    bubble.appendChild(ts);

    messages.appendChild(bubble);
    pushHistory(type, bubble.innerHTML);
    messages.scrollTop = messages.scrollHeight;
  }

  /* ── Detección de consultas en vivo ─────────────────────
     isEstadoQuery  → el usuario pregunta por estados del inventario
     extractFolio   → el usuario da un folio/clave/nombre de artículo
  ─────────────────────────────────────────────────────────── */
  var ESTADO_ICON  = { bueno: '✅', regular: '⚠️', malo: '❌', baja: '🗑️' };
  var ESTADO_LABEL = { bueno: 'Bueno', regular: 'Regular', malo: 'Malo', baja: 'Baja' };

  function isEstadoQuery(msg) {
    var n = normalize(msg);
    return /estado.*(inventario|articulo|bien|recurso)|inventario.*(estado|condic)|(cuant|lista|ver|resumen).*(buen|regular|mal|baja|condic)|articulos?.*(buen|regular|mal)|(en\s+)?(buen|regular|mal)\s*(estado|condicion)/.test(n);
  }

  function extractFolio(msg) {
    var n = normalize(msg);
    // Explícito: "folio 0003", "clave 0003", "número de inventario 0003", "buscar escritorio"
    var m = n.match(/(?:folio|clave|num(?:ero)?(?:\s*(?:de\s*)?inventario)?|articulo|buscar)\s*[:\-]?\s*([a-z0-9\-_ ]{1,60})/);
    if (m) return m[1].trim();
    // Código corto independiente (parece un folio: alfanumérico, 2-20 chars, no es palabra clave conocida)
    var SKIP = /^(hola|buenas|buenos|hey|manual|reporte|excel|eca|perfil|usuario|error|ayuda|login|salir)$/;
    if (/^[a-z0-9\-_]{2,20}$/.test(n) && !SKIP.test(n)) return n;
    return null;
  }

  /* ── Fetch de datos en vivo ──────────────────────────────── */
  function fetchLiveData(type, param) {
    var endpoint = type === 'estados'
      ? config.baseUri + '/index.php?controller=chatbot&action=inventarioEstados'
      : config.baseUri + '/index.php?controller=chatbot&action=buscarArticulo&q=' + encodeURIComponent(param);

    fetch(endpoint, { credentials: 'same-origin' })
      .then(function (r) { if (!r.ok) throw new Error('HTTP ' + r.status); return r.json(); })
      .then(function (data) {
        removeTyping();
        if (type === 'estados') { renderEstados(data); }
        else                    { renderArticulo(data, param); }
      })
      .catch(function () {
        removeTyping();
        addMessage('bot', {
          text: 'No pude consultar el inventario en este momento. Verifica que el servidor esté activo.',
          steps: null, links: []
        });
        setQuick(pageContext());
      });
  }

  function renderEstados(data) {
    if (!data.ok || !data.estados) {
      addMessage('bot', { text: 'No se pudo obtener el estado del inventario.', steps: null, links: [] });
      setQuick(pageContext());
      return;
    }
    var steps = [];
    ['bueno', 'regular', 'malo', 'baja'].forEach(function (e) {
      if (data.estados[e]) {
        var d = data.estados[e];
        steps.push(
          (ESTADO_ICON[e] || '•') + ' <strong>' + ESTADO_LABEL[e] + '</strong>: ' +
          d.registros + ' reg., ' + d.cantidad + ' pieza(s)'
        );
      }
    });
    steps.push('📦 Total en catálogo: <strong>' + data.total + '</strong> registro(s)');
    addMessage('bot', {
      text: 'Estado actual del inventario:',
      steps: steps,
      links: [lnk('controller=inventario&action=form', 'Abrir inventario', '📋')]
    });
    addRating('inventario_estado');
    setQuick(['¿Qué artículos están en estado malo?', 'Buscar por folio', 'Exportar a Excel', 'Generar reporte PDF']);
  }

  function renderArticulo(data, q) {
    if (!data.ok || !data.articulos || !data.articulos.length) {
      addMessage('bot', {
        text: 'No encontré ningún artículo con la clave o nombre <strong>"' + q + '"</strong>.',
        steps: [
          'Verifica que el folio o nombre sean correctos.',
          'Prueba con el nombre parcial del artículo, por ejemplo: <strong>escritorio</strong>.'
        ],
        links: [lnk('controller=inventario&action=form', 'Abrir inventario', '📋')]
      });
      setQuick(['Ver estado del inventario', 'Exportar a Excel']);
      return;
    }
    var total = data.articulos.length;
    data.articulos.forEach(function (a, i) {
      var rows = [
        '🏷️ Folio / Clave: <strong>' + (a.clave || 'Sin clave') + '</strong>',
        '📦 Artículo: <strong>' + a.nombre + '</strong>'
      ];
      if (a.descripcion) rows.push('📝 ' + a.descripcion);
      if (a.categoria)   rows.push('🗂️ Categoría: ' + a.categoria);
      rows.push((ESTADO_ICON[a.estado_bien] || '•') + ' Estado: <strong>' + (ESTADO_LABEL[a.estado_bien] || a.estado_bien || 'Sin estado') + '</strong>');
      rows.push('🔢 Cantidad: ' + a.cantidad_total + ' total / ' + a.cantidad_disponible + ' disponible(s)');
      if (a.marca && normalize(a.marca) !== 'desconocido') rows.push('🏭 ' + a.marca + (a.modelo ? ' · ' + a.modelo : ''));
      if (a.organismo)  rows.push('🏛️ Organismo: ' + a.organismo);
      if (a.municipio)  rows.push('📍 Municipio: ' + a.municipio);
      if (a.fecha_alta)  rows.push('📅 Alta: ' + a.fecha_alta);
      addMessage('bot', {
        text: total > 1 ? 'Resultado ' + (i + 1) + ' de ' + total + ':' : 'Artículo encontrado:',
        steps: rows,
        links: []
      });
    });
    addRating('buscar_articulo');
    setQuick(['Ver estado del inventario', 'Buscar otro artículo', 'Exportar a Excel']);
  }

  /* ── Motor de respuesta ─────────────────────────────────── */
  function handleMessage(message) {
    var trimmed = (message || '').trim();
    if (!trimmed) return;

    addMessage('user', trimmed);
    input.value = '';
    input.focus();

    // Manual: abre tab externa sin delay
    if (normalize(trimmed).indexOf('manual') !== -1 || normalize(trimmed).indexOf('abrir manual') !== -1) {
      window.open(manualUrl(), '_blank', 'noopener,noreferrer');
      addMessage('bot', { text: 'Abrí el manual técnico en una pestaña nueva. ¿Algo más?', steps: null, links: [] });
      setQuick(pageContext());
      return;
    }

    showTyping();

    // Consulta en vivo: estados del inventario
    if (isEstadoQuery(trimmed)) {
      fetchLiveData('estados', null);
      return;
    }

    // Consulta en vivo: buscar artículo por folio / nombre
    var folio = extractFolio(trimmed);
    if (folio) {
      fetchLiveData('articulo', folio);
      return;
    }

    // Respuesta estática con delay para simular escritura
    setTimeout(function () {
      removeTyping();

      var intent = findIntent(trimmed);
      if (intent) {
        addMessage('bot', intent.resp());
        addRating(intent.id);
        setQuick(intent.followUps && intent.followUps.length ? intent.followUps : pageContext());
      } else {
        addMessage('bot', {
          text: 'No encontré una respuesta exacta a eso. Prueba con alguno de estos temas:',
          steps: null,
          links: []
        });
        setQuick(pageContext());
      }
    }, 600);
  }

  /* ── Abrir / cerrar widget ──────────────────────────────── */
  function openWidget() {
    widget.classList.add('is-open');
    widget.setAttribute('aria-hidden', 'false');
    input.focus();
    if (!hasOpened) {
      hasOpened = true;
      var hadHistory = loadHistory();
      if (hadHistory) {
        // Separador con opción de limpiar
        var sep = document.createElement('div');
        sep.className = 'cb-sep';
        sep.innerHTML =
          '<span>— sesión anterior —</span>' +
          '<button type="button" class="cb-clear-hist">Limpiar</button>';
        sep.querySelector('.cb-clear-hist').addEventListener('click', function() {
          messages.innerHTML = '';
          clearHistory();
          addMessage('bot', {
            text: '¡Historial borrado! ' + greeting() + ', ¿en qué te ayudo?',
            steps: null, links: []
          });
          setQuick(pageContext());
        });
        messages.appendChild(sep);
        setQuick(pageContext());
      } else {
        setTimeout(function () {
          addMessage('bot', {
            text: greeting() + ', ' + config.userName + '. Soy el asistente de soporte CEAA. Pregúntame cualquier duda del sistema.',
            steps: null,
            links: []
          });
          setQuick(pageContext());
        }, 120);
      }
    }
  }

  function closeWidget() {
    widget.classList.remove('is-open');
    widget.setAttribute('aria-hidden', 'true');
  }

  toggleBtn.addEventListener('click', function () {
    widget.classList.contains('is-open') ? closeWidget() : openWidget();
  });
  if (closeBtn) closeBtn.addEventListener('click', closeWidget);

  form.addEventListener('submit', function (e) {
    e.preventDefault();
    handleMessage(input.value);
  });

  /* Inicializar chips sin abrir el widget todavía */
  setQuick(pageContext());

})();
