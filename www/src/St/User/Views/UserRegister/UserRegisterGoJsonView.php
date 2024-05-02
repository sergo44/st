<?php

namespace St\User\Views\UserRegister;

use St\User;
use St\User\Views\Sign\UserSignedHtmlWidget;
use St\Views\IView;
use St\Views\JsonView;

class UserRegisterGoJsonView extends JsonView implements IView, \JsonSerializable, IUserRegisterGoView
{
    /**
     * Пользователь, который регистрируется
     * @var ?User
     */
     protected ?User $user = null;

    /**
     * Возвращает user
     * @return ?User
     * @see user
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * Устанавливает user
     * @param User $user
     * @return IUserRegisterGoView
     * @see user
     */
    public function setUser(User $user): IUserRegisterGoView
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @inheritDoc
     */
     #[\Override] public function jsonSerialize(): array
    {
        return array(
            "result" => $this->getResult(),
            "user" => $this->getUser(),
            "replaceWithHtml" => $this->getUser() ? (new UserSignedHtmlWidget($this->getUser()))->fetch() : null
        );
    }
}