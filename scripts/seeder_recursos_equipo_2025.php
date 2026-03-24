<?php
/**
 * Seeder: Carga masiva de bienes de equipo 2025
 * Fuente: FormatoparaaltadebienesEQUIPO.csv
 * Programa: E005 Capacitación Ambiental y Desarrollo Sustentable -
 *           Cultura del Agua (Material Didáctico Adquirido - Recurso Federal)
 *
 * INSTRUCCIONES:
 *   Desde terminal: php scripts/seeder_recursos_equipo_2025.php
 *   Desde navegador: http://localhost/ceaa_recursos/scripts/seeder_recursos_equipo_2025.php
 *
 * El script omite registros cuya clave (No. de Inventario) ya exista en la BD.
 */

require_once dirname(__DIR__) . '/config/database.php';

// ─── Valores fijos compartidos por todos los registros ───────────────────────
const TIPO_FUENTE         = 'FEDERAL';
const FUENTE              = 'COMPRA';
const ACCION              = 'Programa E005 Capacitación Ambiental y Desarrollo Sustentable en relación a las acciones de Cultura del Agua (Material Didáctico Adquirido de Cultura del Agua)';
const CONCEPTO            = 'Distribución de Material Didáctico Adquirido de Cultura del Agua 2025 (Recurso Federal)';
const ANIO_FORTALECIMIENTO = 2025;
const FECHA_ALTA          = '2025-01-01';
const ESTADO_BIEN         = 'bueno';
const CATEGORIA_ID        = 2;   // Equipo de cómputo
const UNIDAD_ID           = 4;   // Equipo

// ─── Datos del CSV ────────────────────────────────────────────────────────────
// Formato: [clave, nombre, cantidad, marca, modelo, numero_serie, color, material, beneficiario, costo_unitario]

$datos = [

    // ── Sección 1: Sistema de Proyección Fulldome Fisheye Plus (3 registros) ──
    [
        'clave'          => '364791',
        'nombre'         => 'SISTEMA DE PROYECCIÓN FULLDOME FISHEYE PLUS INCLUYE: PROYECTOR DE 6,000 LUMENES LASER FULL HD-BLU RAY MULTIMEDIA 4K-LENTE FISHEYE',
        'cantidad'       => 1,
        'marca'          => 'PROYECTOR: CHRISTIE / LENTE: COSMOTEC / BLURAY: SONY',
        'modelo'         => 'PROYECTOR: DHD630-GS / LENTE: FISHEYE / BLURAY: N/A',
        'numero_serie'   => 'PROYECTOR: FWH1942002 / LENTE: 243656 / BLURAY: BON562',
        'color'          => 'PROYECTOR: BLANCO / LENTE: NEGRO / BLURAY: N/A',
        'material'       => 'PROYECTOR: PLÁSTICO / LENTE: N/A / BLURAY: N/A',
        'beneficiario'   => 'Comisión Estatal del Agua y Alcantarillado',
        'costo_unitario' => 157528.00,
    ],
    [
        'clave'          => '364792',
        'nombre'         => 'SISTEMA DE PROYECCIÓN FULLDOME FISHEYE PLUS INCLUYE: PROYECTOR DE 6,000 LUMENES LASER FULL HD-BLU RAY MULTIMEDIA 4K-LENTE FISHEYE',
        'cantidad'       => 1,
        'marca'          => 'PROYECTOR: CHRISTIE / LENTE: COSMOTEC / BLURAY: SONY',
        'modelo'         => 'PROYECTOR: DHD630-GS / LENTE: FISHEYE / BLURAY: N/A',
        'numero_serie'   => 'PROYECTOR: FWH1812042 / LENTE: 243657 / BLURAY: BON684 / USB: N/A',
        'color'          => 'PROYECTOR: BLANCO / LENTE: NEGRO / BLURAY: N/A / USB: N/A',
        'material'       => 'PROYECTOR: PLÁSTICO / LENTE: N/A / BLURAY: N/A / USB: N/A',
        'beneficiario'   => 'Comisión Estatal del Agua y Alcantarillado',
        'costo_unitario' => 157528.00,
    ],
    [
        'clave'          => '364793',
        'nombre'         => 'SISTEMA DE PROYECCIÓN FULLDOME FISHEYE PLUS INCLUYE: PROYECTOR DE 6,000 LUMENES LASER FULL HD-BLU RAY MULTIMEDIA 4K-LENTE FISHEYE',
        'cantidad'       => 1,
        'marca'          => 'PROYECTOR: CHRISTIE / LENTE: COSMOTEC / BLURAY: SONY',
        'modelo'         => 'PROYECTOR: DHD630-GS / LENTE: FISHEYE / BLURAY: N/A',
        'numero_serie'   => 'PROYECTOR: SKU 670667 / LENTE: 243658 / BLURAY: BON613',
        'color'          => 'PROYECTOR: BLANCO / LENTE: NEGRO / BLURAY: N/A',
        'material'       => 'PROYECTOR: PLÁSTICO / LENTE: N/A / BLURAY: N/A',
        'beneficiario'   => 'Comisión Nacional del Agua',
        'costo_unitario' => 157528.00,
    ],

    // ── Sección 2: Gafas de Realidad Virtual 3D (42 registros) ───────────────
    [
        'clave'          => 'GAFAS 3D-25-01',
        'nombre'         => 'GAFAS DE REALIDAD VIRTUAL 3D PARA IPHONE SAMSUNG XIAOMI SMARTPHONES FOV 120 GRADOS VR STEREO BOX.',
        'cantidad'       => 1,
        'marca'          => 'Sin Marca',
        'modelo'         => 'Sin modelo',
        'numero_serie'   => 'Sin número de serie',
        'color'          => 'Negro',
        'material'       => 'Plástico',
        'beneficiario'   => 'Presidencia Municipal de Acatlán, Hgo',
        'costo_unitario' => 1506.84,
    ],
    [
        'clave'          => 'GAFAS 3D-25-02',
        'nombre'         => 'GAFAS DE REALIDAD VIRTUAL 3D PARA IPHONE SAMSUNG XIAOMI SMARTPHONES FOV 120 GRADOS VR STEREO BOX.',
        'cantidad'       => 1,
        'marca'          => 'Sin Marca',
        'modelo'         => 'Sin modelo',
        'numero_serie'   => 'Sin número de serie',
        'color'          => 'Negro',
        'material'       => 'Plástico',
        'beneficiario'   => 'Comisión de Agua, Alcantarillado y Saneamiento de Actopan, Hgo',
        'costo_unitario' => 1506.84,
    ],
    [
        'clave'          => 'GAFAS 3D-25-03',
        'nombre'         => 'GAFAS DE REALIDAD VIRTUAL 3D PARA IPHONE SAMSUNG XIAOMI SMARTPHONES FOV 120 GRADOS VR STEREO BOX.',
        'cantidad'       => 1,
        'marca'          => 'Sin Marca',
        'modelo'         => 'Sin modelo',
        'numero_serie'   => 'Sin número de serie',
        'color'          => 'Negro',
        'material'       => 'Plástico',
        'beneficiario'   => 'La Presidencia Municipal de Agua Blanca de Iturbide, Hgo',
        'costo_unitario' => 1506.84,
    ],
    [
        'clave'          => 'GAFAS 3D-25-04',
        'nombre'         => 'GAFAS DE REALIDAD VIRTUAL 3D PARA IPHONE SAMSUNG XIAOMI SMARTPHONES FOV 120 GRADOS VR STEREO BOX.',
        'cantidad'       => 1,
        'marca'          => 'Sin Marca',
        'modelo'         => 'Sin modelo',
        'numero_serie'   => 'Sin número de serie',
        'color'          => 'Negro',
        'material'       => 'Plástico',
        'beneficiario'   => 'Comisión de Agua Potable, Alcantarillado y Saneamiento de Atitalaquia, Hgo',
        'costo_unitario' => 1506.84,
    ],
    [
        'clave'          => 'GAFAS 3D-25-05',
        'nombre'         => 'GAFAS DE REALIDAD VIRTUAL 3D PARA IPHONE SAMSUNG XIAOMI SMARTPHONES FOV 120 GRADOS VR STEREO BOX.',
        'cantidad'       => 1,
        'marca'          => 'Sin Marca',
        'modelo'         => 'Sin modelo',
        'numero_serie'   => 'Sin número de serie',
        'color'          => 'Negro',
        'material'       => 'Plástico',
        'beneficiario'   => 'Presidencia Municipal de Atlapexco',
        'costo_unitario' => 1506.84,
    ],
    [
        'clave'          => 'GAFAS 3D-25-06',
        'nombre'         => 'GAFAS DE REALIDAD VIRTUAL 3D PARA IPHONE SAMSUNG XIAOMI SMARTPHONES FOV 120 GRADOS VR STEREO BOX.',
        'cantidad'       => 1,
        'marca'          => 'Sin Marca',
        'modelo'         => 'Sin modelo',
        'numero_serie'   => 'Sin número de serie',
        'color'          => 'Negro',
        'material'       => 'Plástico',
        'beneficiario'   => 'Presidencia Municipal de Eloxochitlán',
        'costo_unitario' => 1506.84,
    ],
    [
        'clave'          => 'GAFAS 3D-25-07',
        'nombre'         => 'GAFAS DE REALIDAD VIRTUAL 3D PARA IPHONE SAMSUNG XIAOMI SMARTPHONES FOV 120 GRADOS VR STEREO BOX.',
        'cantidad'       => 1,
        'marca'          => 'Sin Marca',
        'modelo'         => 'Sin modelo',
        'numero_serie'   => 'Sin número de serie',
        'color'          => 'Negro',
        'material'       => 'Plástico',
        'beneficiario'   => 'Presidencia Municipal de Epazoyucan',
        'costo_unitario' => 1506.84,
    ],
    [
        'clave'          => 'GAFAS 3D-25-08',
        'nombre'         => 'GAFAS DE REALIDAD VIRTUAL 3D PARA IPHONE SAMSUNG XIAOMI SMARTPHONES FOV 120 GRADOS VR STEREO BOX.',
        'cantidad'       => 1,
        'marca'          => 'Sin Marca',
        'modelo'         => 'Sin modelo',
        'numero_serie'   => 'Sin número de serie',
        'color'          => 'Negro',
        'material'       => 'Plástico',
        'beneficiario'   => 'Comisión de Agua del Municipio de Huasca, Hgo.',
        'costo_unitario' => 1506.84,
    ],
    [
        'clave'          => 'GAFAS 3D-25-09',
        'nombre'         => 'GAFAS DE REALIDAD VIRTUAL 3D PARA IPHONE SAMSUNG XIAOMI SMARTPHONES FOV 120 GRADOS VR STEREO BOX.',
        'cantidad'       => 1,
        'marca'          => 'Sin Marca',
        'modelo'         => 'Sin modelo',
        'numero_serie'   => 'Sin número de serie',
        'color'          => 'Negro',
        'material'       => 'Plástico',
        'beneficiario'   => 'Presidencia Municipal de Huazalingo',
        'costo_unitario' => 1506.84,
    ],
    [
        'clave'          => 'GAFAS 3D-25-10',
        'nombre'         => 'GAFAS DE REALIDAD VIRTUAL 3D PARA IPHONE SAMSUNG XIAOMI SMARTPHONES FOV 120 GRADOS VR STEREO BOX.',
        'cantidad'       => 1,
        'marca'          => 'Sin Marca',
        'modelo'         => 'Sin modelo',
        'numero_serie'   => 'Sin número de serie',
        'color'          => 'Negro',
        'material'       => 'Plástico',
        'beneficiario'   => 'Presidencia Municipal de Huehuetla',
        'costo_unitario' => 1506.84,
    ],
    [
        'clave'          => 'GAFAS 3D-25-11',
        'nombre'         => 'GAFAS DE REALIDAD VIRTUAL 3D PARA IPHONE SAMSUNG XIAOMI SMARTPHONES FOV 120 GRADOS VR STEREO BOX.',
        'cantidad'       => 1,
        'marca'          => 'Sin Marca',
        'modelo'         => 'Sin modelo',
        'numero_serie'   => 'Sin número de serie',
        'color'          => 'Negro',
        'material'       => 'Plástico',
        'beneficiario'   => 'Comisión de Agua Potable, Alcantarillado y Saneamiento de Huejutla, Hgo.',
        'costo_unitario' => 1506.84,
    ],
    [
        'clave'          => 'GAFAS 3D-25-12',
        'nombre'         => 'GAFAS DE REALIDAD VIRTUAL 3D PARA IPHONE SAMSUNG XIAOMI SMARTPHONES FOV 120 GRADOS VR STEREO BOX.',
        'cantidad'       => 1,
        'marca'          => 'Sin Marca',
        'modelo'         => 'Sin modelo',
        'numero_serie'   => 'Sin número de serie',
        'color'          => 'Negro',
        'material'       => 'Plástico',
        'beneficiario'   => 'Huejutla de Reyes (Universidad Politécnica de Huejutla)',
        'costo_unitario' => 1506.84,
    ],
    [
        'clave'          => 'GAFAS 3D-25-13',
        'nombre'         => 'GAFAS DE REALIDAD VIRTUAL 3D PARA IPHONE SAMSUNG XIAOMI SMARTPHONES FOV 120 GRADOS VR STEREO BOX.',
        'cantidad'       => 1,
        'marca'          => 'Sin Marca',
        'modelo'         => 'Sin modelo',
        'numero_serie'   => 'Sin número de serie',
        'color'          => 'Negro',
        'material'       => 'Plástico',
        'beneficiario'   => 'Presidencia Municipal de Juárez Hidalgo',
        'costo_unitario' => 1506.84,
    ],
    [
        'clave'          => 'GAFAS 3D-25-14',
        'nombre'         => 'GAFAS DE REALIDAD VIRTUAL 3D PARA IPHONE SAMSUNG XIAOMI SMARTPHONES FOV 120 GRADOS VR STEREO BOX.',
        'cantidad'       => 1,
        'marca'          => 'Sin Marca',
        'modelo'         => 'Sin modelo',
        'numero_serie'   => 'Sin número de serie',
        'color'          => 'Negro',
        'material'       => 'Plástico',
        'beneficiario'   => 'Presidencia Municipal de La Misión',
        'costo_unitario' => 1506.84,
    ],
    [
        'clave'          => 'GAFAS 3D-25-15',
        'nombre'         => 'GAFAS DE REALIDAD VIRTUAL 3D PARA IPHONE SAMSUNG XIAOMI SMARTPHONES FOV 120 GRADOS VR STEREO BOX.',
        'cantidad'       => 1,
        'marca'          => 'Sin Marca',
        'modelo'         => 'Sin modelo',
        'numero_serie'   => 'Sin número de serie',
        'color'          => 'Negro',
        'material'       => 'Plástico',
        'beneficiario'   => 'Presidencia Municipal de Lolotla',
        'costo_unitario' => 1506.84,
    ],
    [
        'clave'          => 'GAFAS 3D-25-16',
        'nombre'         => 'GAFAS DE REALIDAD VIRTUAL 3D PARA IPHONE SAMSUNG XIAOMI SMARTPHONES FOV 120 GRADOS VR STEREO BOX.',
        'cantidad'       => 1,
        'marca'          => 'Sin Marca',
        'modelo'         => 'Sin modelo',
        'numero_serie'   => 'Sin número de serie',
        'color'          => 'Negro',
        'material'       => 'Plástico',
        'beneficiario'   => 'Presidencia Municipal de Metepec',
        'costo_unitario' => 1506.84,
    ],
    [
        'clave'          => 'GAFAS 3D-25-17',
        'nombre'         => 'GAFAS DE REALIDAD VIRTUAL 3D PARA IPHONE SAMSUNG XIAOMI SMARTPHONES FOV 120 GRADOS VR STEREO BOX.',
        'cantidad'       => 1,
        'marca'          => 'Sin Marca',
        'modelo'         => 'Sin modelo',
        'numero_serie'   => 'Sin número de serie',
        'color'          => 'Negro',
        'material'       => 'Plástico',
        'beneficiario'   => 'Presidencia Municipal de Mineral del Monte',
        'costo_unitario' => 1506.84,
    ],
    [
        'clave'          => 'GAFAS 3D-25-18',
        'nombre'         => 'GAFAS DE REALIDAD VIRTUAL 3D PARA IPHONE SAMSUNG XIAOMI SMARTPHONES FOV 120 GRADOS VR STEREO BOX.',
        'cantidad'       => 1,
        'marca'          => 'Sin Marca',
        'modelo'         => 'Sin modelo',
        'numero_serie'   => 'Sin número de serie',
        'color'          => 'Negro',
        'material'       => 'Plástico',
        'beneficiario'   => 'Comisión de Agua y Alcantarillado del Municipio de Mixquiahuala de Juárez, Hgo',
        'costo_unitario' => 1506.84,
    ],
    [
        'clave'          => 'GAFAS 3D-25-19',
        'nombre'         => 'GAFAS DE REALIDAD VIRTUAL 3D PARA IPHONE SAMSUNG XIAOMI SMARTPHONES FOV 120 GRADOS VR STEREO BOX.',
        'cantidad'       => 1,
        'marca'          => 'Sin Marca',
        'modelo'         => 'Sin modelo',
        'numero_serie'   => 'Sin número de serie',
        'color'          => 'Negro',
        'material'       => 'Plástico',
        'beneficiario'   => 'Presidencia Municipal de Molango de Escamilla',
        'costo_unitario' => 1506.84,
    ],
    [
        'clave'          => 'GAFAS 3D-25-20',
        'nombre'         => 'GAFAS DE REALIDAD VIRTUAL 3D PARA IPHONE SAMSUNG XIAOMI SMARTPHONES FOV 120 GRADOS VR STEREO BOX.',
        'cantidad'       => 1,
        'marca'          => 'Sin Marca',
        'modelo'         => 'Sin modelo',
        'numero_serie'   => 'Sin número de serie',
        'color'          => 'Negro',
        'material'       => 'Plástico',
        'beneficiario'   => 'Presidencia Municipal de Nicolás Flores',
        'costo_unitario' => 1506.84,
    ],
    [
        'clave'          => 'GAFAS 3D-25-21',
        'nombre'         => 'GAFAS DE REALIDAD VIRTUAL 3D PARA IPHONE SAMSUNG XIAOMI SMARTPHONES FOV 120 GRADOS VR STEREO BOX.',
        'cantidad'       => 1,
        'marca'          => 'Sin Marca',
        'modelo'         => 'Sin modelo',
        'numero_serie'   => 'Sin número de serie',
        'color'          => 'Negro',
        'material'       => 'Plástico',
        'beneficiario'   => 'Zempoala Acueducto del Padre Tembleque',
        'costo_unitario' => 1506.84,
    ],
    [
        'clave'          => 'GAFAS 3D-25-22',
        'nombre'         => 'GAFAS DE REALIDAD VIRTUAL 3D PARA IPHONE SAMSUNG XIAOMI SMARTPHONES FOV 120 GRADOS VR STEREO BOX.',
        'cantidad'       => 1,
        'marca'          => 'Sin Marca',
        'modelo'         => 'Sin modelo',
        'numero_serie'   => 'Sin número de serie',
        'color'          => 'Negro',
        'material'       => 'Plástico',
        'beneficiario'   => 'Presidencia Municipal de Pisaflores',
        'costo_unitario' => 1506.84,
    ],
    [
        'clave'          => 'GAFAS 3D-25-23',
        'nombre'         => 'GAFAS DE REALIDAD VIRTUAL 3D PARA IPHONE SAMSUNG XIAOMI SMARTPHONES FOV 120 GRADOS VR STEREO BOX.',
        'cantidad'       => 1,
        'marca'          => 'Sin Marca',
        'modelo'         => 'Sin modelo',
        'numero_serie'   => 'Sin número de serie',
        'color'          => 'Negro',
        'material'       => 'Plástico',
        'beneficiario'   => 'Comisión de Agua y Alcantarillado del Municipio de Progreso de Obregón, Hgo.',
        'costo_unitario' => 1506.84,
    ],
    [
        'clave'          => 'GAFAS 3D-25-24',
        'nombre'         => 'GAFAS DE REALIDAD VIRTUAL 3D PARA IPHONE SAMSUNG XIAOMI SMARTPHONES FOV 120 GRADOS VR STEREO BOX.',
        'cantidad'       => 1,
        'marca'          => 'Sin Marca',
        'modelo'         => 'Sin modelo',
        'numero_serie'   => 'Sin número de serie',
        'color'          => 'Negro',
        'material'       => 'Plástico',
        'beneficiario'   => 'Presidencia Municipal de San Bartolo Tutotepec',
        'costo_unitario' => 1506.84,
    ],
    [
        'clave'          => 'GAFAS 3D-25-25',
        'nombre'         => 'GAFAS DE REALIDAD VIRTUAL 3D PARA IPHONE SAMSUNG XIAOMI SMARTPHONES FOV 120 GRADOS VR STEREO BOX.',
        'cantidad'       => 1,
        'marca'          => 'Sin Marca',
        'modelo'         => 'Sin modelo',
        'numero_serie'   => 'Sin número de serie',
        'color'          => 'Negro',
        'material'       => 'Plástico',
        'beneficiario'   => 'Presidencia Municipal de San Felipe Orizatlán',
        'costo_unitario' => 1506.84,
    ],
    [
        'clave'          => 'GAFAS 3D-25-26',
        'nombre'         => 'GAFAS DE REALIDAD VIRTUAL 3D PARA IPHONE SAMSUNG XIAOMI SMARTPHONES FOV 120 GRADOS VR STEREO BOX.',
        'cantidad'       => 1,
        'marca'          => 'Sin Marca',
        'modelo'         => 'Sin modelo',
        'numero_serie'   => 'Sin número de serie',
        'color'          => 'Negro',
        'material'       => 'Plástico',
        'beneficiario'   => 'Comisión de Agua Potable, Alcantarillado y Saneamiento de Santiago de Anaya, Hgo',
        'costo_unitario' => 1506.84,
    ],
    [
        'clave'          => 'GAFAS 3D-25-27',
        'nombre'         => 'GAFAS DE REALIDAD VIRTUAL 3D PARA IPHONE SAMSUNG XIAOMI SMARTPHONES FOV 120 GRADOS VR STEREO BOX.',
        'cantidad'       => 1,
        'marca'          => 'Sin Marca',
        'modelo'         => 'Sin modelo',
        'numero_serie'   => 'Sin número de serie',
        'color'          => 'Negro',
        'material'       => 'Plástico',
        'beneficiario'   => 'Comisión de Agua, Alcantarillado y Saneamiento de Santiago Tulantepec de Lugo Guerrero, Hgo',
        'costo_unitario' => 1506.84,
    ],
    [
        'clave'          => 'GAFAS 3D-25-28',
        'nombre'         => 'GAFAS DE REALIDAD VIRTUAL 3D PARA IPHONE SAMSUNG XIAOMI SMARTPHONES FOV 120 GRADOS VR STEREO BOX.',
        'cantidad'       => 1,
        'marca'          => 'Sin Marca',
        'modelo'         => 'Sin modelo',
        'numero_serie'   => 'Sin número de serie',
        'color'          => 'Negro',
        'material'       => 'Plástico',
        'beneficiario'   => 'Presidencia Municipal de Singuilucan',
        'costo_unitario' => 1506.84,
    ],
    [
        'clave'          => 'GAFAS 3D-25-29',
        'nombre'         => 'GAFAS DE REALIDAD VIRTUAL 3D PARA IPHONE SAMSUNG XIAOMI SMARTPHONES FOV 120 GRADOS VR STEREO BOX.',
        'cantidad'       => 1,
        'marca'          => 'Sin Marca',
        'modelo'         => 'Sin modelo',
        'numero_serie'   => 'Sin número de serie',
        'color'          => 'Negro',
        'material'       => 'Plástico',
        'beneficiario'   => 'Presidencia Municipal de Tasquillo',
        'costo_unitario' => 1506.84,
    ],
    [
        'clave'          => 'GAFAS 3D-25-30',
        'nombre'         => 'GAFAS DE REALIDAD VIRTUAL 3D PARA IPHONE SAMSUNG XIAOMI SMARTPHONES FOV 120 GRADOS VR STEREO BOX.',
        'cantidad'       => 1,
        'marca'          => 'Sin Marca',
        'modelo'         => 'Sin modelo',
        'numero_serie'   => 'Sin número de serie',
        'color'          => 'Negro',
        'material'       => 'Plástico',
        'beneficiario'   => 'Presidencia Municipal de Tenango de Doria',
        'costo_unitario' => 1506.84,
    ],
    [
        'clave'          => 'GAFAS 3D-25-31',
        'nombre'         => 'GAFAS DE REALIDAD VIRTUAL 3D PARA IPHONE SAMSUNG XIAOMI SMARTPHONES FOV 120 GRADOS VR STEREO BOX.',
        'cantidad'       => 1,
        'marca'          => 'Sin Marca',
        'modelo'         => 'Sin modelo',
        'numero_serie'   => 'Sin número de serie',
        'color'          => 'Negro',
        'material'       => 'Plástico',
        'beneficiario'   => 'Presidencia Municipal de Tepeapulco',
        'costo_unitario' => 1506.84,
    ],
    [
        'clave'          => 'GAFAS 3D-25-32',
        'nombre'         => 'GAFAS DE REALIDAD VIRTUAL 3D PARA IPHONE SAMSUNG XIAOMI SMARTPHONES FOV 120 GRADOS VR STEREO BOX.',
        'cantidad'       => 1,
        'marca'          => 'Sin Marca',
        'modelo'         => 'Sin modelo',
        'numero_serie'   => 'Sin número de serie',
        'color'          => 'Negro',
        'material'       => 'Plástico',
        'beneficiario'   => 'Comisión de Agua y Alcantarillado del Municipio de Tepeji del Río Ocampo, Hgo',
        'costo_unitario' => 1506.84,
    ],
    [
        'clave'          => 'GAFAS 3D-25-33',
        'nombre'         => 'GAFAS DE REALIDAD VIRTUAL 3D PARA IPHONE SAMSUNG XIAOMI SMARTPHONES FOV 120 GRADOS VR STEREO BOX.',
        'cantidad'       => 1,
        'marca'          => 'Sin Marca',
        'modelo'         => 'Sin modelo',
        'numero_serie'   => 'Sin número de serie',
        'color'          => 'Negro',
        'material'       => 'Plástico',
        'beneficiario'   => 'Presidencia Municipal de Tianguistengo',
        'costo_unitario' => 1506.84,
    ],
    [
        'clave'          => 'GAFAS 3D-25-34',
        'nombre'         => 'GAFAS DE REALIDAD VIRTUAL 3D PARA IPHONE SAMSUNG XIAOMI SMARTPHONES FOV 120 GRADOS VR STEREO BOX.',
        'cantidad'       => 1,
        'marca'          => 'Sin Marca',
        'modelo'         => 'Sin modelo',
        'numero_serie'   => 'Sin número de serie',
        'color'          => 'Negro',
        'material'       => 'Plástico',
        'beneficiario'   => 'Comisión de Agua y Alcantarillado del Municipio de Tizayuca, Hgo',
        'costo_unitario' => 1506.84,
    ],
    [
        'clave'          => 'GAFAS 3D-25-35',
        'nombre'         => 'GAFAS DE REALIDAD VIRTUAL 3D PARA IPHONE SAMSUNG XIAOMI SMARTPHONES FOV 120 GRADOS VR STEREO BOX.',
        'cantidad'       => 1,
        'marca'          => 'Sin Marca',
        'modelo'         => 'Sin modelo',
        'numero_serie'   => 'Sin número de serie',
        'color'          => 'Negro',
        'material'       => 'Plástico',
        'beneficiario'   => 'Presidencia Municipal de Tlanalapa',
        'costo_unitario' => 1506.84,
    ],
    [
        'clave'          => 'GAFAS 3D-25-36',
        'nombre'         => 'GAFAS DE REALIDAD VIRTUAL 3D PARA IPHONE SAMSUNG XIAOMI SMARTPHONES FOV 120 GRADOS VR STEREO BOX.',
        'cantidad'       => 1,
        'marca'          => 'Sin Marca',
        'modelo'         => 'Sin modelo',
        'numero_serie'   => 'Sin número de serie',
        'color'          => 'Negro',
        'material'       => 'Plástico',
        'beneficiario'   => 'Presidencia Municipal de Tlanchinol',
        'costo_unitario' => 1506.84,
    ],
    [
        'clave'          => 'GAFAS 3D-25-37',
        'nombre'         => 'GAFAS DE REALIDAD VIRTUAL 3D PARA IPHONE SAMSUNG XIAOMI SMARTPHONES FOV 120 GRADOS VR STEREO BOX.',
        'cantidad'       => 1,
        'marca'          => 'Sin Marca',
        'modelo'         => 'Sin modelo',
        'numero_serie'   => 'Sin número de serie',
        'color'          => 'Negro',
        'material'       => 'Plástico',
        'beneficiario'   => 'Presidencia Municipal de Tolcayuca',
        'costo_unitario' => 1506.84,
    ],
    [
        'clave'          => 'GAFAS 3D-25-38',
        'nombre'         => 'GAFAS DE REALIDAD VIRTUAL 3D PARA IPHONE SAMSUNG XIAOMI SMARTPHONES FOV 120 GRADOS VR STEREO BOX.',
        'cantidad'       => 1,
        'marca'          => 'Sin Marca',
        'modelo'         => 'Sin modelo',
        'numero_serie'   => 'Sin número de serie',
        'color'          => 'Negro',
        'material'       => 'Plástico',
        'beneficiario'   => 'Presidencia Municipal de Tulancingo de Bravo',
        'costo_unitario' => 1506.84,
    ],
    [
        'clave'          => 'GAFAS 3D-25-39',
        'nombre'         => 'GAFAS DE REALIDAD VIRTUAL 3D PARA IPHONE SAMSUNG XIAOMI SMARTPHONES FOV 120 GRADOS VR STEREO BOX.',
        'cantidad'       => 1,
        'marca'          => 'Sin Marca',
        'modelo'         => 'Sin modelo',
        'numero_serie'   => 'Sin número de serie',
        'color'          => 'Negro',
        'material'       => 'Plástico',
        'beneficiario'   => 'Presidencia Municipal de Xochiatipan',
        'costo_unitario' => 1506.84,
    ],
    [
        'clave'          => 'GAFAS 3D-25-40',
        'nombre'         => 'GAFAS DE REALIDAD VIRTUAL 3D PARA IPHONE SAMSUNG XIAOMI SMARTPHONES FOV 120 GRADOS VR STEREO BOX.',
        'cantidad'       => 1,
        'marca'          => 'Sin Marca',
        'modelo'         => 'Sin modelo',
        'numero_serie'   => 'Sin número de serie',
        'color'          => 'Negro',
        'material'       => 'Plástico',
        'beneficiario'   => 'Presidencia Municipal de Yahualica',
        'costo_unitario' => 1506.84,
    ],
    [
        'clave'          => 'GAFAS 3D-25-41',
        'nombre'         => 'GAFAS DE REALIDAD VIRTUAL 3D PARA IPHONE SAMSUNG XIAOMI SMARTPHONES FOV 120 GRADOS VR STEREO BOX.',
        'cantidad'       => 1,
        'marca'          => 'Sin Marca',
        'modelo'         => 'Sin modelo',
        'numero_serie'   => 'Sin número de serie',
        'color'          => 'Negro',
        'material'       => 'Plástico',
        'beneficiario'   => 'Presidencia Municipal de Zapotlán de Juárez',
        'costo_unitario' => 1506.84,
    ],
    [
        'clave'          => 'GAFAS 3D-25-42',
        'nombre'         => 'GAFAS DE REALIDAD VIRTUAL 3D PARA IPHONE SAMSUNG XIAOMI SMARTPHONES FOV 120 GRADOS VR STEREO BOX.',
        'cantidad'       => 1,
        'marca'          => 'Sin Marca',
        'modelo'         => 'Sin modelo',
        'numero_serie'   => 'Sin número de serie',
        'color'          => 'Negro',
        'material'       => 'Plástico',
        'beneficiario'   => 'Presidencia Municipal de Zempoala',
        'costo_unitario' => 1506.84,
    ],
];

// ─── Ejecución del seeder ─────────────────────────────────────────────────────

$esWeb = php_sapi_name() !== 'cli';
$nl    = $esWeb ? "<br>\n" : "\n";

if ($esWeb) {
    echo "<!DOCTYPE html><html lang='es'><head><meta charset='UTF-8'>
          <title>Seeder Recursos Equipo 2025</title>
          <style>body{font-family:monospace;padding:20px}
          .ok{color:#16a34a}.skip{color:#ca8a04}.err{color:#dc2626}
          .resumen{background:#f1f5f9;padding:12px;margin-top:16px;border-radius:6px}</style>
          </head><body>";
    echo "<h2>Seeder: Recursos Equipo 2025</h2>\n";
}

echo "=== SEEDER RECURSOS EQUIPO 2025 ==={$nl}{$nl}";

try {
    $pdo = DB::conn();

    $sql = "INSERT INTO recursos
                (clave, nombre, categoria_id, unidad_id,
                 tipo_fuente, fuente, costo_unitario,
                 cantidad_total, cantidad_disponible,
                 estado_bien, fecha_alta,
                 accion, concepto, anio_fortalecimiento,
                 marca, modelo, numero_serie,
                 color, material, beneficiario)
            VALUES
                (:clave, :nombre, :categoria_id, :unidad_id,
                 :tipo_fuente, :fuente, :costo_unitario,
                 :cantidad_total, :cantidad_disponible,
                 :estado_bien, :fecha_alta,
                 :accion, :concepto, :anio_fortalecimiento,
                 :marca, :modelo, :numero_serie,
                 :color, :material, :beneficiario)";

    $stmtCheck  = $pdo->prepare("SELECT id FROM recursos WHERE clave = :clave LIMIT 1");
    $stmtInsert = $pdo->prepare($sql);

    $insertados = 0;
    $omitidos   = 0;
    $errores    = 0;

    $pdo->beginTransaction();

    foreach ($datos as $fila) {
        // Verificar si ya existe el mismo No. de Inventario (clave)
        $stmtCheck->execute([':clave' => $fila['clave']]);
        if ($stmtCheck->fetch()) {
            $msg = "OMITIDO  | Clave '{$fila['clave']}' ya existe en la BD";
            echo $esWeb ? "<span class='skip'>{$msg}</span>{$nl}" : "{$msg}{$nl}";
            $omitidos++;
            continue;
        }

        $stmtInsert->execute([
            ':clave'               => $fila['clave'],
            ':nombre'              => $fila['nombre'],
            ':categoria_id'        => CATEGORIA_ID,
            ':unidad_id'           => UNIDAD_ID,
            ':tipo_fuente'         => TIPO_FUENTE,
            ':fuente'              => FUENTE,
            ':costo_unitario'      => $fila['costo_unitario'],
            ':cantidad_total'      => $fila['cantidad'],
            ':cantidad_disponible' => $fila['cantidad'],
            ':estado_bien'         => ESTADO_BIEN,
            ':fecha_alta'          => FECHA_ALTA,
            ':accion'              => ACCION,
            ':concepto'            => CONCEPTO,
            ':anio_fortalecimiento'=> ANIO_FORTALECIMIENTO,
            ':marca'               => $fila['marca'],
            ':modelo'              => $fila['modelo'],
            ':numero_serie'        => $fila['numero_serie'],
            ':color'               => $fila['color'],
            ':material'            => $fila['material'],
            ':beneficiario'        => $fila['beneficiario'],
        ]);

        $msg = "INSERTADO| Clave '{$fila['clave']}' - {$fila['beneficiario']}";
        echo $esWeb ? "<span class='ok'>{$msg}</span>{$nl}" : "{$msg}{$nl}";
        $insertados++;
    }

    $pdo->commit();

} catch (Exception $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    $errores++;
    $msg = "ERROR FATAL: " . $e->getMessage();
    echo $esWeb ? "<span class='err'>{$msg}</span>{$nl}" : "{$msg}{$nl}";
}

// ─── Resumen final ────────────────────────────────────────────────────────────
$total = count($datos);
echo $nl;
echo $esWeb ? "<div class='resumen'>" : "─────────────────────────────{$nl}";
echo "RESUMEN{$nl}";
echo "  Total en CSV : {$total}{$nl}";
echo "  Insertados   : {$insertados}{$nl}";
echo "  Omitidos     : {$omitidos}  (clave ya existente){$nl}";
echo "  Errores      : {$errores}{$nl}";
echo $esWeb ? "</div></body></html>" : "";
