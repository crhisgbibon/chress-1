<?php

declare(strict_types=1);

namespace App\Models\System;

use App\Attributes\Route;
use App\Exceptions\RouteNotFoundException;

class Router
{
  private array $routes;

  public function registerRoutesFromControllerAttributes(array $controllers)
  {
    foreach($controllers as $controller)
    {
      $reflectionController = new \ReflectionClass($controller);

      foreach($reflectionController->getMethods() as $method)
      {
        $attributes = $method->getAttributes(Route::class, \ReflectionAttribute::IS_INSTANCEOF);

        foreach($attributes as $attribute)
        {
          $route = $attribute->newInstance();

          $newRoute = explode("/", $route->routePath);

          $arr = [];

          foreach($newRoute as $subroute){
            if(strlen($subroute) > 0 && $subroute[0] === '{')
            {
              array_push($arr, 'x');
            }
            else
            {
              array_push($arr, $subroute);
            }
          }

          $arr = implode('/', $arr);

          $this->register($route->method, $arr, $route->routePath, [$controller, $method->getName()]);
        }
      }
    }

    // foreach($this->routes as $route)
    // {
    //   var_dump($route);
    // }

    // var_dump($this->routes);
  }

  public function register(string $requestMethod, string $route, string $original, callable|array $action): self
  {
    $this->routes[$requestMethod][$route] = [ 'action' => $action, 'original' => $original];
    return $this;
  }

  public function get(string $route, callable|array $action): self
  {
    return $this->register('get', $route, $action);
  }

  public function post(string $route, callable|array $action): self
  {
    return $this->register('post', $route, $action);
  }

  public function routes(): array
  {
    return $this->routes;
  }

  public function resolve(string $requestUri, string $requestMethod)
  {
    // get the primary route prior to any GET queries
    $extractedRoute = explode('?', $requestUri)[0];

    // var_dump($extractedRoute);

    // get the abstracted route from the primary route
    $routeToCheck = explode("/", $extractedRoute);
    $abstractRoute = [];
    for($i = 1; $i < count($routeToCheck); $i++)
    {
      if(ctype_digit($routeToCheck[$i])) array_push($abstractRoute, 'x');
      else array_push($abstractRoute, $routeToCheck[$i]);
    }
    $abstractRoute = '/' . implode('/', $abstractRoute);

    // var_dump($abstractRoute);

    // identify the abstract route action and original string to allocate any get params
    $action = $this->routes[$requestMethod][$abstractRoute]['action'] ?? null;
    $original = $this->routes[$requestMethod][$abstractRoute]['original'] ?? null;

    // var_dump($action);
    // var_dump($original);

    if(!$action)
    {
      throw new RouteNotFoundException();
    }

    // use the original string to identify param locations, then extract these from the actual entered route

    // var_dump($original);

    //will store all the parameters value in this array
    $params = [];

    //will store all the parameters names in this array
    $paramKey = [];

    //finding if there is any {?} parameter in $route
    preg_match_all("/(?<={).+?(?=})/", $original, $paramMatches);

    // //if the route does not contain any param call simpleRoute();
    // if(empty($paramMatches[0])){
    //     $this->simpleRoute($file,$route);
    //     return;
    // }

    //setting parameters names
    foreach($paramMatches[0] as $key){
        $paramKey[] = $key;
    }

   
    //replacing first and last forward slashes
    //$_REQUEST['uri'] will be empty if req uri is /

    // if(!empty($_REQUEST['uri'])){
    //     $route = preg_replace("/(^\/)|(\/$)/","",$route);
    //     $reqUri =  preg_replace("/(^\/)|(\/$)/","",$_REQUEST['uri']);
    // }else{
    //     $reqUri = "/";
    // }

    //exploding route address
    $uri = explode("/", $original);

    //will store index number where {?} parameter is required in the $route 
    $indexNum = []; 

    //storing index number, where {?} parameter is required with the help of regex
    foreach($uri as $index => $param){
        if(preg_match("/{.*}/", $param)){
            $indexNum[] = $index;
        }
    }

    // var_dump($indexNum);

    //exploding request uri string to array to get
    //the exact index number value of parameter from $_REQUEST['uri']
    $reqUri = explode("/", $extractedRoute);

    //running for each loop to set the exact index number with reg expression
    //this will help in matching route
    foreach($indexNum as $key => $index){

         //in case if req uri with param index is empty then return
        //because url is not valid for this route
        if(empty($uri[$index])){
            return;
        }

        //setting params with params names
        $params[$paramKey[$key]] = $reqUri[$index];

        //this is to create a regex for comparing route address
        $reqUri[$index] = "{.*}";
    }

    // var_dump($params);

    if(is_callable($action))
    {
      return call_user_func($action($params));
    }

    if(is_array($action))
    {
      [$class, $method] = $action;

      if (class_exists($class))
      {
        $class = new $class();

        if(method_exists($class, $method))
        {
          return call_user_func_array([$class, $method], [$params]);
        }
      }
    }

    throw new RouteNotFoundException();
  }
}