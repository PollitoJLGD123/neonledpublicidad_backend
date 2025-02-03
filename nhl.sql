-- MySQL dump 10.13  Distrib 8.0.33, for Win64 (x86_64)
--
-- Host: localhost    Database: nhl2
-- ------------------------------------------------------
-- Server version	8.0.33

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `contactanos`
--

DROP TABLE IF EXISTS `contactanos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contactanos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(250) DEFAULT NULL,
  `apellido` varchar(250) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `distrito` varchar(250) DEFAULT NULL,
  `email` varchar(250) DEFAULT NULL,
  `tipo_reclamo` varchar(50) DEFAULT NULL,
  `mensaje` text,
  `estado` varchar(50) DEFAULT NULL,
  `fecha_hora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_hora_actualizacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contactanos`
--

LOCK TABLES `contactanos` WRITE;
/*!40000 ALTER TABLE `contactanos` DISABLE KEYS */;

INSERT INTO `contactanos` VALUES 
(1, 'Juan', 'Pérez', '987654321', 'San Borja', 'juan.perez@email.com', 'consulta', 'Consulta sobre servicios de iluminación', 'pendiente', '2024-03-15 10:00:00', '2024-03-15 10:00:00'),
(2, 'María', 'García', '999888777', 'Miraflores', 'maria.garcia@email.com', 'reclamo', 'Reclamo por tiempo de entrega', 'pendiente', '2024-03-15 11:30:00', '2024-03-15 11:30:00'),
(3, 'Carlos', 'López', '966555444', 'San Isidro', 'carlos.lopez@email.com', 'sugerencia', 'Sugerencia para mejora de servicio', 'pendiente', '2024-03-15 14:15:00', '2024-03-15 14:15:00'),
(4, 'Ana', 'Torres', '955444333', 'La Molina', 'ana.torres@email.com', 'consulta', 'Información sobre costos', 'pendiente', '2024-03-15 16:45:00', '2024-03-15 16:45:00');

/*!40000 ALTER TABLE `contactanos` ENABLE KEYS */;
UNLOCK TABLES;



--
-- Table structure for table `libroreclamacion`
--

DROP TABLE IF EXISTS `libroreclamacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `libroreclamacion` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `apellido` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `telefono` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `departamento` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `direccion` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `distrito` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `tipo_servicio` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `fecha_incidente` date NOT NULL,
  `monto_reclamado` decimal(10,2) NOT NULL,
  `descripcion_servicio` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `declaracion_veraz` boolean NOT NULL DEFAULT FALSE,
  `acepta_politica` boolean NOT NULL DEFAULT FALSE,
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `estado` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'pendiente',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `libroreclamacion`
--

LOCK TABLES `libroreclamacion` WRITE;
/*!40000 ALTER TABLE `libroreclamacion` DISABLE KEYS */;

INSERT INTO `libroreclamacion` VALUES 
(1, 'Carlos', 'Mendoza', 'carlos.mendoza@email.com', '987654321', 'Lima', 'Av. Javier Prado 1234', 'San Isidro', 'Tipo A', '2024-03-15', 1500.00, 'Instalación defectuosa de panel LED', true, true, '2024-03-15 10:00:00', 'pendiente'),
(2, 'Ana', 'Rodriguez', 'ana.rodriguez@email.com', '999888777', 'Lima', 'Calle Los Pinos 567', 'Miraflores', 'Tipo B', '2024-03-14', 2300.00, 'Retraso en entrega de productos', true, true, '2024-03-14 15:30:00', 'pendiente'),
(3, 'Miguel', 'Torres', 'miguel.torres@email.com', '966555444', 'Lima', 'Jr. Huallaga 789', 'San Borja', 'Tipo C', '2024-03-13', 850.00, 'Producto no corresponde a lo solicitado', true, true, '2024-03-13 09:45:00', 'pendiente');

/*!40000 ALTER TABLE `libroreclamacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productos`
--

DROP TABLE IF EXISTS `productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `productos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `productos`
--

LOCK TABLES `productos` WRITE;
/*!40000 ALTER TABLE `productos` DISABLE KEYS */;

INSERT INTO `productos` VALUES 
(1, 'Panel LED 60x60', 'Panel LED de alta eficiencia para iluminación comercial', '2024-03-15 10:00:00'),
(2, 'Tira LED RGB', 'Tira LED multicolor con control remoto', '2024-03-15 11:30:00'),
(3, 'Reflector LED 100W', 'Reflector LED para exteriores de alta potencia', '2024-03-15 14:45:00');

/*!40000 ALTER TABLE `productos` ENABLE KEYS */;
UNLOCK TABLES;


/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-02-03 14:31:16
