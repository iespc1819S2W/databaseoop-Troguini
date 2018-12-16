<?php
$base = __DIR__ . '/..';
require_once("$base/lib/resposta.class.php");
require_once("$base/lib/database.class.php");

class Autor
{
    private $conn;       //connexió a la base de dades (PDO)
    private $resposta;   // resposta
    
    public function __CONSTRUCT()
    {
        $this->conn = Database::getInstance()->getConnection();  //Usamos un objeto de la clase database y pedimos el
        // estado de la variable $instance(esto provoca que si no esta iniciada pues se inicie), pedimos conexion porque
        // si tenemos la variable $instance tenemos creado un objeto database.
        $this->resposta = new Resposta();
    }
    
    public function getAll($orderby="id_aut")
    {
		try
		{
			$result = array();                        
			$stm = $this->conn->prepare("SELECT id_aut,nom_aut,fk_nacionalitat FROM autors ORDER BY $orderby");
			$stm->execute();
            $tuples=$stm->fetchAll();
            $this->resposta->setDades($tuples);    // array de tuples
			$this->resposta->setCorrecta(true);       // La resposta es correcta        
            return $this->resposta;
		}
        catch(Exception $e)
		{   // hi ha un error posam la resposta a fals i tornam missatge d'error
			$this->resposta->setCorrecta(false, $e->getMessage());
            return $this->resposta;
		}
    }
    
    public function get($id)
    {
        try{
            $sql = "SELECT * FROM AUTORS where ID_AUT = $id";
            $stm=$this->conn->prepare($sql);
            $stm->execute();
            $row=$stm->fetch();
            $this->resposta->SetDades($row);
            $this->resposta->setCorrecta(true);
            return $this->resposta;

        }catch(Exception $e){
            $this->resposta->setCorrecta(false, "Error get ID: ".$e->getMessage());
            return $this->resposta;
        }
    }

    
    public function insert($data)
    {
		try 
		{
                $sql = "SELECT max(id_aut) as N from autors";
                $stm=$this->conn->prepare($sql);
                $stm->execute();
                $row=$stm->fetch();
                $id_aut=$row["N"]+1;
                $nom_aut=$data['nom_aut'];
                $fk_nacionalitat=$data['fk_nacionalitat'];

                $sql = "INSERT INTO autors
                            (id_aut,nom_aut,fk_nacionalitat)
                            VALUES (:id_aut,:nom_aut,:fk_nacionalitat)";
                
                $stm=$this->conn->prepare($sql);
                $stm->bindValue(':id_aut',$id_aut);//bindValue sirve para vincular un valor con un parametro.
                $stm->bindValue(':nom_aut',$nom_aut);
                $stm->bindValue(':fk_nacionalitat',!empty($fk_nacionalitat)?$fk_nacionalitat:NULL,PDO::PARAM_STR);//representa
                //un tipo cadena como parametro.
                $stm->execute();
            
       	        $this->resposta->setCorrecta(true);
                return $this->resposta;
        }
        catch (Exception $e) 
		{
                $this->resposta->setCorrecta(false, "Error insertant: ".$e->getMessage());
                return $this->resposta;
		}
    }   
    
    public function update($data)
    {
        try{
            $id_aut = $data['id_aut'];
            $nom_aut = $data['nom_aut'];
            $fk_nacionalitat = $data['fk_nacionalitat'];
            $sql = "update AUTORS set NOM_AUT=:nom_aut, FK_NACIONALITAT = :fk_nacionalitat where ID_AUT = :id_aut";
            $stm = $this->conn->prepare($sql);
            $stm->bindValue(':id_aut',$id_aut);//falta tener el id del autor
            $stm->bindValue(':nom_aut',$nom_aut);
            $stm->bindValue(':fk_nacionalitat',!empty($fk_nacionalitat)?$fk_nacionalitat:NULL,PDO::PARAM_STR);
            $stm->execute();
//            $row = $stm->fetch();
//
//            $this->resposta->SetDades($row);
            $this->resposta->setCorrecta(true);
            return $this->resposta;

        }catch (Exception $e){
            $this->resposta->setCorrecta(false,"Error Update: ".$e->getMessage());
            return $this->resposta;

        }
    }

    
    
    public function delete($id)
    {
        try{
            $id_aut = $id;
            $sql = "DELETE FROM AUTORS where id_aut = :id_aut";
            $stm = $this->conn->prepare($sql);
            $stm->bindValue(':id_aut',$id_aut);
            $stm->execute();

            $this->resposta->setCorrecta(true);
            return $this->resposta;

        }catch (Exception $e){
            $this->resposta->setCorrecta(false,"Error delete: ".$e->getMessage());
            return $this->resposta;
        }
    }

    public function filtra($where,$orderby,$offset,$count)
    {
        // TODO
    }
    
          
}
