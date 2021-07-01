<?php


namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class AppController extends Action {

    public function timeline() {
        $this->validaAutenticacao();

        $tweet = Container::getModel("Tweet");

       $tweet->__set("id_usuario", $_SESSION["id"]);

        $this->view->tweets = $tweet->recuperarTweets();

        $usuario =Container::getModel("usuario");
        $usuario->__set("id", $_SESSION["id"]);
        $this->view->info_usuario = $usuario->getInfoUser();
        $this->view->info_tweets = $usuario->getTweetsCount();
        $this->view->info_seguindo = $usuario->getFollowing();
        $this->view->info_seguidores = $usuario->getFollowers();

       $this->render("timeline");
    }

    public function tweet()
    {
        $this->validaAutenticacao();

        $tweet = Container::getModel("Tweet");
        $tweet->__set("tweet", $_POST["tweet"]);
        $tweet->__set("id_usuario", $_SESSION["id"]);
        $tweet->salvarTweet();
        header("location: /timeline");

    }

    public function deletarTweet()
    {
        $this->validaAutenticacao();

        $tweet = Container::getModel("Tweet");
        $tweet->__set("id",$_GET["id"]);
        $tweet->__set("id_usuario", $_SESSION["id"]);
        $tweet->deletarTweet();
        header("location: /timeline");
    }

    public function validaAutenticacao()
    {
        session_start();
        if (empty($_SESSION)) {
            header("location: /");
        }
    }

    public function quemSeguir()
    {
        $this->validaAutenticacao();


        $pesquisa = isset($_GET["pesquisarPor"]) ? $_GET["pesquisarPor"] : "";

        $usuarios = [];
        if(!empty($pesquisa)) {
            $usuario = Container::getModel("usuario");
            $usuario->__set("nome", $pesquisa);
            $usuario->__set("id", $_SESSION["id"]);
            $usuarios =$usuario->getAll();

        }

        $usuario =Container::getModel("usuario");
        $usuario->__set("id", $_SESSION["id"]);
        $this->view->info_usuario = $usuario->getInfoUser();
        $this->view->info_tweets = $usuario->getTweetsCount();
        $this->view->info_seguindo = $usuario->getFollowing();
        $this->view->info_seguidores = $usuario->getFollowers();



        $this->view->usuarios =  $usuarios;
        $this->render("quemSeguir");
    }

    public function acao()
    {
        $this->validaAutenticacao();

        $acao = $_GET["acao"] ?? "";
        $id_usuario_seguindo = $_GET["id_usuario"] ?? "";

        $usuario = Container::getModel("UsuarioSeguidores");
        $usuario->__set("id", $_SESSION["id"]);

        if($acao == "seguir") {
            $usuario->seguirUsuario($id_usuario_seguindo);
            header("Refresh:0; url=/quem_seguir");

        }else if($acao == "deixar_de_seguir"){
            $usuario->deixarDeSeguirUsuario($id_usuario_seguindo);
            header("Refresh:0; url=/quem_seguir");
        }
    }
}