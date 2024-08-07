<?php

namespace St\Sights\Views\AddSight;

use Override;
use St\Country;
use St\Sights\Sight;
use St\Views\HtmlView;
use St\Views\IView;

class AddSightHtmlView extends HtmlView implements IView
{
    /**
     * Список стран
     * @var Country[]
     */
    protected array $countries_list = array();
    /**
     * Объект
     * @var Sight|null
     */
    protected ?Sight $sight = null;
    /**
     * Показать успешное окно
     * @var bool
     */
    protected bool $show_success_window = false;

    /**
     * Возвращает countries_list
     * @return array
     * @see countries_list
     */
    public function getCountriesList(): array
    {
        return $this->countries_list;
    }

    /**
     * Устанавливает countries_list
     * @param array $countries_list
     * @return AddSightHtmlView
     * @see countries_list
     */
    public function setCountriesList(array $countries_list): AddSightHtmlView
    {
        $this->countries_list = $countries_list;
        return $this;
    }

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
     * @return AddSightHtmlView
     * @see sight
     */
    public function setSight(?Sight $sight): AddSightHtmlView
    {
        $this->sight = $sight;
        return $this;
    }

    /**
     * Возвращает show_success_window
     * @return bool
     * @see show_success_window
     */
    public function isShowSuccessWindow(): bool
    {
        return $this->show_success_window;
    }

    /**
     * Устанавливает show_success_window
     * @param bool $show_success_window
     * @return AddSightHtmlView
     * @see show_success_window
     */
    public function setShowSuccessWindow(bool $show_success_window): AddSightHtmlView
    {
        $this->show_success_window = $show_success_window;
        return $this;
    }

    /**
     * @inheritdoc
     * @return void
     */
    #[Override] public function out(): void
    {
        ?>

        <?php if ($this->show_success_window):?>
            <div class="alert alert-success">
                <h4>ОК</h4>
                <p>Достопримечательность успшено добавлена и будет отображена после того, как ее проверит администратор ресурса</p>
            </div>

        <?php else: ?>

            <div class="pt-3">
                <form action="/Sights/Add/Go" method="post" enctype="multipart/form-data">

                    <h5>Локация</h5>
                    <div class="d-flex gap-5 flex-wrap">
                        <div class="mb-0 mb-sm-5 position-relative wrapper-services-input" style="width:30rem">
                            <svg class="position-absolute" fill="none" height="8" viewBox="0 0 14 8" width="14"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path d="M13.25 0.5L7 6.75L0.75 0.5" stroke="#000" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <label class="form-label" for="objectCountry">Страна<span>*</span></label>
                            <input type="hidden" name="country_id" value="<?php print $this->sight?->getCountryId()?>">
                            <input class="form-control input-services-list" id="objectCountry" placeholder="Не выбрано" required type="text" value="">
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
                            <input type="hidden" name="region_id"  value="<?php print $this->sight?->getRegionId()?>">
                            <input class="form-control input-services-list" id="objectRegion" placeholder="Не выбрано" required type="text" readonly value="">
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
                            <label class="form-label" for="objectCity">Населенный пункт<span>*</span></label>
                            <input type="hidden" name="city_id" value="<?php print $this->sight?->getCityId()?>">
                            <input class="form-control input-services-list" id="objectCity" placeholder="Не выбрано" required type="text" readonly value="">
                            <ul class="add-adv__services-list position-absolute w-100 j-city-ul-list">
                                <li class="text-muted">Выберите регион</li>
                            </ul>
                        </div>
                    </div>

                    <div class="d-flex gap-5 flex-wrap" style="margin-bottom: 1rem">
                        <div class="mb-0 position-relative wrapper-services-input" style="width:30rem">
                            <label class="form-label" for="objectLat">Широта<span>*</span></label>
                            <input type="text" class="form-control input-services-list" id="objectLat" name="lat" value="<?php print $this->escape($this->sight?->getLat());?>" data-type="setLat" readonly>
                        </div>
                        <div class="mb-0 position-relative wrapper-services-input" style="width:30rem">
                            <label class="form-label" for="objectLon">Долгота<span>*</span></label>
                            <input type="text" class="form-control input-services-list" id="objectLon" name="lon" value="<?php print $this->escape($this->sight?->getLat());?>" data-type="setLon" readonly>
                        </div>
                    </div>

                    <?php if ($this->sight?->getLat() > 0 && $this->sight?->getLon() > 0):?>
                        <script>
                            let jsEditObjectLocation = {lat: <?php print $this->sight?->getLat()?>, lon: <?php  print $this->sight?->getLon()?>}
                        </script>
                    <?php endif; ?>

                    <div class="mb-5 position-relative wrapper-services-input" style="width:30rem;">
                        <button type="button" class="btn btn-warning btn-lg" data-bs-toggle="modal" data-bs-target="#setCoordinatesModal">Указать объект на карте</button>
                    </div>

                    <h5 style="margin-bottom: 1.2rem; margin-top: 1.2rem">Фотографии</h5>
                    <div class="add-new-adv__photos d-flex gap-4" id="jsObjectPhotos">
                        <?php foreach ($this->sight? $this->sight->getImages() : array() as $image):?>
                            <div style="position: relative">
                                <img src="<?php print $image->getUri(150, 150, true)?>" alt="" data-image-id="<?php print $image->getImageId()?>">
                                <a class="jsEditObjectRemoveImage" style="position: absolute; top: -10px; right: -10px;" href="#" data-image-id="<?php print $image->getImageId()?>"><svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M16 3C13.4288 3 10.9154 3.76244 8.77759 5.1909C6.63975 6.61935 4.97351 8.64968 3.98957 11.0251C3.00563 13.4006 2.74819 16.0144 3.2498 18.5362C3.75141 21.0579 4.98953 23.3743 6.80762 25.1924C8.6257 27.0105 10.9421 28.2486 13.4638 28.7502C15.9856 29.2518 18.5995 28.9944 20.9749 28.0104C23.3503 27.0265 25.3807 25.3603 26.8091 23.2224C28.2376 21.0846 29 18.5712 29 16C28.996 12.5534 27.6251 9.24912 25.188 6.81201C22.7509 4.3749 19.4466 3.00398 16 3ZM20.707 19.293C20.8 19.3858 20.8739 19.496 20.9242 19.6174C20.9746 19.7387 21.0006 19.8688 21.0007 20.0002C21.0007 20.1316 20.9749 20.2617 20.9246 20.3832C20.8744 20.5046 20.8007 20.6149 20.7078 20.7078C20.6149 20.8007 20.5046 20.8744 20.3832 20.9246C20.2617 20.9749 20.1316 21.0007 20.0002 21.0006C19.8688 21.0006 19.7387 20.9746 19.6174 20.9242C19.496 20.8738 19.3858 20.8 19.293 20.707L16 17.4141L12.707 20.707C12.5195 20.8942 12.2652 20.9993 12.0002 20.9991C11.7352 20.999 11.4811 20.8937 11.2937 20.7063C11.1063 20.5189 11.001 20.2648 11.0009 19.9998C11.0007 19.7348 11.1058 19.4806 11.293 19.293L14.5859 16L11.293 12.707C11.1058 12.5194 11.0007 12.2652 11.0009 12.0002C11.001 11.7352 11.1063 11.4811 11.2937 11.2937C11.4811 11.1063 11.7352 11.001 12.0002 11.0009C12.2652 11.0007 12.5195 11.1058 12.707 11.293L16 14.5859L19.293 11.293C19.4806 11.1058 19.7348 11.0007 19.9998 11.0009C20.2648 11.001 20.5189 11.1063 20.7063 11.2937C20.8937 11.4811 20.999 11.7352 20.9991 12.0002C20.9993 12.2652 20.8942 12.5194 20.707 12.707L17.4141 16L20.707 19.293Z" fill="black"/>
                                    </svg></a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="add-new-adv__photos d-flex gap-4" style="margin-top: 1rem; margin-bottom: 1rem">
                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#jsAddImageModal">Загрузить фотографию</button>
                    </div>

                    <h5>Общая информация</h5>

                    <div class="mb-5 d-flex gap-5 flex-wrap">
                        <div class="mb-0 col-sm-5 wrapper-services-input" style="width:63rem">
                            <label class="form-label" for="inputName">Название объекта<span>*</span></label>
                            <input class="form-control input-services-list" id="inputName" name="name" placeholder="Укажите название объекта" required="required" type="text" value="">
                        </div>
                    </div>

                    <div class="mb-5 d-flex gap-5 flex-wrap">
                        <div class="mb-0 position-relative wrapper-services-input wrapper-services-textarea">
                            <label class="form-label" for="inputDescription">Описание объекта<span>*</span></label>
                            <textarea class="form-control input-services-list h-100" id="inputDescription" name="description"><?php print $this->escape($this->sight?->getDescription());?></textarea>
                        </div>
                    </div>

                    <div class="mb-5 d-flex gap-5 flex-wrap">
                        <div class="mb-5 position-relative wrapper-services-input wrapper-services-textarea">
                            <label class="form-label" for="inputOperationMode">Условия и режим работы</label>
                            <textarea class="form-control input-services-list h-100" id="inputOperationMode" name="operation_mode"><?php print $this->escape($this->sight?->getOperatingMode());?></textarea>
                        </div>
                    </div>

                    <div class="mb-5 d-flex gap-5 flex-wrap">
                        <div class="mb-0 col-sm-5 wrapper-services-input" style="width:63rem">
                            <label class="form-label" for="inputPrice">Стоимость посещения</label>
                            <input class="form-control input-services-list" id="inputPrice" name="price" placeholder="Укажите стоимость посещения" required="required" type="text" value="">
                        </div>
                    </div>

                    <div class="mb-5 d-flex gap-5 flex-wrap">
                        <div class="mb-0 col-sm-5 wrapper-services-input" style="width:63rem">
                            <label class="form-label" for="inputContactPhone">Контактный номер телефона</label>
                            <input class="form-control input-services-list" id="inputContactPhone" name="contact_phone" placeholder="Укажите номер телефона (при наличии)" required="required" type="text" value="">
                        </div>
                    </div>

                    <div class="mb-5 d-flex gap-5 flex-wrap">
                        <div class="mb-0 col-sm-5 wrapper-services-input" style="width:63rem">
                            <label class="form-label" for="inputContactEmail">Контактный адрес электронной почты</label>
                            <input class="form-control input-services-list" id="inputContactEmail" name="contact_email" placeholder="Укажите адрес электронной почты (при наличии)" required="required" type="text" value="">
                        </div>
                    </div>

                    <div class="mb-5 d-flex gap-5 flex-wrap">
                        <div class="mb-0 col-sm-5 wrapper-services-input" style="width:63rem">
                            <label class="form-label" for="inputWebSiteUrl">Адрес веб сайта</label>
                            <input class="form-control input-services-list" id="inputWebSiteUrl" name="web_site_url" placeholder="Укажите адрес веб сайта (при наличии)" required="required" type="text" value="">
                        </div>
                    </div>

                    <button class="btn btn-warning col-auto mt-5" role="button" type="submit"><?php print $this->sight?->getSightId() ? "Сохранить изменения" : "Добавить объект";?></button>

                </form>
            </div>
        <?php endif; ?>

        <!-- Modal -->
        <div class="modal modal-lg fade" id="setCoordinatesModal" tabindex="-1" role="dialog" aria-labelledby="chooseCoordinatesModal" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="chooseCoordinatesModal">Укажите местоположение объекта</h4>
                    </div>
                    <div class="modal-body">
                        <div id="setCoordinatesCnt" style="width: 100%; height: 400px"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal modal-lg fade" id="jsAddImageModal" tabindex="-1" role="dialog" aria-labelledby="addPhotoLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="/Images/Upload" id="jsUploadImageForm" method="post" enctype="multipart/form-data">
                        <div class="modal-header">
                            <h4 class="modal-title" id="addPhotoLabel">Добавление фотографии</h4>
                        </div>

                        <div class="modal-body">
                            <div style="width: 100%; text-align: center;">
                                <img id="jsSetAreaImage" src="/images/no-image.svg" width="300rem" title="Image" alt="" />
                                <p><input id="jsSelectFileInt" type="file" name="image[]" value="" title="Укажите фото для загрузки"></p>
                            </div>
                            <div id="jsUploadImageErrorCnt"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-warning" id="jsUploadImageBtn">Загрузить</button>
                            <button type="button" class="btn btn-warning" id="jsSetAreaBtn">Сохранить область</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <?php
    }

}