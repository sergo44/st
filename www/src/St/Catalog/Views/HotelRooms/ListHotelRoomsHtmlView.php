<?php

namespace St\Catalog\Views\HotelRooms;

use Override;
use St\HotelRoom;
use St\Views\HtmlView;
use St\Views\IView;

class ListHotelRoomsHtmlView extends HtmlView implements IView
{
    /**
     * Объект для
     * @var HotelRoom
     */
    protected HotelRoom $hotel_room;

    /**
     * Конструктор объекта вида
     * @param HotelRoom $hotel_room
     */
    public function __construct(HotelRoom $hotel_room)
    {
        $this->hotel_room = $hotel_room;
    }

    #[Override] public function out(): void
    {
        ?>

        <li>
            <div class="section-ads__wrapper-number-description add-new-adv__number-description w-100 d-grid align-items-center gap-4 pe-4">
                <div class="section-ads__wrapper-photo-number">
                    <img alt="" src="<?php print $this->hotel_room->getImage() . "?crop=1" ?: "/images/no-image.svg"?>" class="p-2">
                </div>
                <div class="section-ads__wrapper-number-title">
                    <div class="section-ads__number-title text-uppercase"><?php print $this->escape($this->hotel_room->getName());?></div>
                    <div class="section-catalog__card-advantages d-flex align-items-center gap-3 mt-2">
                        <span><?php print $this->escape($this->hotel_room->getDescription());?></span>
                    </div>
                </div>
                <div class="section-catalog__car-advantages d-flex align-items-center gap-3 mt-2">
                    <span id="jsAddObjectRoomsPrice"></span>
                </div>
                <div class="section-ads__three-dots d-flex align-items-center justify-content-center position-relative">
                    <ul class="section-ads__edit position-absolute">
                        <li><a class="ads-remove" href="#">Удалить</a></li>
                    </ul>
                    <svg fill="none" height="2.8rem" viewBox="0 0 28 28" width="2.8rem" xmlns="http://www.w3.org/2000/svg">
                        <path d="M14 15.3125C14.7249 15.3125 15.3125 14.7249 15.3125 14C15.3125 13.2751 14.7249 12.6875 14 12.6875C13.2751 12.6875 12.6875 13.2751 12.6875 14C12.6875 14.7249 13.2751 15.3125 14 15.3125Z" fill="#F97800"></path>
                        <path d="M14 8.3125C14.7249 8.3125 15.3125 7.72487 15.3125 7C15.3125 6.27513 14.7249 5.6875 14 5.6875C13.2751 5.6875 12.6875 6.27513 12.6875 7C12.6875 7.72487 13.2751 8.3125 14 8.3125Z" fill="#F97800"></path>
                        <path d="M14 22.3125C14.7249 22.3125 15.3125 21.7249 15.3125 21C15.3125 20.2751 14.7249 19.6875 14 19.6875C13.2751 19.6875 12.6875 20.2751 12.6875 21C12.6875 21.7249 13.2751 22.3125 14 22.3125Z" fill="#F97800"></path>
                    </svg>
                </div>
            </div>

            <input type="hidden" name="hotel_room_id[]" value="<?php print $this->hotel_room->getHotelRoomId()?>">
            <input type="hidden" name="hotel_room_uploaded_file[]" value="<?php print $this->hotel_room->getUploadedFile(); ?>">
            <input type="hidden" name="hotel_room_name[]" value="<?php print $this->hotel_room->getName()?>">
            <input type="hidden" name="hotel_room_description[]" value="<?php print $this->hotel_room->getDescription()?>">
            <input type="hidden" name="hotel_room_price[]" value="<?php print $this->hotel_room->getPrice();?>">

        </li>

        <?php
    }


}