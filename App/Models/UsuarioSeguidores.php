<?php


namespace App\Models;


use MF\Model\Model;

class UsuarioSeguidores extends Model {
        private $id;


        public function __set($attr, $val)
        {
            $this->$attr = $val;
        }

        public function __get($val)
        {
            return $this->$val;
        }

        public function seguirUsuario($id)
        {
            $query = "insert into seguindo(id_usuario, id_usuario_seguindo) values (:id_usuario, :id_usuario_seguindo)";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(":id_usuario", $this->__get("id"));
            $stmt->bindValue(":id_usuario_seguindo", $id);
            $stmt->execute();

            return true;
        }

         public function deixarDeSeguirUsuario($id)
         {
             $query = "delete from seguindo where id_usuario = :id_usuario and id_usuario_seguindo = :id_usuario_seguindo";
             $stmt = $this->db->prepare($query);
             $stmt->bindValue(":id_usuario", $this->__get("id"));
             $stmt->bindValue(":id_usuario_seguindo", $id);
             $stmt->execute();

             return true;
        }
}