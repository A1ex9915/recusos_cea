<!-- Estilos internos mejorados y responsivos -->
<style>
  /* ===============================
     FONDO MINIMALISTA
  ================================*/
  .hero {
      width: 100%;
      min-height: calc(100vh - 80px); /* Ajuste por navbar fijo */
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      padding: 20px;

      background-image: url("https://idcontrol.com.mx/cetis10/imagenes/fondoaguiladoble.png");
      background-size: contain;   /* Mejor en móvil */
      background-repeat: no-repeat;
      background-position: center;
  }

  .hero-content {
      max-width: 800px;
      margin: 0 auto;
  }

  /* ===============================
     TIPOGRAFÍA LIMPIA
  ================================*/
  .titulo,
  .rol,
  .descripcion {
      font-family: "Segoe UI", system-ui, -apple-system, BlinkMacSystemFont, "Roboto", sans-serif;
      color: #7A0010;
  }

  .titulo {
      font-size: clamp(2.2rem, 6vw, 4.5rem); /* 🔥 RESPONSIVO */
      font-weight: 700;
      letter-spacing: 2px;
      margin-bottom: 10px;
      animation: fadeIn 1.3s ease;
      text-shadow: 0 2px 4px rgba(0,0,0,.15);
  }

  .rol {
      font-size: clamp(1.2rem, 3vw, 1.8rem);
      font-weight: 600;
      margin-bottom: 8px;
      animation: fadeIn 1.6s ease;
  }

  .descripcion {
      font-size: clamp(0.95rem, 2.5vw, 1.3rem);
      font-weight: 400;
      letter-spacing: .5px;
      animation: fadeIn 1.9s ease;
      padding: 0 10px;
  }

  /* ===============================
   ESTILO PARA EL <strong> DEL NOMBRE
================================*/
strong.rol {
    display: inline-block;
    margin-top: 4px;
    font-size: clamp(1.3rem, 3.2vw, 2rem);
    font-weight: 700;            /* Negrita controlada */
    color: #7A0010;              /* Misma paleta */
    letter-spacing: 1px;
    text-shadow: 0 1px 3px rgba(0,0,0,.15); /* Sutil, elegante */
    animation: fadeIn 2.1s ease; /* Entra después del “Administrador” */
}

  /* ===============================
     ANIMACIÓN SUAVE
  ================================*/
  @keyframes fadeIn {
      from { opacity: 0; transform: translateY(15px); }
      to   { opacity: 1; transform: translateY(0); }
  }

  /* ===============================
     OPTIMIZACIÓN PARA MÓVIL
  ================================*/
  @media (max-width: 480px) {
      .hero {
          background-size: cover;     /* imagen más grande */
          background-position: top;
          padding-top: 40px;
      }

      .hero-content {
          margin-top: 40px;
      }
  }
</style>

<section class="hero">
    <div class="hero-content">
        <h1 class="titulo">Bienvenid@</h1>
        <p class="rol">Administrador</p>
<strong class="rol"><?= htmlspecialchars($usuario['nombre']) ?></strong>

        <p class="descripcion">Sistema de inventario y reportes de la CEAA</p>
    </div>
</section>