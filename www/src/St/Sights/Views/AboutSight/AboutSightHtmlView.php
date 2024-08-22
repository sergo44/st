<?php

namespace St\Sights\Views\AboutSight;

use Override;
use St\ApplicationError;
use St\Auth;
use St\Sights\Sight;
use St\Views\HtmlView;
use St\Views\IView;

class AboutSightHtmlView extends HtmlView implements IView
{
    /**
     * Достопримечательность, которую выводим
     * @var Sight
     */
    protected Sight $sight;

    /**
     * Возвращает sight
     * @return Sight
     * @see sight
     */
    public function getSight(): Sight
    {
        return $this->sight;
    }

    /**
     * Устанавливает sight
     * @param Sight $sight
     * @return AboutSightHtmlView
     * @see sight
     */
    public function setSight(Sight $sight): AboutSightHtmlView
    {
        $this->sight = $sight;
        return $this;
    }

    /**
     * @inheritdoc
     * @return void
     * @throws ApplicationError
     */
    #[Override] public function out(): void
    {
        ?>

        <div class="card-raiting d-flex align-items-center gap-3">
            <span>4.9</span>
            <div class="card-raiting__wrapper-stars">
                <img alt="One score" src="/images/icons/star.svg">
                <img alt="Two score" src="/images/icons/star.svg">
                <img alt="Three score" src="/images/icons/star.svg">
                <img alt="Four score" src="/images/icons/star.svg">
                <img alt="Five score" src="/images/icons/semi-star.svg">
            </div>
        </div>
        <div class="section-object__text-under-title">

            <div class="section-object__wrapper-photos d-grid">
                <div class="section-object__wrapper-main-image">
                    <a href="/<?php print $this->sight->getMainImage()->getUri(2000, 2000, true);?>" data-fancybox="sight-<?php print $this->sight->getSightId();?>">
                        <img alt="" class="w-100 h-100 object-fit-cover" src="/<?php print $this->sight->getMainImage()->getUri(633, 633, true)?>">
                    </a>
                </div>

                <?php foreach ($this->getSight()->getAdditionalImages(4) as $key => $image):?>
                    <div class="section-object__wrapper-image<?php if ($key === 3 && sizeof($this->getSight()->getImages()) > 4):?> position-relative<?php endif;?>">
                        <?php if ($key === 3 && sizeof($this->getSight()->getImages()) > 4):?>
                            <a href="/<?php print $image->getUri(2000, 2000);?>" data-fancybox="sight-<?php print $this->sight->getSightId();?>" class="overlay-object-foto"><?php print sizeof($this->sight->getImages());?> фото</a>
                        <?php endif;?>
                        <a href="/<?php print $image->getUri(2000, 2000);?>" data-fancybox="sight-<?php print $this->sight->getSightId();?>">
                            <img alt="" class="w-100 h-100 object-fit-cover" src="/<?php print $image->getUri(296, 296, true)?>">
                        </a>

                    </div>
                <?php endforeach; ?>

                <?php if (sizeof($this->getSight()->getImages()) > 0):?>
                <div class="d-none">
                <?php foreach (array_slice($this->getSight()->getImages(), 4) as $image):?>
                    <a href="/<?php print $image->getUri(2000, 2000);?>" data-fancybox="sight-<?php print $this->sight->getSightId();?>">
                        <img alt="" class="w-100 h-100 object-fit-cover" src="/<?php print $image->getUri(296, 296, true)?>">
                    </a>
                <?php endforeach;?>
                </div>
                <?php endif;?>
            </div>
            <div class="section-object__wrapper-description d-grid">
                <div class="section-object__description">
                    <h3>Описание</h3>
                    <?php print $this->sight->getDescription();?>
                </div>
                <div class="we-have">
                    <div class="section-object__check">
                        Уточнить дополнительную информацию
                    </div>
                    <div class="tel-title">Тел.</div>
                    <div class="tel-value"><?php print $this->sight->getContactPhone();?></div>
                    <?php if ($this->sight->getContactEmail()):?>
                        <div class="tel-title">E-mail</div>
                        <div class="tel-value"><?php print $this->escape($this->sight->getContactEmail()); ?></div>
                    <?php endif; ?>
                    <?php if ($this->sight->getWebSiteUrl()):?>
                        <div class="tel-title">Сайт</div>
                        <div class="tel-value"><?php print $this->escape($this->sight->getWebSiteUrl()); ?></div>
                    <?php endif; ?>
                </div>

                <div class="section-object__wrapper-prices d-flex flex-wrap">
                    <?php if ($this->sight->getOperatingMode()):?>
                        <div class="section-object__description flex-grow-1">
                            <h3>Режим работы</h3>
                            <div class="price-value"><?php print $this->sight->getOperatingMode();?></div>
                        </div>
                    <?php endif; ?>

                    <?php if ($this->sight->getPrice()):?>
                        <div class="section-object__description flex-grow-1">
                            <h3>Стоимость посещения</h3>
                            <div class="price-value">от <?php print $this->sight->getPrice();?> руб</div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="empty-block"></div>
            </div>
        </div>


        <?php
    }


}