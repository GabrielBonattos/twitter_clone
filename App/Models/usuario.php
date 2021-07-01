<?php

namespace App\Models;


use MF\Model\Model;
class Usuario extends Model {
    private $id;
    private $nome;
    private $email;
    private $senha;

    public function __get($attr)
    {
        return $this->$attr;
    }

    public function __set($attr, $valor) {
        $this->$attr = $valor;
    }

    //salvar no bd

    public function inserir()
    {
        $query = "insert into usuarios (nome,email,senha) values (:nome, :email, :senha)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":nome", $this->__get("nome"));
        $stmt->bindValue(":email", $this->__get("email"));
        $stmt->bindValue(":senha", $this->__get("senha"));
        $stmt->execute();

        return $this;
    }

    public function validarCadastro()
    {
        $valido = true;

        if(strlen($this->__get("nome")) < 5 || strlen($this->__get("email")) < 5 || strlen($this->__get("senha")) < 5) {
            $valido = false;
        }
        if(!filter_var($this->__get("email"), FILTER_VALIDATE_EMAIL)) {
            $valido = false;
        }

        return $valido;
    }

    public function getUserEmail() {
        $query = "select email from usuarios where email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":email", $this->__get("email"));
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function autenticar()
    {
        $query = "select id, nome, email from usuarios where email = :email and senha = :senha";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":email", $this->__get("email"));
        $stmt->bindValue(":senha", $this->__get("senha"));
        $stmt->execute();

        $usuario = $stmt->fetch(\PDO::FETCH_ASSOC);

        if(isset($usuario["id"]) && isset($usuario["nome"])) {
            $this->__set("id", $usuario["id"]);
            $this->__set("nome", $usuario["nome"]);
        }

        return $this;
    }

    public function getAll()
    {
        $query =
            "select u.id,
            u.nome,
            u.email,
            (select count(*) from seguindo as us where us.id_usuario = :id_usuario and us.id_usuario_seguindo = u.id)
            as seguindo_sn from usuarios as u where u.nome like :nome and u.id != :id_usuario";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":nome", "%" . $this->__get("nome") . "%");
        $stmt->bindValue(":id_usuario", $this->__get("id"));
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getInfoUser()
    {
        $query = "select nome from usuarios where id = :id_usuario";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":id_usuario", $this->__get("id"));
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getTweetsCount()
    {
        $query = "select count(*) as totalTweets from tweets where id_usuario = :id_usuario";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":id_usuario", $this->__get("id"));
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getFollowing()
    {
        $query = "select count(*) as totalSeguindo from seguindo where id_usuario = :id_usuario";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":id_usuario", $this->__get("id"));
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

        public function getFollowers()
    {
        $query = "select count(*) as totalSeguidores from seguindo where id_usuario_seguindo = :id_usuario";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":id_usuario", $this->__get("id"));
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}
