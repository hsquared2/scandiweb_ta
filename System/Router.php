<?php

namespace System;

class Router {
	protected string $baseUrl;
	protected int $baseShift;
	protected array $routes = [];

	public function __construct(string $baseUrl = ''){
		$this->baseUrl = $baseUrl;
		$this->baseShift = strlen($this->baseUrl);
	}

	public function addRoute(string $regExp, string $name, string $method = 'index') : void{
		$this->routes[] = [
			'path' => $regExp,
			'c' => $name,
			'm' => $method,
		];
	}

	public function resolvePath(string $url) : array{
		$relativeUrl = substr($url, $this->baseShift);
		$route = $this->findPath($relativeUrl);
		$controller = new $route['c']();

		return [
			'controller' => $controller,
			'method' => $route['m']
		];
	}

	protected function findPath(string $url) : ?array{
		$activeRoute = null;

		foreach($this->routes as $route){
			if($url === $route['path']){
				$activeRoute = $route;
			}
		}

		if($activeRoute === null){
			return null;
		}

		return $activeRoute;
	}
}