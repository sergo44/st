<?php

namespace St\Sights\Views;

use Override;
use St\City;
use St\Region;
use St\Result;
use St\Views\Common\ILeftFilterView;
use St\Views\HtmlView;

class SightFilterHtmlView extends HtmlView implements ILeftFilterView
{
    /**
     * Регионы для отображения
     * @var Region[]
     */
    protected array $regions = array();
    /**
     * Города для отображения
     * @var City[]
     */
    protected array $cities = array();
    /**
     * Входные данные (нужно для фильтра)
     * @var array
     */
    protected array $input_data = array();

    /**
     * Возвращает regions
     * @return array
     * @see regions
     */
    public function getRegions(): array
    {
        return $this->regions;
    }

    /**
     * Устанавливает regions
     * @param array $regions
     * @return SightFilterHtmlView
     * @see regions
     */
    public function setRegions(array $regions): SightFilterHtmlView
    {
        $this->regions = $regions;
        return $this;
    }

    /**
     * Возвращает cities
     * @return array
     * @see cities
     */
    public function getCities(): array
    {
        return $this->cities;
    }

    /**
     * Устанавливает cities
     * @param array $cities
     * @return SightFilterHtmlView
     * @see cities
     */
    public function setCities(array $cities): SightFilterHtmlView
    {
        $this->cities = $cities;
        return $this;
    }

    /**
     * Возвращает input_data
     * @return array
     * @see input_data
     */
    public function getInputData(): array
    {
        return $this->input_data;
    }

    /**
     * Устанавливает input_data
     * @param array $input_data
     * @return SightFilterHtmlView
     * @see input_data
     */
    public function setInputData(array $input_data): SightFilterHtmlView
    {
        $this->input_data = $input_data;
        return $this;
    }

    /**
     * Помощник поиска
     * @param int $seek
     * @param string $index
     * @return string
     */
    protected function _checked(int $seek, string $index): string
    {
        $input = $this->input_data[$index] ?? array();
        return in_array($seek, $input) ? " checked" : "";
    }

    /**
     * Вывод шаблона
     * @return void
     */
    #[Override] public function out(): void
    {
        $f = 0;
        ?>

        <form action="?" method="get" id="jLeftFilterForm">
            <div class="section-catalog__filters d-flex justify-content-between align-items-center">
                Фильтры
                <a class="link-warning j-reset-left-filter" href="#">Сбросить</a>
            </div>

            <ul class="section-catalog__filters-list">
                <li>
                    <h5>Регион</h5>
                    <ul class="section-catalog__filter-items2   ">
                        <?php foreach ($this->getRegions() as $region):?>
                        <li class="d-flex align-items-center gap-3">
                            <input id="filterItem-<?php print ++$f;?>" class="flex-shrink-0 j-filter-inp" name="region[]" value="<?php print $region->getRegionId();?>" type="checkbox" title="Filter checkbox"<?php print $this->_checked($region->getRegionId(), "region");?>>
                            <label for="filterItem-<?php print $f;?>"><?php print $region->getName();?></label>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </li>
            </ul>

            <ul class="section-catalog__filters-list">
                <li>
                    <h5>Локация</h5>
                    <ul class="section-catalog__filter-items2   ">
                        <?php foreach ($this->getCities() as $city):?>
                            <li class="d-flex align-items-center gap-3">
                                <input id="filterItem-<?php print ++$f;?>" class="flex-shrink-0 j-filter-inp" name="city[]" value="<?php print $city->getCityId();?>" type="checkbox" title="Filter checkbox"<?php print $this->_checked($city->getCityId(), "city");?>>
                                <label for="filterItem-<?php print $f;?>"><?php print $city->getName();?></label>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </li>
            </ul>

            <div class="section-catalog__filter-fulfil">
                <button class="btn btn-warning" href="#" style="width: 100%">Применить</button>
                <a class="btn btn-outline-secondary j-reset-left-filter" href="#">Сбросить</a>
            </div>
        </form>

        <?php
    }


}