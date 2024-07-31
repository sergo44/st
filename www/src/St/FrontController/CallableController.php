<?php

namespace St\FrontController;

use St\BreadCrumbs;
use St\BreadCrumbsItem;
use St\Layouts\ILayout;
use St\Views\IView;

class CallableController
{
    /**
     * Входные данные
     * @var array
     */
    protected array $user_input_data = array();
    /**
     * Макет, который необходимо отображать
     * @var ILayout
     */
    protected ILayout $layout;
    /**
     * Шаблон, который необходимо отобразить
     * @var IView
     */
    protected IView $view;

    /**
     * Конструктор класса
     * @param array $user_input_data
     * @param ILayout $layout
     * @param IView $view
     */
    public function __construct(array $user_input_data, ILayout $layout, IView $view)
    {
        $this->user_input_data = $user_input_data;
        $this->layout = $layout;
        $this->view = $view;

        BreadCrumbs::getInstance()->add( new BreadCrumbsItem("Главная", "/") );
    }

    /**
     * Возвращает user_input_data
     * @param string|null $index
     * @param int|null $max_string_length
     * @return mixed Возвращает null если параметр не найден
     * @see user_input_data
     */
    public function getUserInputData(string $index = null, ?int $max_string_length = null): mixed
    {
        if (isset($index)) {
            if (isset($this->user_input_data[$index])) {
                if (is_string($this->user_input_data[$index]) && isset($max_string_length)) {
                    return mb_substr($this->user_input_data[$index], 0, $max_string_length);
                } else {
                    return $this->user_input_data[$index];
                }
            }

            return null;

        } else {
            return $this->user_input_data;
        }
    }

    /**
     * Устанавливает $user_input_data
     * @see user_input_data
     * @param array $user_input_data
     * @return $this
     */
    public function setUserInputData(array $user_input_data): CallableController
    {
        $this->user_input_data = $user_input_data;
        return $this;
    }

    /**
     * Возвращает шаблон
     * @see ILayout
     * @return ILayout
     */
    public function getLayout(): ILayout
    {
        return $this->layout;
    }

    /**
     * Устанавливает шаблон
     * @param ILayout $layout
     * @return $this
     */
    public function setLayout(ILayout $layout): CallableController
    {
        $this->layout = $layout;
        return $this;
    }

    /**
     * Возвращает вид для отображения
     * @see IView
     * @return IView
     */
    public function getView(): IView
    {
        return $this->view;
    }

    /**
     * Устанавливает вид
     * @see IView
     * @param IView $view
     * @return $this
     */
    public function setView(IView $view): CallableController
    {
        $this->view = $view;
        return $this;
    }

}