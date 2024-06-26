<?php

namespace St\Catalog\Views\AddObject;

use St\CatalogObject;
use St\CatalogObjectType;
use St\City;
use St\Country;
use St\Views\HtmlView;
use St\Views\IView;

class AddObjectHtmlView extends HtmlView implements IView, IAddObjectView
{
    /**
     * Объект успешно добавлен
     * @var bool
     */
    protected bool $added = false;
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
     * Возвращает added
     * @return bool
     * @see added
     */
    public function isAdded(): bool
    {
        return $this->added;
    }

    /**
     * Устанавливает added
     * @param bool $added
     * @return AddObjectHtmlView
     * @see added
     */
    public function setAdded(bool $added): AddObjectHtmlView
    {
        $this->added = $added;
        return $this;
    }

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

                <?php if ($this->added):?>

                <div class="alert alert-success">
                    <h4>Объект успешно добавлен</h4>
                    <p>Объект успешно добавлен в базу данных и будет опубликован после проверки. О результате проверки вам будет отправлено письмо. А сейчас вы можете добавить <a href="/Catalog/Objects/Add/">еще один объект</a></p>
                </div>

                <?php else: ?>

                    <form class="entry-form mt-5" action="/Catalog/Objects/Add/Go" method="post">
                        <div class="section-profile__one-block">
                            <h5>Общая информация</h5>
                            <div class="d-flex gap-5 flex-wrap">
                                <div class="mb-0 mb-sm-5 position-relative wrapper-services-input" style="width:30rem">
                                    <svg class="position-absolute" fill="none" height="8" viewBox="0 0 14 8" width="14"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path d="M13.25 0.5L7 6.75L0.75 0.5" stroke="#000" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <label class="form-label" for="objectType">Выберите вид объекта<span>*</span></label>
                                    <input type="hidden" name="object_type" value="<?php print $this->catalog_object->getObjectType(); ?>">
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
                                    <input type="hidden" name="country_id" value="<?php print $this->catalog_object->getCountryId()?>">
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
                                    <label class="form-label" for="objectCity">Населенный пункт<span>*</span></label>
                                    <input type="hidden" name="city_id" value="<?php print $this->catalog_object->getCityId();?>">
                                    <input class="form-control input-services-list" id="objectCity" placeholder="Не выбрано" required type="text" readonly>
                                    <ul class="add-adv__services-list position-absolute w-100 j-city-ul-list">
                                        <li class="text-muted">Выберите регион</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="mb-5 position-relative wrapper-services-input" style="width:30rem">
                                <label class="form-label" for="addressLine">Введите адрес объекта<span>*</span></label>
                                <input class="form-control input-services-list" id="addressLine" name="address_lines" placeholder="Не выбрано" required type="text" />
                            </div>
                        </div>

                        <h5>Укажите адрес объекта на карте</h5>
                        <div class="d-flex gap-5 flex-wrap" style="margin-bottom: 1rem">
                            <div class="mb-0 position-relative wrapper-services-input" style="width:30rem">
                                <label class="form-label" for="objectLat">Широта<span>*</span></label>
                                <input type="text" class="form-control input-services-list" id="objectLat" name="lat" value="" data-type="setLat" readonly>
                            </div>
                            <div class="mb-0 position-relative wrapper-services-input" style="width:30rem">
                                <label class="form-label" for="objectLon">Долгота<span>*</span></label>
                                <input type="text" class="form-control input-services-list" id="objectLon" name="lon" value="" data-type="setLon" readonly>
                            </div>
                        </div>

                        <div class="mb-5 position-relative wrapper-services-input" style="width:30rem;">
                            <button type="button" class="btn btn-warning btn-lg" data-bs-toggle="modal" data-bs-target="#setCoordinatesModal">Указать объект на карте</button>
                        </div>

                        <h5>Общая информация</h5>
                        <div class="d-flex gap-5 flex-wrap">
                            <div class="mb-5 position-relative wrapper-services-input wrapper-services-textarea">
                                <label class="form-label" for="objectDescription">Описание объекта<span>*</span></label>
                                <textarea class="form-control input-services-list h-100" id="objectDescription" name="description"><?php print $this->escape($this->catalog_object->getDescription());?></textarea>
                            </div>
                        </div>

                        <h5 style="margin-bottom: 1.2rem; margin-top: 1.2rem">Фотографии</h5>
                        <div class="add-new-adv__photos d-flex gap-4" id="jsObjectPhotos"></div>
                        <div class="add-new-adv__photos d-flex gap-4" style="margin-top: 1rem; margin-bottom: 1rem">
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#jsAddImageModal">Загрузить фотографию</button>
                        </div>

                        <div class="add-new-adv__wrapper-input mb-5 mt-5">
                            <h5>Номера</h5>
                            <ul id="jsAddObjectRooms" class="section-ads__numbers add-adv__numbers-list p-0" style="display: block;"></ul>
                            <a class="btn btn-warning w-auto d-inline-block" data-bs-toggle="modal" data-bs-target="#addHotelRoomModal" href="#">Добавить номер</a>
                        </div>

                        <div class="section-profile__one-block">
                            <h5>Дополнительно</h5>

                            <div class="d-flex gap-5 flex-wrap">
                                <div class="mb-0 position-relative wrapper-services-input wrapper-services-textarea">
                                    <label class="form-label" for="includeFoods">Информация о питании<span>*</span></label>
                                    <textarea class="form-control input-services-list h-100" id="includeFoods" name="include_foods"><?php print $this->escape($this->catalog_object->getIncludeFoods());?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="section-profile__one-block">
                            <h5>Цены</h5>

                            <div class="d-flex gap-5 flex-wrap">
                                <div class="mb-0 mb-sm-5 position-relative wrapper-services-input">
                                    <label class="form-label" for="startPrice">Цена (от):</label>
                                    <input class="form-control input-services-list" id="startPrice" name="start_price" placeholder="Цена (от) в рублях" required="" type="number">
                                </div>
                            </div>
                        </div>

                        <div class="add-new-adv__wrapper-input mb-5">
                            <h5>Контакты</h5>
                            <div class="d-flex gap-5 flex-wrap">
                                <div class="mb-0 mb-sm-5 position-relative wrapper-services-input" style="width:30rem">
                                    <label class="form-label" for="contactPhone">Введите номер телефона<span>*</span></label>
                                    <input class="form-control input-services-list" id="contactPhone" name="contact_phone" placeholder="+7 (999) 999-99-99" required="" type="tel">
                                </div>
                            </div>
                            <div class="d-flex gap-5 flex-wrap">
                                <div class="mb-0 mb-sm-5 position-relative wrapper-services-input" style="width:30rem">
                                    <label class="form-label" for="contactEmail">Введите адрес электронной почты</label>
                                    <input class="form-control input-services-list" id="contactEmail" name="contact_email" placeholder="example@example.ru" type="email">
                                </div>
                                <div class="mb-5 position-relative wrapper-services-input" style="width:30rem">
                                    <label class="form-label" for="webSiteUrl">Введите адрес сайта</label>
                                    <input class="form-control input-services-list" id="webSiteUrl" name="web_site_url" placeholder="www.example.ru" type="text">
                                </div>
                            </div>
                        </div>

                        <button class="btn btn-warning col-auto mt-5" role="button" type="submit">Добавить объект</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>

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
                                <p><input type="file" name="image[]" value="" title="Укажите фото для загрузки"></p>
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

        <!-- Modal -->
        <div class="modal modal-lg fade" id="addHotelRoomModal" tabindex="-1" role="dialog" aria-labelledby="addHotelRoomModal" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="/Catalog/Objects/Add/AddHotelRoom/Go" method="post" enctype="multipart/form-data" id="jsAddHotelRoomForm">
                        <div class="modal-header">
                            <h4 class="modal-title" id="addPhotoLabel">Добавление номера</h4>
                        </div>

                        <div class="modal-body">
                            <div class="d-flex flex-wrap">
                                <div class="mb-0 position-relative wrapper-services-input" style="width: 100%">
                                    <label class="form-label" for="addHotelRoomImage">Укажите фотографию номера<span>*</span></label>
                                    <input type="file" class="form-control" name="add_hotel_room_image" id="addHotelRoomImage">
                                </div>
                            </div>

                            <div class="d-flex flex-wrap">
                                <div class="mb-0 position-relative wrapper-services-input" style="width: 100%">
                                    <label class="form-label" for="addHotelRoomName">Укажите наименование номера<span>*</span></label>
                                    <input type="text" class="form-control" name="add_hotel_room_name" id="addHotelRoomName">
                                </div>
                            </div>

                            <div class="d-flex flex-wrap">
                                <div class="mb-0 mb-sm-5 position-relative wrapper-services-input" style="width: 100%">
                                    <label class="form-label" for="addHotelRoomDescription">Описание номера<span>*</span></label>
                                    <textarea class="form-control input-services-list h-100" name="add_hotel_room_description" id="addHotelRoomDescription" required="" type="text"></textarea>
                                </div>
                            </div>

                            <div class="d-flex flex-wrap">
                                <div class="mb-0 position-relative wrapper-services-input" style="width: 100%">
                                    <label class="form-label" for="addHotelRoomName">Укажите стоимость размещения</label>
                                    <input type="text" class="form-control" name="add_hotel_room_price" id="addHotelRoomPrice" style="width: 10rem">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-warning" id="jsAddRoomSubmit">Сохранить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>




        <?php
    }

}