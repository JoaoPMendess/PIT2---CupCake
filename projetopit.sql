/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50724
Source Host           : localhost:3306
Source Database       : projetopit

Target Server Type    : MYSQL
Target Server Version : 50724
File Encoding         : 65001

Date: 2024-12-02 21:25:06
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for enderecos
-- ----------------------------
DROP TABLE IF EXISTS `enderecos`;
CREATE TABLE `enderecos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente_id` int(11) NOT NULL,
  `logradouro` varchar(150) DEFAULT NULL,
  `numero` varchar(10) DEFAULT NULL,
  `bairro` varchar(50) DEFAULT NULL,
  `cep` varchar(10) DEFAULT NULL,
  `municipio` varchar(100) DEFAULT NULL,
  `estado` char(2) DEFAULT NULL,
  `complemento` varchar(100) DEFAULT NULL,
  `referencia` varchar(100) DEFAULT NULL,
  `tipo_endereco` enum('residencial','comercial','outro') DEFAULT 'residencial',
  PRIMARY KEY (`id`),
  KEY `cliente_id` (`cliente_id`),
  CONSTRAINT `enderecos_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of enderecos
-- ----------------------------

-- ----------------------------
-- Table structure for pedidos
-- ----------------------------
DROP TABLE IF EXISTS `pedidos`;
CREATE TABLE `pedidos` (
  `pedido_id` int(9) NOT NULL,
  `produto_id` int(8) DEFAULT NULL,
  `cliente_id` int(11) DEFAULT NULL,
  `endereco_id` int(11) DEFAULT NULL,
  `unitario` double(15,2) DEFAULT NULL,
  `bruto` double(15,2) DEFAULT NULL,
  `valor` double(15,2) DEFAULT NULL,
  `promocao` double(5,2) DEFAULT NULL,
  `pago` tinyint(1) DEFAULT NULL,
  `tipo_pg` int(2) DEFAULT NULL,
  `data` date DEFAULT NULL,
  `finalizado_data` date DEFAULT NULL,
  `finalizado` tinyint(1) DEFAULT NULL,
  `quantidade` int(6) DEFAULT NULL,
  `categoria_prod` int(2) DEFAULT NULL,
  KEY `produto` (`produto_id`),
  KEY `cliente` (`cliente_id`),
  KEY `endereco` (`endereco_id`),
  KEY `data` (`data`),
  KEY `finalizado_data` (`finalizado_data`),
  KEY `tipo_pg` (`tipo_pg`),
  KEY `finalizado` (`finalizado`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of pedidos
-- ----------------------------

-- ----------------------------
-- Table structure for pedidos_cab
-- ----------------------------
DROP TABLE IF EXISTS `pedidos_cab`;
CREATE TABLE `pedidos_cab` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `data` date DEFAULT NULL,
  `cliente_id` int(11) DEFAULT NULL,
  `finalizado` tinyint(1) DEFAULT '0' COMMENT '0',
  `data_finalizado` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of pedidos_cab
-- ----------------------------

-- ----------------------------
-- Table structure for usuarios
-- ----------------------------
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `usuario` varchar(20) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `permissoes` int(2) DEFAULT NULL,
  `ult_compra` date DEFAULT NULL,
  `data_cadastro` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `senha` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`,`usuario`,`email`),
  UNIQUE KEY `usuario` (`usuario`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of usuarios
-- ----------------------------

-- ----------------------------
-- Table structure for utils
-- ----------------------------
DROP TABLE IF EXISTS `utils`;
CREATE TABLE `utils` (
  `vitrine_qtd` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of utils
-- ----------------------------

-- ----------------------------
-- Table structure for vitrine
-- ----------------------------
DROP TABLE IF EXISTS `vitrine`;
CREATE TABLE `vitrine` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) DEFAULT NULL,
  `descricao` tinytext,
  `categoria` int(2) DEFAULT NULL,
  `valor` double(15,2) DEFAULT NULL,
  `promocao` double(5,2) DEFAULT NULL,
  `ativo` tinyint(1) DEFAULT NULL,
  `imagem` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `nome` (`nome`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of vitrine
-- ----------------------------
