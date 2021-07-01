<?php

namespace App\Models;


use MF\Model\Model;
class Tweet extends Model {
    private $id;
    private $id_usuario;
    private $tweet;
    private $data;

    public function __get($attr) {
        return $this->$attr;
    }

    public function __set($attr, $val) {
        $this->$attr = $val;
    }

    //salvar tweets
    public function salvarTweet()
    {
       $query = "insert into tweets(id_usuario, tweet) values(:id_usuario, :tweet)";
       $stmt = $this->db->prepare($query);
       $stmt->bindValue(":id_usuario", $this->__get("id_usuario"));
       $stmt->bindValue(":tweet", $this->__get("tweet"));
       $stmt->execute();

       return $this;
    }
    //recuperar tweets

    public function recuperarTweets()
    {
        $query = "
            select t.id,
            t.id_usuario,
            u.nome,
            t.tweet,
            DATE_FORMAT(t.data, '%d/%m/%y %H:%i')
            as data from tweets as t 
            left join usuarios as u on (t.id_usuario = u.id)
            where t.id_usuario = :id_usuario
            or t.id_usuario in(select id_usuario_seguindo from seguindo where id_usuario = :id_usuario)
            order by t.data desc ";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":id_usuario", $this->__get("id_usuario"));
        $stmt->execute();


        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function deletarTweet()
    {
        $query = "delete from tweets where id = :id and id_usuario = :id_usuario";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $this->__get('id'));
        $stmt->bindValue(":id_usuario", $this->__get("id_usuario"));
        $stmt->execute();

        return true;
    }

}