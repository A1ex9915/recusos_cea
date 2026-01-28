-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-01-2026 a las 21:58:20
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sistema_ceaa`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `capturas_formato`
--

CREATE TABLE `capturas_formato` (
  `id` int(11) NOT NULL,
  `formato_id` int(11) NOT NULL,
  `organismo_id` int(11) DEFAULT NULL,
  `municipio_id` int(11) DEFAULT NULL,
  `campos` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`campos`)),
  `creado_por` int(11) DEFAULT NULL,
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`) VALUES
(2, 'Equipo de cómputo'),
(4, 'Herramientas'),
(1, 'Mobiliario'),
(5, 'Otros'),
(3, 'Vehículo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eca_fichas`
--

CREATE TABLE `eca_fichas` (
  `id` int(11) NOT NULL,
  `municipio_id` int(11) NOT NULL,
  `organismo_id` int(11) NOT NULL,
  `estado_eca` varchar(255) DEFAULT NULL,
  `clave_eca` varchar(255) DEFAULT NULL,
  `fecha_apertura` date DEFAULT NULL,
  `nombre_reca` varchar(255) DEFAULT NULL,
  `correo_reca` varchar(255) DEFAULT NULL,
  `telefono` varchar(255) DEFAULT NULL,
  `horario_atencion` varchar(255) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `codigo_postal` varchar(20) DEFAULT NULL,
  `habitantes` int(11) DEFAULT NULL,
  `poblacion_atendida` varchar(255) DEFAULT NULL,
  `mobiliario_equipo` text DEFAULT NULL,
  `equipo_computo` text DEFAULT NULL,
  `material_didactico` text DEFAULT NULL,
  `fecha_ultimo_fortalecimiento` date DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `poa_enero` varchar(10) DEFAULT NULL,
  `poa_febrero` varchar(10) DEFAULT NULL,
  `poa_marzo` varchar(10) DEFAULT NULL,
  `poa_abril` varchar(10) DEFAULT NULL,
  `poa_mayo` varchar(10) DEFAULT NULL,
  `poa_junio` varchar(10) DEFAULT NULL,
  `poa_julio` varchar(10) DEFAULT NULL,
  `poa_agosto` varchar(10) DEFAULT NULL,
  `poa_septiembre` varchar(10) DEFAULT NULL,
  `poa_octubre` varchar(10) DEFAULT NULL,
  `poa_noviembre` varchar(10) DEFAULT NULL,
  `poa_diciembre` varchar(10) DEFAULT NULL,
  `poa_enero_sig` varchar(10) DEFAULT NULL,
  `diagnostico` varchar(255) DEFAULT NULL,
  `calidad_ortografia` varchar(10) DEFAULT NULL,
  `calidad_totales` varchar(10) DEFAULT NULL,
  `calidad_escaneado` varchar(10) DEFAULT NULL,
  `calidad_encabezado` varchar(10) DEFAULT NULL,
  `calidad_redaccion` varchar(10) DEFAULT NULL,
  `calidad_actividades` varchar(10) DEFAULT NULL,
  `acciones_2023` text DEFAULT NULL,
  `asistencia_reca_2023` text DEFAULT NULL,
  `fortalecimiento_2023` text DEFAULT NULL,
  `acciones_2024` text DEFAULT NULL,
  `asistencia_reca_2024` text DEFAULT NULL,
  `propuesta_2024_mobiliario` text DEFAULT NULL,
  `propuesta_2024_material` text DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `fecha_captura` timestamp NOT NULL DEFAULT current_timestamp(),
  `municipio_texto` varchar(255) DEFAULT NULL,
  `tipo_instancia_operativa` varchar(255) DEFAULT NULL,
  `nombre_instancia_operativa` varchar(255) DEFAULT NULL,
  `numero_direccion` varchar(50) DEFAULT NULL,
  `colonia` varchar(150) DEFAULT NULL,
  `localidad` varchar(150) DEFAULT NULL,
  `cap_cultura_pago_desc` text DEFAULT NULL,
  `cap_cultura_pago_asis` varchar(10) DEFAULT NULL,
  `caravana_estiaje_desc` text DEFAULT NULL,
  `caravana_estiaje_asis` varchar(10) DEFAULT NULL,
  `caravana_lluvias_desc` text DEFAULT NULL,
  `caravana_lluvias_asis` varchar(10) DEFAULT NULL,
  `curso_teatro_desc` text DEFAULT NULL,
  `curso_teatro_asis` varchar(10) DEFAULT NULL,
  `platicas_domo_desc` text DEFAULT NULL,
  `platicas_domo_asis` varchar(10) DEFAULT NULL,
  `convencion_aneas_desc` text DEFAULT NULL,
  `convencion_aneas_asis` varchar(10) DEFAULT NULL,
  `fort_2023_mobiliario` varchar(255) DEFAULT NULL,
  `fort_2023_material` varchar(255) DEFAULT NULL,
  `fort_2023_desc` varchar(300) DEFAULT NULL,
  `encuentro_hidrico_desc` text DEFAULT NULL,
  `encuentro_hidrico_asis` varchar(10) DEFAULT NULL,
  `platicas_2024_desc` text DEFAULT NULL,
  `platicas_2024_asis` varchar(10) DEFAULT NULL,
  `caravana_virtual_desc` text DEFAULT NULL,
  `caravana_virtual_asis` varchar(10) DEFAULT NULL,
  `diagnostico_municipal_desc` text DEFAULT NULL,
  `diagnostico_municipal_asis` varchar(10) DEFAULT NULL,
  `prop_2024_mobiliario` varchar(255) DEFAULT NULL,
  `prop_2024_material` varchar(255) DEFAULT NULL,
  `prop_2024_desc` varchar(255) DEFAULT NULL,
  `diagnostico_general` text DEFAULT NULL,
  `observaciones_generales` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `eca_fichas`
--

INSERT INTO `eca_fichas` (`id`, `municipio_id`, `organismo_id`, `estado_eca`, `clave_eca`, `fecha_apertura`, `nombre_reca`, `correo_reca`, `telefono`, `horario_atencion`, `direccion`, `codigo_postal`, `habitantes`, `poblacion_atendida`, `mobiliario_equipo`, `equipo_computo`, `material_didactico`, `fecha_ultimo_fortalecimiento`, `observaciones`, `poa_enero`, `poa_febrero`, `poa_marzo`, `poa_abril`, `poa_mayo`, `poa_junio`, `poa_julio`, `poa_agosto`, `poa_septiembre`, `poa_octubre`, `poa_noviembre`, `poa_diciembre`, `poa_enero_sig`, `diagnostico`, `calidad_ortografia`, `calidad_totales`, `calidad_escaneado`, `calidad_encabezado`, `calidad_redaccion`, `calidad_actividades`, `acciones_2023`, `asistencia_reca_2023`, `fortalecimiento_2023`, `acciones_2024`, `asistencia_reca_2024`, `propuesta_2024_mobiliario`, `propuesta_2024_material`, `user_id`, `fecha_captura`, `municipio_texto`, `tipo_instancia_operativa`, `nombre_instancia_operativa`, `numero_direccion`, `colonia`, `localidad`, `cap_cultura_pago_desc`, `cap_cultura_pago_asis`, `caravana_estiaje_desc`, `caravana_estiaje_asis`, `caravana_lluvias_desc`, `caravana_lluvias_asis`, `curso_teatro_desc`, `curso_teatro_asis`, `platicas_domo_desc`, `platicas_domo_asis`, `convencion_aneas_desc`, `convencion_aneas_asis`, `fort_2023_mobiliario`, `fort_2023_material`, `fort_2023_desc`, `encuentro_hidrico_desc`, `encuentro_hidrico_asis`, `platicas_2024_desc`, `platicas_2024_asis`, `caravana_virtual_desc`, `caravana_virtual_asis`, `diagnostico_municipal_desc`, `diagnostico_municipal_asis`, `prop_2024_mobiliario`, `prop_2024_material`, `prop_2024_desc`, `diagnostico_general`, `observaciones_generales`) VALUES
(1, 17, 32, 'Hidalgo (HGO)', '87987', '2025-11-27', 'gbd', 'gbd@fvdfv.com', 'gbgb', 'fvdfbv', 'fbdf', '42300', 3, '3', 'kmlknm', 'knkln', 'klnkln', '2025-11-27', 'nikn', 'No', 'Si', 'No', 'No', '', '', '', '', 'Si', '', '', '', 'ijoij', 'jknkj', 'Regular', 'Regular', 'Regular', 'Regular', 'Regular', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, '2025-11-24 07:44:09', '9878', 'yguyg', 'uhiuh', '34', 'centro', 'Ixmiquilpan', 'dvsf', 'Si', 'vs ', 'Si', 'vdsvddcd', 'No', 'gbgf', 'Si', 'vfsdf', 'No', 'vdfsdf', 'Si', 'cd svf', ' sc', ' sc', 'fvdv', 'No', ' f ', 'No', ' fd ', 'No', 'f vd', 'No', ' ds', 'fv d', ' f', ' f', 'v'),
(2, 19, 20, 'Hidalgo (HGO)', '', '2025-11-27', '', '', '', '', '', '', 0, '', '', '', '', '0000-00-00', '', '', '', 'Si', '', '', '', '', '', '', '', '', '', '', '', NULL, NULL, NULL, NULL, 'Bueno', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, '2025-11-24 07:45:21', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(3, 3, 3, 'Hidalgo (HGO)', '6175', '2025-10-24', 'nose', 'olguinbrenda189@gmail.com', '7722587371', 'de hoy a mañana', 'presa vicente aguirre', '42390', 1, '2', 'nose es una prueba ', 'computadora y telefono', 'un lapiz', '2025-10-27', 'hoy 24 de noviembre es una prueba de eve', 'No', '', '', '', '', '', '', '', '', 'Si', '', '', 'bolissss', 'esta masomenos', 'Regular', 'Regular', 'Regular', 'Regular', 'Regular', 'Regular', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, '2025-11-24 15:28:41', '5283', 'alfa', 'zozea', '2', 'zozea', 'zozea', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(4, 23, 24, 'Hidalgo (HGO)', '87987', '2025-11-04', '', '', '', '', '', '', 0, '', '', '', '', '0000-00-00', '', 'Si', 'No', '', '', '', '', '', '', '', '', '', '', 'fghgj', 'nhhgh', NULL, 'Regular', NULL, 'Bueno', 'Regular', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, '2025-11-24 16:03:59', 'yyuuiooojhgt', '', '', '', '', '', '', 'Si', '', 'No', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(5, 19, 20, '46536', '6564', '2025-11-24', '', '', '', '', '', '', 0, '', '', '', '', '2025-11-24', '', '', '', '', '', 'Si', '', '', '', '', '', '', '', '', '', NULL, NULL, NULL, NULL, 'Malo', 'Regular', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, '2025-11-27 07:16:50', '5364', '', '', '', '', '', '', 'Si', '', '', '', 'Si', '', '', '', '', '', '', '', '', '', '', '', '', '', 'gfdg', 'No', '', '', '', 'ertgg', '', 'gfsg', 'fgsgd');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formatos`
--

CREATE TABLE `formatos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(160) NOT NULL,
  `version` varchar(20) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT 1,
  `definicion_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`definicion_json`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `formatos`
--

INSERT INTO `formatos` (`id`, `nombre`, `version`, `activo`, `definicion_json`) VALUES
(1, 'Ficha Técnica del ECA', '1.0', 1, '{ \"secciones\": [] }');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `importaciones_excel`
--

CREATE TABLE `importaciones_excel` (
  `id` int(11) NOT NULL,
  `formato_id` int(11) DEFAULT NULL,
  `archivo` varchar(255) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `insertados` int(11) DEFAULT NULL,
  `errores` int(11) DEFAULT NULL,
  `detalle` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`detalle`)),
  `creado_por` int(11) DEFAULT NULL,
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimientos`
--

CREATE TABLE `movimientos` (
  `id` int(11) NOT NULL,
  `recurso_id` int(11) NOT NULL,
  `tipo` enum('ENTRADA','SALIDA','AJUSTE') NOT NULL,
  `motivo` varchar(200) DEFAULT NULL,
  `cantidad` int(11) NOT NULL,
  `fecha` date NOT NULL DEFAULT curdate(),
  `ref_documento` varchar(120) DEFAULT NULL,
  `creado_por` int(11) DEFAULT NULL,
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `municipios`
--

CREATE TABLE `municipios` (
  `id` int(11) NOT NULL,
  `cvegeo` varchar(10) DEFAULT NULL,
  `nombre` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `municipios`
--

INSERT INTO `municipios` (`id`, `cvegeo`, `nombre`) VALUES
(1, NULL, 'Actopan'),
(2, NULL, 'Ajacuba'),
(3, NULL, 'Alfajayucan'),
(4, NULL, 'Almoloya'),
(5, NULL, 'Apan'),
(6, NULL, 'Atitalaquia'),
(7, NULL, 'Atotonilco de Tula'),
(8, NULL, 'Atotonilco el Grande'),
(9, NULL, 'Calnali'),
(10, NULL, 'Cardonal'),
(11, NULL, 'Chapantongo'),
(12, NULL, 'Cuautepec de Hinojosa'),
(13, NULL, 'El Arenal'),
(14, NULL, 'Francisco I. Madero'),
(15, NULL, 'Huasca de Ocampo'),
(16, NULL, 'Huautla'),
(17, NULL, 'Huejutla de Reyes'),
(18, NULL, 'Huichapan'),
(19, NULL, 'Ixmiquilpan'),
(20, NULL, 'Jacala de Ledezma'),
(21, NULL, 'Mixquiahuala de Juárez'),
(22, NULL, 'Nopala de Villagrán'),
(23, NULL, 'Pachuca'),
(24, NULL, 'Progreso de Obregón'),
(25, NULL, 'San Agustín Tlaxiaca'),
(26, NULL, 'San Salvador'),
(27, NULL, 'Santiago de Anaya'),
(28, NULL, 'Santiago Tulantepec'),
(29, NULL, 'Tecozautla'),
(30, NULL, 'Tepeji del Río de Ocampo'),
(31, NULL, 'Tezontepec de Aldama'),
(32, NULL, 'Tizayuca'),
(33, NULL, 'Tlahuelilpan'),
(34, NULL, 'Tlaxcoapan'),
(35, NULL, 'Tula de Allende'),
(36, NULL, 'Tulancingo de Bravo'),
(37, NULL, 'Zimapán');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `organismos`
--

CREATE TABLE `organismos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(160) NOT NULL,
  `municipio_id` int(11) NOT NULL,
  `siglas` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `organismos`
--

INSERT INTO `organismos` (`id`, `nombre`, `municipio_id`, `siglas`) VALUES
(1, 'Comisión de Agua, Alcantarillado y Saneamiento de Actopan, Hgo.', 1, 'CAASA'),
(2, 'Comisión de Agua y Saneamiento de Ajacuba, Hidalgo.', 2, 'CAYSA'),
(3, 'Comisión de Agua y Alcantarillado del Municipio Alfajayucan, Hgo.', 3, 'CAAMAH'),
(4, 'Comisión de Agua de Almoloya, Hgo.', 4, 'COMAAL'),
(5, 'Comisión de Agua y Alcantarillado de Apan, Hgo.', 5, 'CAAPAN'),
(6, 'Comisión de Agua Potable, Alcantarillado y Saneamiento de Atitalaquia, Hgo.', 6, 'CAPASMAH'),
(7, 'Comisión de Agua, Alcantarillado y Saneamiento de Atotonilco de Tula, Hgo.', 7, 'CAASAT'),
(8, 'Comisión de Agua Potable, Alcantarillado y Saneamiento de Atotonilco el Grande, Hgo.', 8, 'CAPASMAGH'),
(9, 'Comisión de Agua Potable, Alcantarillado y Saneamiento de Calnali, Hgo.', 9, 'CAPASC'),
(10, 'Organismo Descentralizado de Agua Potable y Alcantarillado de Cardonal, Hgo.', 10, 'ODAPyAC'),
(11, 'Sistema de Agua Potable de Chapantongo, Hgo.', 11, 'SAPC'),
(12, 'Comisión de Agua, Alcantarillado y Saneamiento del Municipio de Cuautepec de Hinojosa, Hgo.', 12, 'CAASMCHH'),
(13, 'Organismo Operador de Agua Potable \"El Aserradero\" de Cuautepec de Hinojosa, Hgo.', 12, 'OOAPA'),
(14, 'Comisión de Agua Potable, Alcantarillado y Saneamiento de El Arenal, Hgo. (Sistema Bocja-Chimilpa)', 13, 'CAPASA-SBC'),
(15, 'Comisión de Agua y Alcantarillado del Sistema Valle del Mezquital.', 14, 'CAASVAM'),
(16, 'Comisión de Agua del Municipio de Huasca, Hgo.', 15, 'COAMH'),
(17, 'Comisión de Agua, Alcantarillado y Saneamiento del Municipio de Huautla, Hgo.', 16, 'CAASH'),
(18, 'Comisión de Agua Potable, Alcantarillado y Saneamiento de Huejutla, Hgo.', 17, 'CAPASHH'),
(19, 'Comisión de Agua Potable y Saneamiento de Huichapan, Hgo.', 18, 'CAPOSA'),
(20, 'Comisión de Agua Potable, Alcantarillado y Saneamiento del Municipio de Ixmiquilpan, Hgo.', 19, 'CAPASMIH'),
(21, 'Comisión de Agua Potable, Alcantarillado y Saneamiento de Jacala de Ledezma, Hgo.', 20, 'CAPASJ'),
(22, 'Comisión de Agua y Alcantarillado del Municipio de Mixquiahuala de Juárez, Hgo.', 21, 'CAAMM'),
(23, 'Comisión de Agua, Alcantarillado y Saneamiento de Nopala de Villagrán, Hgo.', 22, 'COOASA'),
(24, 'Comisión de Agua y Alcantarillado de Sistemas Intermunicipales.', 23, 'CAASIM'),
(25, 'Comisión de Agua y Alcantarillado del Municipio de Progreso de Obregón, Hgo.', 24, 'CAAMPAO'),
(26, 'Comisión de Agua Potable, Alcantarillado y Saneamiento de San Agustín Tlaxiaca, Hgo.', 25, 'CAPASSAT'),
(27, 'Comisión de Agua y Alcantarillado y Saneamiento del Municipio de San Salvador, Hgo.', 26, 'CAAMSSH'),
(28, 'Comisión de Agua Potable, Alcantarillado y Saneamiento de Santiago de Anaya, Hgo.', 27, 'CAPASSA'),
(29, 'Comisión de Agua, Alcantarillado y Saneamiento de Santiago Tulantepec de Lugo Guerrero, Hgo.', 28, 'CAASST'),
(30, 'Comisión de Agua, Alcantarillado y Saneamiento de Tecozautla, Hgo.', 29, 'CAAST'),
(31, 'Comisión de Agua y Alcantarillado del Municipio de Tepeji del Río Ocampo, Hgo.', 30, 'CAAMTROH'),
(32, 'Comisión de Agua y Alcantarillado de Tezontepec de Aldama, Hgo.', 31, 'CAYATAH'),
(33, 'Comisión de Agua y Alcantarillado del Municipio de Tizayuca, Hgo.', 32, 'CAAMTH'),
(34, 'Comisión de Agua y Saneamiento del Municipio de Tlahuelilpan, Hgo.', 33, 'CASMTH'),
(35, 'Comisión de Agua y Saneamiento de Tlaxcoapan, Hgo.', 34, 'CASTH'),
(36, 'Comisión de Agua Potable y Alcantarillado de Tula de Allende, Hgo.', 35, 'CAPyAT'),
(37, 'Comisión de Agua y Alcantarillado del Municipio de Tulancingo, Hgo.', 36, 'CAAMT'),
(38, 'Comisión de Agua Potable, Alcantarillado y Saneamiento de Zimapán, Hgo.', 37, 'CAPASAZIM');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pdf_reportes`
--

CREATE TABLE `pdf_reportes` (
  `id` int(11) NOT NULL,
  `municipio_id` int(11) NOT NULL,
  `organismo_id` int(11) DEFAULT NULL,
  `archivo` varchar(255) NOT NULL,
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pdf_reportes`
--

INSERT INTO `pdf_reportes` (`id`, `municipio_id`, `organismo_id`, `archivo`, `creado_en`) VALUES
(1, 3, NULL, 'Municipio_3_20251124_012203.pdf', '2025-11-24 00:22:03'),
(2, 19, NULL, 'Municipio_19_20251124_012324.pdf', '2025-11-24 00:23:24'),
(3, 19, NULL, 'Municipio_19_20251124_012814.pdf', '2025-11-24 00:28:14'),
(4, 19, NULL, 'Municipio_19_20251124_013138.pdf', '2025-11-24 00:31:38'),
(5, 19, NULL, 'Municipio_19_20251124_013732.pdf', '2025-11-24 00:37:32'),
(6, 19, NULL, 'Municipio_19_20251124_014839.pdf', '2025-11-24 00:48:39'),
(7, 19, NULL, 'Municipio_19_20251124_014928.pdf', '2025-11-24 00:49:28'),
(8, 19, NULL, 'Municipio_19_20251124_015417.pdf', '2025-11-24 00:54:17'),
(9, 19, NULL, 'Municipio_19_20251124_015524.pdf', '2025-11-24 00:55:24'),
(10, 19, NULL, 'Municipio_19_20251124_015610.pdf', '2025-11-24 00:56:10'),
(11, 19, NULL, 'Municipio_19_20251124_015630.pdf', '2025-11-24 00:56:30'),
(12, 19, NULL, 'Municipio_19_20251124_015800.pdf', '2025-11-24 00:58:00'),
(13, 19, NULL, 'Municipio_19_20251124_015836.pdf', '2025-11-24 00:58:36'),
(14, 19, NULL, 'Municipio_19_20251124_020103.pdf', '2025-11-24 01:01:03'),
(15, 19, NULL, 'Municipio_19_20251124_021008.pdf', '2025-11-24 01:10:08'),
(16, 19, NULL, 'Municipio_19_20251124_021047.pdf', '2025-11-24 01:10:47'),
(17, 19, NULL, 'Municipio_19_20251124_021105.pdf', '2025-11-24 01:11:05'),
(18, 19, NULL, 'Municipio_19_20251124_035657.pdf', '2025-11-24 02:56:57'),
(19, 19, NULL, 'Municipio_19_20251124_040120.pdf', '2025-11-24 03:01:20'),
(20, 19, NULL, 'Municipio_19_20251124_041826.pdf', '2025-11-24 03:18:26'),
(21, 19, NULL, 'Municipio_19_20251124_042429.pdf', '2025-11-24 03:24:29'),
(22, 19, NULL, 'Municipio_19_20251124_042534.pdf', '2025-11-24 03:25:34'),
(23, 19, NULL, 'Municipio_19_20251124_042601.pdf', '2025-11-24 03:26:01'),
(24, 18, NULL, 'Municipio_18_20251124_043017.pdf', '2025-11-24 03:30:18'),
(25, 18, NULL, 'Municipio_18_20251124_043035.pdf', '2025-11-24 03:30:35'),
(26, 18, NULL, 'Municipio_18_20251124_043643.pdf', '2025-11-24 03:36:44'),
(27, 5, NULL, 'Municipio_5_20251124_044635.pdf', '2025-11-24 03:46:35'),
(28, 5, 20, 'Municipio_5_20251124_045747.pdf', '2025-11-24 03:57:47'),
(29, 28, 29, 'Municipio_28_20251124_050317.pdf', '2025-11-24 04:03:17'),
(30, 28, 29, 'Municipio_28_20251124_050357.pdf', '2025-11-24 04:03:57'),
(31, 28, 29, 'Municipio_28_20251124_051947.pdf', '2025-11-24 04:19:47'),
(32, 14, 15, 'Municipio_14_20251124_081313.pdf', '2025-11-24 07:13:13'),
(33, 14, 15, 'Municipio_14_20251124_081329.pdf', '2025-11-24 07:13:29'),
(34, 19, 20, 'Municipio_19_20251124_161501.pdf', '2025-11-24 15:15:01'),
(35, 19, 20, 'Municipio_19_20251124_164901.pdf', '2025-11-24 15:49:01'),
(36, 3, 3, 'Municipio_3_20251127_042510.pdf', '2025-11-27 03:25:11'),
(37, 1, 1, 'Municipio_1_20251127_043349.pdf', '2025-11-27 03:33:49'),
(38, 1, 1, 'Municipio_1_20251127_081520.pdf', '2025-11-27 07:15:21'),
(39, 19, 20, 'Municipio_19_20260116_201616.pdf', '2026-01-16 19:16:17'),
(40, 19, 20, 'Municipio_19_20260116_202455.pdf', '2026-01-16 19:24:55'),
(41, 19, 20, 'Municipio_19_20260116_202641.pdf', '2026-01-16 19:26:41'),
(42, 10, 10, 'Municipio_10_20260127_211705.pdf', '2026-01-27 20:17:06'),
(43, 10, 10, 'Municipio_10_20260127_211719.pdf', '2026-01-27 20:17:19');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pdf_reportes_anual`
--

CREATE TABLE `pdf_reportes_anual` (
  `id` int(11) NOT NULL,
  `archivo` varchar(255) DEFAULT NULL,
  `anio` int(11) DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pdf_reportes_anual`
--

INSERT INTO `pdf_reportes_anual` (`id`, `archivo`, `anio`, `fecha`) VALUES
(1, 'ReporteAnual_20251124_053708.pdf', 2025, '2025-11-24 04:37:08'),
(2, 'ReporteAnual_20251126_195527.pdf', 2025, '2025-11-26 18:55:28'),
(3, 'ReporteAnual_20251128_015912.pdf', 2025, '2025-11-28 00:59:12'),
(4, 'ReporteAnual_20260116_202714.pdf', 2026, '2026-01-16 19:27:14');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id` int(11) NOT NULL,
  `nombre` varchar(160) NOT NULL,
  `rfc` varchar(20) DEFAULT NULL,
  `telefono` varchar(30) DEFAULT NULL,
  `email` varchar(120) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id`, `nombre`, `rfc`, `telefono`, `email`) VALUES
(1, 'Proveedor genérico 1', 'XAXX010101000', '7710000001', 'proveedor1@ejemplo.com'),
(2, 'Proveedor genérico 2', 'XAXX010101000', '7710000002', 'proveedor2@ejemplo.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recursos`
--

CREATE TABLE `recursos` (
  `id` int(11) NOT NULL,
  `clave` varchar(50) DEFAULT NULL,
  `nombre` varchar(200) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `categoria_id` int(11) DEFAULT NULL,
  `area_responsable` varchar(255) DEFAULT NULL,
  `estado_bien` enum('bueno','regular','malo','baja') DEFAULT NULL,
  `unidad_id` int(11) DEFAULT NULL,
  `organismo_id` int(11) DEFAULT NULL,
  `municipio_id` int(11) DEFAULT NULL,
  `tipo_fuente` varchar(20) NOT NULL,
  `fuente` enum('DONACION','COMPRA') NOT NULL,
  `proveedor_id` int(11) DEFAULT NULL,
  `costo_unitario` decimal(12,2) DEFAULT 0.00,
  `cantidad_total` int(11) NOT NULL DEFAULT 0,
  `cantidad_disponible` int(11) NOT NULL DEFAULT 0,
  `ubicacion_id` int(11) DEFAULT NULL,
  `fecha_alta` date DEFAULT curdate(),
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp(),
  `actualizado_en` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `accion` varchar(160) DEFAULT NULL,
  `concepto` varchar(160) DEFAULT NULL,
  `anio_fortalecimiento` int(11) DEFAULT NULL,
  `marca` varchar(160) DEFAULT NULL,
  `modelo` varchar(160) DEFAULT NULL,
  `numero_serie` varchar(160) DEFAULT NULL,
  `color` varchar(120) DEFAULT NULL,
  `material` varchar(120) DEFAULT NULL,
  `beneficiario` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `recursos`
--

INSERT INTO `recursos` (`id`, `clave`, `nombre`, `descripcion`, `categoria_id`, `area_responsable`, `estado_bien`, `unidad_id`, `organismo_id`, `municipio_id`, `tipo_fuente`, `fuente`, `proveedor_id`, `costo_unitario`, `cantidad_total`, `cantidad_disponible`, `ubicacion_id`, `fecha_alta`, `creado_en`, `actualizado_en`, `accion`, `concepto`, `anio_fortalecimiento`, `marca`, `modelo`, `numero_serie`, `color`, `material`, `beneficiario`) VALUES
(4, '0015', 'Televición', 'sgdg', 5, NULL, NULL, 4, NULL, NULL, 'DONACION', 'DONACION', NULL, 5000.00, 1, 1, 2, '2025-11-20', '2025-11-20 06:45:44', '2025-11-20 06:45:44', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, '0002', 'Televición', 'todo bien', 2, NULL, 'bueno', 4, NULL, NULL, 'DONACION', 'DONACION', NULL, 10000.00, 1, 1, 2, '2025-11-21', '2025-11-21 05:23:19', '2025-11-21 05:23:19', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, '0003', 'escritorio', 'en excelentes condiciones', 1, NULL, 'bueno', 4, NULL, NULL, 'DONACION', 'DONACION', NULL, 1000.00, 1, 1, 2, '2025-11-21', '2025-11-21 09:09:00', '2025-11-21 09:09:00', NULL, NULL, NULL, 'desconocido', 'sin modelo', '4656456456', 'gris y cafee', NULL, NULL),
(8, '32436', 'televisión', 'rayon', 2, NULL, 'regular', 4, NULL, NULL, 'COMPRA', 'DONACION', NULL, 2000.00, 1, 1, 2, '2025-11-21', '2025-11-21 17:57:15', '2025-11-21 17:57:15', NULL, NULL, NULL, 'samsung', 'ningunos', '34324353', 'negro', NULL, NULL),
(9, '77567', 'silla', 'es nueva', 1, NULL, 'bueno', 1, NULL, NULL, 'DONACION', 'DONACION', NULL, 800.00, 1, 1, 1, '2025-11-21', '2025-11-21 20:26:09', '2025-11-21 20:26:09', NULL, NULL, NULL, 'desconocido', 'sin modelo', '765765656', 'negro', NULL, NULL),
(10, '23', 'escritorio de metal', 'es nuevo el producto', 1, NULL, 'bueno', 4, NULL, NULL, 'DONACION', 'DONACION', NULL, 3000.00, 1, 1, 2, '2025-11-23', '2025-11-23 22:30:11', '2025-11-23 22:30:11', NULL, NULL, NULL, 'desconocido', 'ningunos', '34324352', 'gris', NULL, NULL),
(11, '76876', 'mesa', 'hgiyg', 1, NULL, 'bueno', 4, NULL, NULL, 'COMPRA', 'DONACION', NULL, 500.00, 1, 1, 3, '2025-11-27', '2025-11-27 03:24:33', '2025-11-27 03:24:33', NULL, NULL, NULL, 'desconocido', 'sin modelo', '4656456457', 'blanco', NULL, NULL),
(12, '0013', 'computadora', 'hoijh', 2, NULL, 'bueno', 4, NULL, NULL, 'DONACION', 'DONACION', NULL, 7000.00, 1, 1, NULL, '2025-11-27', '2025-11-27 03:33:13', '2025-11-27 04:50:31', NULL, NULL, NULL, 'HP', 'sin modelo', '53564767', 'negro', 'plastico', NULL),
(13, '43534', 'dfcsd', 'gdvdfvgb', 2, NULL, 'bueno', 4, NULL, NULL, 'COMPRA', 'DONACION', NULL, 4000.00, 1, 1, 2, '2025-11-27', '2025-11-27 04:19:57', '2025-11-27 04:19:57', NULL, NULL, NULL, 'edfsd', 'dsfdv', '', 'vdsvd', 'sdvfssdfvfv', NULL),
(14, '6756867', 'bffbdfbdg', '53464', 2, NULL, 'malo', 4, NULL, NULL, 'DONACION', 'DONACION', NULL, 5666.00, 1, 1, 2, '2025-11-27', '2025-11-27 04:51:20', '2025-11-27 04:51:20', NULL, NULL, NULL, 'desconocido', 'sin modelo', '6537567', 'blanco', 'plastico', NULL),
(15, '544534', 'fgdfg', 'dfdf', 2, NULL, 'bueno', 2, NULL, NULL, 'COMPRA', 'DONACION', NULL, 4555.00, 1, 1, 1, '2025-11-27', '2025-11-27 07:14:40', '2025-11-27 07:14:40', NULL, NULL, NULL, 'desconocido', 'ningunos', '343246456', 'gris', 'metal', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reportes_generados`
--

CREATE TABLE `reportes_generados` (
  `id` int(11) NOT NULL,
  `municipio_id` int(11) NOT NULL,
  `organismo_id` int(11) NOT NULL,
  `tipo_reporte` varchar(120) NOT NULL,
  `beneficiario` varchar(255) NOT NULL,
  `accion` varchar(255) NOT NULL,
  `anio` int(11) NOT NULL,
  `pdf_filename` varchar(255) NOT NULL,
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `nombre`) VALUES
(1, 'Administrador'),
(2, 'Capturista');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ubicaciones`
--

CREATE TABLE `ubicaciones` (
  `id` int(11) NOT NULL,
  `nombre` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ubicaciones`
--

INSERT INTO `ubicaciones` (`id`, `nombre`) VALUES
(2, 'Almacén general'),
(3, 'Bodega 1'),
(4, 'Bodega 2'),
(1, 'Oficinas centrales CEAA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidades`
--

CREATE TABLE `unidades` (
  `id` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `unidades`
--

INSERT INTO `unidades` (`id`, `nombre`) VALUES
(4, 'Equipo'),
(2, 'Juego'),
(5, 'Litro'),
(3, 'Paquete'),
(1, 'Pieza');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(120) NOT NULL,
  `email` varchar(120) NOT NULL,
  `foto_perfil` varchar(255) DEFAULT 'assets/img/default-profile.png',
  `password_hash` varchar(255) NOT NULL,
  `rol_id` int(11) NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp(),
  `actualizado_en` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `email`, `foto_perfil`, `password_hash`, `rol_id`, `activo`, `creado_en`, `actualizado_en`) VALUES
(3, 'Administrador', 'admin@ceaa.gob.mx', 'assets/img/default-profile.png', 'Admin123!', 1, 1, '2025-11-10 15:43:29', '2025-11-10 15:43:29'),
(4, 'Brenda Evelyn Benitez Olguin', 'olguinbrenda189@gmail.com', 'uploads/perfiles/perfil_4_1769545135_Imagen de WhatsApp 2025-03-17 a las 17.03.04_bc261982.jpg', 'hola1', 1, 1, '2025-11-10 15:43:29', '2026-01-27 20:21:37');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `capturas_formato`
--
ALTER TABLE `capturas_formato`
  ADD PRIMARY KEY (`id`),
  ADD KEY `organismo_id` (`organismo_id`),
  ADD KEY `municipio_id` (`municipio_id`),
  ADD KEY `capturas_formato_ibfk_1` (`formato_id`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `eca_fichas`
--
ALTER TABLE `eca_fichas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `formatos`
--
ALTER TABLE `formatos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `importaciones_excel`
--
ALTER TABLE `importaciones_excel`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `recurso_id` (`recurso_id`);

--
-- Indices de la tabla `municipios`
--
ALTER TABLE `municipios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `organismos`
--
ALTER TABLE `organismos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `municipio_id` (`municipio_id`);

--
-- Indices de la tabla `pdf_reportes`
--
ALTER TABLE `pdf_reportes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pdf_reportes_anual`
--
ALTER TABLE `pdf_reportes_anual`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `recursos`
--
ALTER TABLE `recursos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categoria_id` (`categoria_id`),
  ADD KEY `unidad_id` (`unidad_id`),
  ADD KEY `organismo_id` (`organismo_id`),
  ADD KEY `municipio_id` (`municipio_id`),
  ADD KEY `proveedor_id` (`proveedor_id`),
  ADD KEY `ubicacion_id` (`ubicacion_id`);

--
-- Indices de la tabla `reportes_generados`
--
ALTER TABLE `reportes_generados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `municipio_id` (`municipio_id`),
  ADD KEY `organismo_id` (`organismo_id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `ubicaciones`
--
ALTER TABLE `ubicaciones`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `unidades`
--
ALTER TABLE `unidades`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `rol_id` (`rol_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `capturas_formato`
--
ALTER TABLE `capturas_formato`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `eca_fichas`
--
ALTER TABLE `eca_fichas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `formatos`
--
ALTER TABLE `formatos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `importaciones_excel`
--
ALTER TABLE `importaciones_excel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `municipios`
--
ALTER TABLE `municipios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de la tabla `organismos`
--
ALTER TABLE `organismos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `pdf_reportes`
--
ALTER TABLE `pdf_reportes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT de la tabla `pdf_reportes_anual`
--
ALTER TABLE `pdf_reportes_anual`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `recursos`
--
ALTER TABLE `recursos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `reportes_generados`
--
ALTER TABLE `reportes_generados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `ubicaciones`
--
ALTER TABLE `ubicaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `unidades`
--
ALTER TABLE `unidades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `capturas_formato`
--
ALTER TABLE `capturas_formato`
  ADD CONSTRAINT `capturas_formato_ibfk_1` FOREIGN KEY (`formato_id`) REFERENCES `formatos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `capturas_formato_ibfk_2` FOREIGN KEY (`organismo_id`) REFERENCES `organismos` (`id`),
  ADD CONSTRAINT `capturas_formato_ibfk_3` FOREIGN KEY (`municipio_id`) REFERENCES `municipios` (`id`);

--
-- Filtros para la tabla `movimientos`
--
ALTER TABLE `movimientos`
  ADD CONSTRAINT `movimientos_ibfk_1` FOREIGN KEY (`recurso_id`) REFERENCES `recursos` (`id`);

--
-- Filtros para la tabla `organismos`
--
ALTER TABLE `organismos`
  ADD CONSTRAINT `organismos_ibfk_1` FOREIGN KEY (`municipio_id`) REFERENCES `municipios` (`id`);

--
-- Filtros para la tabla `recursos`
--
ALTER TABLE `recursos`
  ADD CONSTRAINT `recursos_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`),
  ADD CONSTRAINT `recursos_ibfk_2` FOREIGN KEY (`unidad_id`) REFERENCES `unidades` (`id`),
  ADD CONSTRAINT `recursos_ibfk_3` FOREIGN KEY (`organismo_id`) REFERENCES `organismos` (`id`),
  ADD CONSTRAINT `recursos_ibfk_4` FOREIGN KEY (`municipio_id`) REFERENCES `municipios` (`id`),
  ADD CONSTRAINT `recursos_ibfk_5` FOREIGN KEY (`proveedor_id`) REFERENCES `proveedores` (`id`),
  ADD CONSTRAINT `recursos_ibfk_6` FOREIGN KEY (`ubicacion_id`) REFERENCES `ubicaciones` (`id`);

--
-- Filtros para la tabla `reportes_generados`
--
ALTER TABLE `reportes_generados`
  ADD CONSTRAINT `reportes_generados_ibfk_1` FOREIGN KEY (`municipio_id`) REFERENCES `municipios` (`id`),
  ADD CONSTRAINT `reportes_generados_ibfk_2` FOREIGN KEY (`organismo_id`) REFERENCES `organismos` (`id`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
