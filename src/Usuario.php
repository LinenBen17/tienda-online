<?php
	namespace LinenBen17;
	
	class Usuario{
		
		private $config;
		private $cn = null;

		public function __construct(){
			$this->config = parse_ini_file(__DIR__.'/../config.ini');

			$this->cn = new \PDO($this->config['dbs'], $this->config['usuario'], $this->config['clave'], array(
					\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
				));
		}

		public function login($nombre, $clave){
			$sql = "SELECT nombre_usuario, clave FROM `usuarios` WHERE `nombre_usuario` = :nombre_usuario AND `clave` = :clave";
			
			$resultado = $this->cn->prepare($sql);

			$_array = array(
				":nombre_usuario" => $nombre,
				":clave" => $clave
			);

			if ($resultado->execute($_array)) {
				return $resultado->fetch();
			}else{
				return false;
			}					
		}
	}

?>