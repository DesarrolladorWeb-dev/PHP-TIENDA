
<?php if(isset($_SESSION['identity'])): ?>
    <h1>hacer pedido</h1>
    <a href="<?=base_url?>carrito/index">Ver los productos y el precio del pedido</a>
    <p></p>
    <br> 
    <h3>Dirección para el envio</h3>

    <form action="<?=base_url.'pedido/add'?>" method="POST">

        <label for="provincia">provincia</label>
        <input type="text" name="provincia" required />

        <label for="localidad">ciudad</label>
        <input type="text" name="localidad" required/>

        <label for="direccion">direccion</label>
        <input type="text" name="direccion" required/>

        <input type="submit" value="Confirmar Pedido">
    </form>

<?php else: ?>
    <h1>Necesitas estar identificado</h1>
    <p>Necesitas estar logueado el la web para realizar pedidos</p>
<?php endif; ?>