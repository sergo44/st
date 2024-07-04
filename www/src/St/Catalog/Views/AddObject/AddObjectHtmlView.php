<?php

namespace St\Catalog\Views\AddObject;

use St\ApplicationError;
use St\CatalogObject;
use St\CatalogObjectType;
use St\Cities\GetRegionCities;
use St\City;
use St\Country;
use St\Regions\GetCountryRegions;
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
     * @throws ApplicationError
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
                                    <input class="form-control input-services-list" id="objectType" placeholder="Не выбрано" required type="text" value="<?php print $this->catalog_object->getObjectType() ? CatalogObjectType::getSelectOptions()[$this->catalog_object->getObjectType()] : null?>">
                                    <ul class="add-adv__services-list position-absolute w-100">
                                        <?php foreach (CatalogObjectType::getSelectOptions() as $value => $option):?>
                                            <li><a class="d-block" href="#" data-value="<?php print $this->escape($value)?>"><?php print $option;?></a></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                                <div class="mb-5 position-relative wrapper-services-input" style="width:30rem">
                                    <label class="form-label" for="objectName">Укажите название объекта<span>*</span></label>
                                    <input class="form-control input-services-list" name="name" id="objectName" placeholder="Не указано" required type="text" value="<?php print $this->escape($this->catalog_object->getName())?>">
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
                                    <input class="form-control input-services-list" id="objectCountry" placeholder="Не выбрано" required type="text" value="<?php print $this->catalog_object->getCountry()?->getName()?>">
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
                                    <input type="hidden" name="region_id" value="<?php print (int)$this->catalog_object->getRegionId();?>">
                                    <input class="form-control input-services-list" id="objectRegion" placeholder="Не выбрано" required type="text" readonly value="<?php print $this->catalog_object->getRegion()?->getName()?>">
                                    <ul class="add-adv__services-list position-absolute w-100 j-region-ul-list">
                                        <?php if ($this->catalog_object->getCountryId()):?>
                                            <?php foreach((new GetCountryRegions($this->catalog_object->getCountryId()))->getRegions() as $region): ?>
                                                <li><a class="d-block" href="#" data-value="<?php print $region->getRegionId(); ?>" data-toggle-region="1"><?php print $region->getName();?></a></li>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <li>Выберите страну</li>
                                        <?php endif ?>
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
                                    <input class="form-control input-services-list" id="objectCity" placeholder="Не выбрано" required type="text" readonly value="<?php print $this->catalog_object->getCity()?->getName();?>">
                                    <ul class="add-adv__services-list position-absolute w-100 j-city-ul-list">
                                        <?php if ($this->catalog_object->getRegion()?->getRegionId()):?>
                                            <?php foreach ( (new GetRegionCities($this->catalog_object->getRegionId()))->getCities() as $city):?>
                                                <li><a class="d-block" href="#" data-value="<?php print $city->getCityId()?>>" data-toggle-region="1"><?php print $city->getName()?></a></li>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <li class="text-muted">Выберите регион</li>
                                        <?php endif; ?>

                                    </ul>
                                </div>
                            </div>

                            <div class="mb-5 position-relative wrapper-services-input" style="width:30rem">
                                <label class="form-label" for="addressLine">Введите адрес объекта<span>*</span></label>
                                <input class="form-control input-services-list" id="addressLine" name="address_lines" placeholder="Укажите адрес объекта" required type="text" value="<?php print $this->escape($this->catalog_object->getAddressLines())?>"/>
                            </div>
                        </div>

                        <h5>Укажите адрес объекта на карте</h5>
                        <div class="d-flex gap-5 flex-wrap" style="margin-bottom: 1rem">
                            <div class="mb-0 position-relative wrapper-services-input" style="width:30rem">
                                <label class="form-label" for="objectLat">Широта<span>*</span></label>
                                <input type="text" class="form-control input-services-list" id="objectLat" name="lat" value="<?php print $this->escape($this->catalog_object->getLat());?>" data-type="setLat" readonly>
                            </div>
                            <div class="mb-0 position-relative wrapper-services-input" style="width:30rem">
                                <label class="form-label" for="objectLon">Долгота<span>*</span></label>
                                <input type="text" class="form-control input-services-list" id="objectLon" name="lon" value="<?php print $this->escape($this->catalog_object->getLat());?>" data-type="setLon" readonly>
                            </div>
                        </div>

                        <?php if ($this->catalog_object->getLat() > 0 && $this->catalog_object->getLon() > 0):?>
                        <script>
                            let jsEditObjectLocation = {lat: <?php print $this->catalog_object->getLat()?>, lon: <?php  print $this->catalog_object->getLon()?>}
                        </script>
                        <?php endif; ?>

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
                        <div class="add-new-adv__photos d-flex gap-4" id="jsObjectPhotos">
                            <?php foreach ($this->catalog_object->getImages() as $image):?>
                                <div style="position: relative">
                                    <img src="<?php print $image->getUri(150, 150, true)?>" alt="" data-image-id="<?php print $image->getImageId()?>">
                                    <a class="jsEditObjectRemoveImage" style="position: absolute; top: -10px; right: -10px;" href="#"><svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M16 3C13.4288 3 10.9154 3.76244 8.77759 5.1909C6.63975 6.61935 4.97351 8.64968 3.98957 11.0251C3.00563 13.4006 2.74819 16.0144 3.2498 18.5362C3.75141 21.0579 4.98953 23.3743 6.80762 25.1924C8.6257 27.0105 10.9421 28.2486 13.4638 28.7502C15.9856 29.2518 18.5995 28.9944 20.9749 28.0104C23.3503 27.0265 25.3807 25.3603 26.8091 23.2224C28.2376 21.0846 29 18.5712 29 16C28.996 12.5534 27.6251 9.24912 25.188 6.81201C22.7509 4.3749 19.4466 3.00398 16 3ZM20.707 19.293C20.8 19.3858 20.8739 19.496 20.9242 19.6174C20.9746 19.7387 21.0006 19.8688 21.0007 20.0002C21.0007 20.1316 20.9749 20.2617 20.9246 20.3832C20.8744 20.5046 20.8007 20.6149 20.7078 20.7078C20.6149 20.8007 20.5046 20.8744 20.3832 20.9246C20.2617 20.9749 20.1316 21.0007 20.0002 21.0006C19.8688 21.0006 19.7387 20.9746 19.6174 20.9242C19.496 20.8738 19.3858 20.8 19.293 20.707L16 17.4141L12.707 20.707C12.5195 20.8942 12.2652 20.9993 12.0002 20.9991C11.7352 20.999 11.4811 20.8937 11.2937 20.7063C11.1063 20.5189 11.001 20.2648 11.0009 19.9998C11.0007 19.7348 11.1058 19.4806 11.293 19.293L14.5859 16L11.293 12.707C11.1058 12.5194 11.0007 12.2652 11.0009 12.0002C11.001 11.7352 11.1063 11.4811 11.2937 11.2937C11.4811 11.1063 11.7352 11.001 12.0002 11.0009C12.2652 11.0007 12.5195 11.1058 12.707 11.293L16 14.5859L19.293 11.293C19.4806 11.1058 19.7348 11.0007 19.9998 11.0009C20.2648 11.001 20.5189 11.1063 20.7063 11.2937C20.8937 11.4811 20.999 11.7352 20.9991 12.0002C20.9993 12.2652 20.8942 12.5194 20.707 12.707L17.4141 16L20.707 19.293Z" fill="black"/>
                                    </svg></a>
                                </div>
                            <?php endforeach; ?>
                        </div>
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