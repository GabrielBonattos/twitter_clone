<?php

namespace App;

use MF\Init\Bootstrap;

class Route extends Bootstrap {

	protected function initRoutes()
    {

		$routes['home'] =
            [
			'route' => '/',
			'controller' => 'IndexController',
			'action' => 'index'
		    ];

		$routes['inscreverse'] =
            [
			'route' => '/inscreverse',
			'controller' => 'IndexController',
			'action' => 'inscreverse'
		    ];

        $routes['registrar'] =
            [
                'route' => '/registrar',
                'controller' => 'IndexController',
                'action' => 'registrar'
            ];

        $routes["autenticar"] = [
            "route" => "/autenticar",
            "controller" => "AuthController",
            "action" => "autenticar"
        ];

        $routes["timeline"] = [
            "route" => "/timeline",
            "controller" => "AppController",
            "action" => "timeline"
    ];
        $routes["logout"] = [
            "route" => "/logout",
            "controller" => "AuthController",
            "action" => "logout"
        ];

        $routes["tweet"] = [
            "route" => "/tweet",
            "controller" => "AppController",
            "action" => "tweet"
        ];

        $routes["deletarTweet"] = [
            "route" => "/deletarTweet",
            "controller" => "AppController",
            "action" => "deletarTweet"
        ];

        $routes["quem_seguir"] = [
            "route" => "/quem_seguir",
            "controller" => "AppController",
            "action" => "quemSeguir"
        ];

        $routes["acao"] = [
            "route" => "/acao",
            "controller" => "AppController",
            "action" => "acao"
        ];
		$this->setRoutes($routes);
	}

}

?>