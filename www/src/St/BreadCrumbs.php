<?php

namespace St;

class BreadCrumbs
{
    /**
     * Статическое свойство, которая хранит себя
     * @var BreadCrumbs|null
     */
    protected static ?self $instance = null;
    /**
     * Хранит хлебные крошки
     * @var BreadCrumbsItem[]
     */
    protected array $bread_crumbs = array();

    /**
     * Объект для доступа
     * @return BreadCrumbs|null
     */
    public static function getInstance(): ?BreadCrumbs
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Отключаем возможность создавать объект без использования статичного метода
     */
    private function __construct()
    {

    }

    /**
     * Добавляет объект хлебных крошек к хлебным крошкам
     * @param BreadCrumbsItem $bread_crumbs_item
     * @return $this
     */
    public function add(BreadCrumbsItem $bread_crumbs_item): BreadCrumbs
    {
        $this->bread_crumbs[] = $bread_crumbs_item;
        return $this;
    }

    /**
     * Возвращает объекты хлебных крошек
     * @return BreadCrumbsItem[]
     */
    public function get(): array
    {
        return $this->bread_crumbs;
    }

}