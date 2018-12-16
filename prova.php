<?php
$base = __DIR__;
require_once("$base/model/autor.class.php");
$autor=new Autor();
$res=$autor->getAll();
//if ($res->correcta) {
//	foreach ($res->dades as $row){
//    	echo $row['id_aut']."-".$row['nom_aut']." ".$row["fk_nacionalitat"]."<br>";
//    }
//} else {
// 	echo $res->missatge;
//}

//$autor->insert(array("nom_aut"=>"Tomeu Campaner","fk_nacionalitat"=>"CATALANA"));   //se introduce en la base de datos con el nombre de
// Tomeu Campaner.
// if (!$res->correcta) {
// 	echo "Error insertant";  // Error per l'usuari
// 	error_log($res->missatge,3,"$base/log/errors.log");  // Error per noltros
// }   
$resultado = $autor->get(1); 
$row=$resultado->dades;
echo $row['NOM_AUT'];
echo "<br>";

//$update = $autor->update(array("id_aut"=>"6550","nom_aut"=>"Miguel Rubio","fk_nacionalitat"=>"CATALANA"));//Cogemos el id que es autor que acabamos de
//insertar y lo modificamos el nombre a Miguel Rubio.

//Aqui usamos el metodo get para poder mostrar los datos del insertado recientemente y modificado.
//$resultado = $autor->get(6550);
//$row=$resultado->dades;
//echo $row['NOM_AUT'];

//Vamos a eliminar al ultimo autor añadido.
$resultado = $autor->delete(6550);

