<?php
class Producto{
    public int $id ;
    public string $nombre;
    public string $categoria;
    public int $cantidad;
    public int $precio_costo;
    public int $precio_venta;
  
    public string $estado ;
    public string $imagen ;


    public function __construct(string $nombre, string $categoria, int $cantidad, int $precio_costo, int $precio_venta, string $imagen)
    {
        $this-> nombre = $nombre;
        $this-> categoria = $categoria;
        $this-> cantidad = $cantidad;
        $this-> precio_costo = $precio_costo;
        $this-> precio_venta = $precio_venta;
        $this-> imagen = $imagen;
    }

    //GETTERS AND SETTERS
    public function getId(){
        return $this->id;
    }
    public function getNombre(){
        return $this->nombre;
    }
    public function getCategoria(){
        return $this->categoria;
    }
    public function getCantidad(){
        return $this->cantidad; 
    }
    public function getPrecioCosto(){
        return $this->precio_costo;
    }
    public function getPrecioVenta(){
        return $this->precio_venta;
    }
    public function getEstado(){
        return $this->estado;    
    }    
    public function getImagen(){
        return $this->imagen;
    }
    public function setId($id){
        $this->id = $id;
    }
    public function setNombre($nombre){
        $this->nombre = $nombre;
    }
    public function setCategoria($categoria){
        $this->categoria = $categoria;
    }
    public function setCantidad($cantidad){
        $this->cantidad = $cantidad;
    }
    public function setPrecioCosto($precio_costo){
        $this->precio_costo = $precio_costo;
    }
    public function setPrecioVenta($precio_venta){
        $this->precio_venta = $precio_venta;
    }
    public function setEstado($estado){
        $this->estado = $estado;    
    }
    public function setImagen($imagen){
        $this->imagen = $imagen;
    }

   
    public function crearProducto($producto){

        include_once 'Database.php';
        try{
            $db = new Database();
            $conexion = $db->getConnection();
        } catch (Exception $e){
            echo $e->getMessage();
            exit;
        }
        $blob_placeholder = '';
        $sql = 'INSERT INTO products (nombre, categoria, cantidad, precio_costo, precio_venta, imagen) VALUES (?,?,?,?,?,?,?)';
        $stmt = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($stmt,
                    "ssiddsb",
                    $producto->nombre, 
                    $producto->categoria,
                    $producto->cantidad,
                    $producto->precio_costo,
                    $producto->precio_venta,
                    $blob_placeholder
                    );
        mysqli_stmt_send_long_data($stmt, 6, $producto->imagen);
        $exito = mysqli_stmt_execute($stmt);
        if($exito){
            $mensaje = 'Exito guardando el producto';
            mysqli_stmt_close($stmt);
            return $mensaje ;
        } else {
            $mensaje = 'Error guardando el producto';
            mysqli_stmt_close($stmt);
            return $mensaje;
        }
    }

    public static function obtenerProductos(){
        include_once 'Database.php';
        try{
            $db = new Database();
            $conexion = $db->getConnection();
        } catch (Exception $e){
            echo $e->getMessage();
            exit;
        }
        $sql = 'SELECT id, nombre, categoria, cantidad, precio_costo, precio_venta FROM products';
        $stmt = mysqli_prepare($conexion, $sql);
        $exito = mysqli_stmt_execute($stmt);
        if($exito){
            $productos = [] ;
            $productos = mysqli_stmt_get_result($stmt);
            mysqli_stmt_close($stmt);
            return $productos;
        } else {
            $mensaje = 'Error obteniendo los productos';
            mysqli_stmt_close($stmt);
            return $mensaje;
        }
    }


    public static function obtenerProductoPorId($id){
        include_once 'Database.php';
        try{
            $db = new Database();
            $conexion = $db->getConnection();
        } catch (Exception $e){
            echo $e->getMessage();
            exit;
        }
        $sql = 'SELECT * FROM products WHERE id = ?';
        $stmt = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);
        $exito = mysqli_stmt_execute($stmt);
        if(mysqli_stmt_execute($stmt)){
            $resultado = mysqli_stmt_get_result($stmt);
            $fila = mysqli_fetch_assoc($resultado);
            mysqli_stmt_close($stmt);
            if($fila){
                return new Producto(
                    $fila['nombre'],
                    $fila['categoria'],
                    $fila['cantidad'],
                    $fila['precio_costo'],
                    $fila['precio_venta'],
                    $fila['imagen']
                );
            }

        }
    }

    public static function actualizarProducto($producto){
        include_once 'Database.php';
        try{
            $db = new Database();
            $conexion = $db->getConnection();
        } catch (Exception $e){
            echo $e->getMessage();
            exit;
        }   
        $sql = 'UPDATE products SET nombre = ?, categoria = ?, cantidad = ?, precio_costo = ?, precio_venta = ?, imagen = ?';
        $stmt = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($stmt, "ssiddb", $producto->nombre, $producto->categoria, $producto->cantidad, $producto->precio_costo, $producto->precio_venta, $producto->imagen);
        $exito = mysqli_stmt_execute($stmt);
        if($exito){
            $mensaje = 'Producto actualizado correctamente';
            mysqli_stmt_close($stmt);
            return $mensaje ;
        } else {
            $mensaje = 'Error actualizando el producto';
            mysqli_stmt_close($stmt);
            return $mensaje;
        }
    }

}


?>