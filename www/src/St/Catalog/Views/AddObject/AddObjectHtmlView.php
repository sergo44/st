<?php

namespace St\Catalog\Views\AddObject;

use St\Auth;
use St\CatalogObject;
use St\CatalogObjectType;
use St\City;
use St\Country;
use St\Views\HtmlView;
use St\Views\IView;

class AddObjectHtmlView extends HtmlView implements IView, IAddObjectView
{
    /**
     * Объект каталога для отображения
     * @var CatalogObject
     */
    protected CatalogObject $catalog_object;
    /**
     * Список стран для отображения
     * @var Country[]
     */
    protected array $countries_list;
    /**
     * Список городов для отображения
     * @var City[]
     */
    protected array $cities_list = array();

    /**
     * Устанавливает catalog_object
     * @param CatalogObject $catalog_object
     * @return AddObjectHtmlView
     * @see catalog_object
     */
    public function setCatalogObject(CatalogObject $catalog_object): AddObjectHtmlView
    {
        $this->catalog_object = $catalog_object;
        return $this;
    }

    /**
     * Устанавливает countries_list
     * @param array $countries_list
     * @return AddObjectHtmlView
     * @see countries_list
     */
    public function setCountriesList(array $countries_list): AddObjectHtmlView
    {
        $this->countries_list = $countries_list;
        return $this;
    }

    /**
     * Шаблон вывода формы добавления размещения
     * @return void
     */
    #[\Override] public function out(): void
    {
        ?>

        <div class="section-profile__wrapper-block">
            <div class="section-profile__inputs">

                <form class="entry-form mt-5">
                    <div class="section-profile__one-block">
                        <h5>Общая информация</h5>
                        <div class="d-flex gap-5 flex-wrap">
                            <div class="mb-0 mb-sm-5 position-relative wrapper-services-input" style="width:30rem">
                                <svg class="position-absolute" fill="none" height="8" viewBox="0 0 14 8" width="14"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M13.25 0.5L7 6.75L0.75 0.5" stroke="#000" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <label class="form-label" for="objectType">Выберите вид объекта<span>*</span></label>
                                <input type="hidden" name="object_type" value="">
                                <input class="form-control input-services-list" id="objectType" placeholder="Не выбрано" required type="text">
                                <ul class="add-adv__services-list position-absolute w-100">
                                    <?php foreach (CatalogObjectType::getSelectOptions() as $value => $option):?>
                                        <li><a class="d-block" href="#" data-value="<?php print $this->escape($value)?>"><?php print $option;?></a></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <div class="mb-5 position-relative wrapper-services-input" style="width:30rem">
                                <label class="form-label" for="objectName">Укажите название объекта<span>*</span></label>
                                <input class="form-control input-services-list" name="name" id="objectName" placeholder="Не указано" required type="text">
                            </div>
                        </div>
                    </div>

                    <div class="section-profile__one-block">
                        <h5>Адрес объекта</h5>
                        <div class="d-flex gap-5 flex-wrap">
                            <div class="mb-0 mb-sm-5 position-relative wrapper-services-input" style="width:30rem">
                                <svg class="position-absolute" fill="none" height="8" viewBox="0 0 14 8" width="14"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M13.25 0.5L7 6.75L0.75 0.5" stroke="#000" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <label class="form-label" for="objectCountry">Страна<span>*</span></label>
                                <input type="hidden" name="country_id" value="">
                                <input class="form-control input-services-list" id="objectCountry" placeholder="Не выбрано" required type="text">
                                <ul class="add-adv__services-list position-absolute w-100">
                                    <?php foreach ($this->countries_list as $country):?>
                                        <li><a class="d-block" href="#" data-value="<?php print $country->getCountryId()?>" data-toggle-country="1"><?php print $country->getName();?></a></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <div class="mb-0 mb-sm-5 position-relative wrapper-services-input stSelectRegion" style="width:30rem">
                                <svg class="position-absolute" fill="none" height="8" viewBox="0 0 14 8" width="14"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M13.25 0.5L7 6.75L0.75 0.5" stroke="#000" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <label class="form-label" for="objectRegion">Регион<span>*</span></label>
                                <input type="hidden" name="region_id" value="">
                                <input class="form-control input-services-list" id="objectRegion" placeholder="Не выбрано" required type="text" readonly>
                                <ul class="add-adv__services-list position-absolute w-100 j-region-ul-list">
                                    <li>Выберите страну</li>
                                </ul>
                            </div>
                        </div>
                        <div class="d-flex gap-5 flex-wrap">
                            <div class="mb-0 mb-sm-5 position-relative wrapper-services-input" style="width:30rem">
                                <svg class="position-absolute" fill="none" height="8" viewBox="0 0 14 8" width="14"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M13.25 0.5L7 6.75L0.75 0.5" stroke="#000" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <label class="form-label" for="objectCountry">Населенный пункт<span>*</span></label>
                                <input type="hidden" name="city_id" value="">
                                <input class="form-control input-services-list" id="objectCity" placeholder="Не выбрано" required type="text" readonly>
                                <ul class="add-adv__services-list position-absolute w-100 j-city-ul-list">
                                    <li class="text-muted">Выберите регион</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <button class="btn btn-warning col-auto mt-5" role="button" type="submit">Сохранить изменения</button>
                </form>
            </div>
        </div>

        <?php
    }

}