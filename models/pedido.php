<?php
class Pedido {
    private $id;
    private $usuario_id;
    private $provincia;
    private $localidad;
    private $direccion;
    private $coste;
    private $estado;
    private $fecha;
    private $hora;

    private $db;

    public function __construct() {
   
        $this->db =  Database::connect();
    }
    

	public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}

	public function getUsuario_id(){
		return $this->usuario_id;
	}

	public function setUsuario_id($usuario_id){
		$this->usuario_id = $usuario_id;
	}

	public function getProvincia(){
		return $this->provincia;
	}

	public function setProvincia($provincia){
		$this->provincia = $this->db->real_escape_string($provincia);
	}

	public function getLocalidad(){
		return $this->localidad;
	}

	public function setLocalidad($localidad){
		$this->localidad =  $this->db->real_escape_string($localidad);
	}

	public function getDireccion(){
		return $this->direccion;
	}

	public function setDireccion($direccion){
		$this->direccion =  $this->db->real_escape_string($direccion);
	}

	public function getCoste(){
		return $this->coste;
	}

	public function setCoste($coste){
		$this->coste = $coste;
	}

	public function getEstado(){
		return $this->estado;
	}

	public function setEstado($estado){
		$this->estado = $estado;
	}

	public function getFecha(){
		return $this->fecha;
	}

	public function setFecha($fecha){
		$this->fecha = $fecha;
	}

	public function getHora(){
		return $this->hora;
	}

	public function setHora($hora){
		$this->hora = $hora;
	}

    public function getAll(){
        $productos = $this->db->query("SELECT * FROM pedidos ORDER BY id DESC");
        return $productos;
    }


	public function getOne(){
        $producto = $this->db->query("SELECT * FROM pedidos WHERE id={$this->getId()}");
		//para que sea un objeto usamos fetch_object();
        return $producto->fetch_object();
    }
	
	public function getOneByUser(){
		$sql = "SELECT p.id, p.coste FROM pedidos p "
				// ."INNER JOIN lineaspedidos lp ON lp.pedido_id = p.id "
				." WHERE p.usuario_id={$this->getUsuario_id()} ORDER BY id DESC LIMIT 1 ";
        $pedido = $this->db->query($sql);


		// echo $sql;
		// echo $this->db->error;
		// die();
		//para que sea un objeto usamos fetch_object();
        return $pedido->fetch_object();
    }

	public function getAllByUser(){
		$sql = "SELECT p.* FROM pedidos p "
				." WHERE p.usuario_id={$this->getUsuario_id()} ORDER BY id DESC";
        $pedido = $this->db->query($sql);
        return $pedido;
    }
	public function getProductosByPedido($id){
		// $sql = "SELECT * FROM productos WHERE id IN "
		// 			."(SELECT producto_id from lineaspedidos WHERE pedido_id={$id} ) ";

		$sql = "SELECT pr.*, lp.unidades FROM productos pr "
				."INNER JOIN lineaspedidos lp ON pr.id = lp.producto_id"
				." WHERE lp.pedido_id={$id}";

		$productos = $this->db->query($sql);
		// 		echo $sql;
		// echo $this->db->error;
		// die();
		
		return $productos;
	}


    public function save(){ 
        // stock no va entre comillas

        $sql = "INSERT INTO pedidos VALUES (NULL,{$this->getUsuario_id()},'{$this->getProvincia()}','{$this->getLocalidad()}', '{$this->getDireccion()}', {$this->getCoste()}, 'confirm', CURDATE(), CURTIME())";
        $save = $this->db->query($sql);

        // echo $sql;
        // echo "<br/>";
        // echo $this->db->error; // --> para ver error
        // die();

        $result = false;
        if($save){
            $result = true;
        }
        return $result;
    }
    public function save_linea(){
        // nos da el ultimo id del ultimo insert que hice
        $sql = "SELECT LAST_INSERT_ID() as 'pedido' ;";
        $query = $this->db->query($sql);
        $pedido_id = $query->fetch_object()->pedido;

        foreach($_SESSION['carrito'] as $elemento){
            $producto = $elemento['producto'];

            $insert = "INSERT INTO lineaspedidos VALUES (NULL, {$pedido_id}, {$producto->id},{$elemento['unidades']})";
            $save = $this->db->query($insert);

            // var_dump($producto);
            // echo $this->db->error;
            // die();
        }
        $result = false;
        if($save){
            $result = true;
        }
        return $result;

    }
	public function edit(){ 
        // stock no va entre comillas

        $sql = "UPDATE pedidos SET estado='{$this->getEstado()}'";
		// el .= es para concatenar el trozo de codigo
		// condicion para ver si llego la imagen 
		$sql .= " WHERE id = {$this->getId()}";

        $save = $this->db->query($sql);

        // echo $sql;

        // echo "<br/>";
        // echo $this->db->error; // --> para ver error
        // die();

        $result = false;
        if($save){
            $result = true;
        }
        return $result;
    }
	
}