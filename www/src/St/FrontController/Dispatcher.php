<?php

namespace St\FrontController;

class Dispatcher
{
    /**
     * Путь, который необходимо вызвать
     * @var string
     */
    protected string $path;
    /**
     * Экземпляр контроллера
     * @var ICallableController
     */
    protected ICallableController $callable_controller_entity;

    /**
     * Путь, который необходимо вызвать
     * @param string $path
     */
    public function __construct(string $path)
    {
        $this->path = $path;

        $this->path = preg_replace("#/{2,}#", "/", $this->path);

        if (!strlen($this->path)) {
            $this->path = "/";
        }
    }

    /**
     * Вызов нужного контроллера
     * @return bool
     */
    public function dispatch() : bool
    {
        return $this->routeViaFiles();
    }
    /**
     * Возвращает $path
     * @see path
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * Устанавливает path
     * @param string $path
     * @return $this
     */
    public function setPath(string $path): Dispatcher
    {
        $this->path = $path;
        return $this;
    }
    /**
     * Возвращает ICallableController
     * @return ICallableController
     */
    public function getCallableControllerEntity(): ICallableController
    {
        return $this->callable_controller_entity;
    }

    /**
     * Устанавливает $callable_controller_entity
     * @param ICallableController $callable_controller_entity
     * @return $this
     */
    public function setCallableControllerEntity(ICallableController $callable_controller_entity): self
    {
        $this->callable_controller_entity = $callable_controller_entity;
        return $this;
    }

    /**
     * Выполняет поиск маршрута, если найден,
     * то выполняем диспетчеризацию
     * @return bool
     */
    public function routeViaFiles(): bool
    {

        foreach (glob(ST_SRC_PATH . "/St/*/Routes.php") as $extended_routes) {
            $extended_routes_realpath = realpath($extended_routes);
            if ($extended_routes_realpath) {
                $ns_start = strpos($extended_routes_realpath, "/St/");
                // $ns_end = strpos($extended_routes_realpath, "Routes.php");
                $class_name = str_replace("/", "\\", substr($extended_routes_realpath, $ns_start, -4));
                $route = new $class_name ($this);
                if ($route instanceof IRoute) {
                    $called_controller = $route->tryRoute();
                    if ($called_controller) {
                        $this->setCallableControllerEntity($called_controller);
                        return true;
                    }
                } else {
                    throw new \Error("Non IRoute object was returned when call ICallableController");
                }
            }
        }

        return false;
    }
}