<?php

namespace St\Sights\Views\WaitSights;

use Override;
use St\Sights\Sight;
use St\Views\HtmlView;
use St\Views\IView;

class ManageSightHtmlView extends HtmlView implements IView
{
    /**
     * Достопримечательность, надо которой проводится редактирование
     * @var Sight|null
     */
    protected ?Sight $sight = null;

    /**
     * Возвращает sight
     * @return Sight|null
     * @see sight
     */
    public function getSight(): ?Sight
    {
        return $this->sight;
    }

    /**
     * Устанавливает sight
     * @param Sight|null $sight
     * @return ManageSightHtmlView
     * @see sight
     */
    public function setSight(?Sight $sight): ManageSightHtmlView
    {
        $this->sight = $sight;
        return $this;
    }

    #[Override] public function out(): void
    {
        ?>

        <?php if ($this->getResult()->isSuccess()):?>
            <div class="alert alert-success">
                <h4>Успешно</h4>
                <div>Статус объекта "<?php print $this->escape($this->sight?->getName())?>" успешно изменен на "<?php print $this->sight?->getStatusEnum()->label()?>"</div>
                <div><a href="/Sights/Wait">Вернуться к списку ожидающих объектов</a></div>
            </div>
        <?php else: ?>
            <div class="alert alert-danger">
                <h4>Ошибка</h4>
                <div><ul><li><?php print $this->getResult()->getErrorsAsString();?></li></ul></div>
                <div><a href="/Sights/Wait">Вернуться к списку ожидающих объектов</a></div>
            </div>
        <?php endif; ?>

        <?php
    }


}