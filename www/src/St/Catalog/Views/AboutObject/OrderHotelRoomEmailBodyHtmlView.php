<?php

namespace St\Catalog\Views\AboutObject;

use Override;
use St\Catalog\HotelRoomOrder;
use St\Views\HtmlView;
use St\Views\IView;

class OrderHotelRoomEmailBodyHtmlView extends HtmlView implements IView
{
    protected HotelRoomOrder $hotel_room_order;

    /**
     * Конструктор объекта
     * @param HotelRoomOrder $hotel_room
     */
    public function __construct(HotelRoomOrder $hotel_room)
    {
        $this->hotel_room_order = $hotel_room;
    }

    #[Override] public function out(): void
    {
        ?>
        <html lang="ru">
            <head>
                <meta charset="utf8">
                <title>Заявка с сайта Собери Тур</title>
            </head>
            <body>
                <div>Добрый день. На сайте Собери Тур была отправлена заявка на бронирование вашего номера. Вот информация, которую указал пользователь</div>
                <ul>
                    <li><strong>Имя клиента: </strong> <?php print $this->escape($this->hotel_room_order->getName());?></li>
                    <li><strong>Адрес электронной почты клиента: </strong> <?php print $this->escape($this->hotel_room_order->getEmail());?></li>
                    <li><strong>Номер телефона клиента: </strong> <?php print $this->escape($this->hotel_room_order->getPhone());?></li>
                    <li><strong>Желаемая дата заезда: </strong> <?php print $this->escape($this->hotel_room_order->getArrivalDate());?></li>
                    <li><strong>Желаемая дата выезда: </strong> <?php print $this->escape($this->hotel_room_order->getDepartureDate());?></li>
                    <li><strong>Пожелания клиента: </strong> <?php print $this->escape($this->hotel_room_order->getRemark());?></li>
                </ul>

                <div>Вы получили данное письмо, поскольку ваш объект зарегистрирован на сайте "Собери Тур" и доступен по адресу <a href="https://soberitur.ru/Catalog/Objects/<?php print $this->hotel_room_order->getHotelRoom()->getObjectId();?>/About">https://soberitur.ru/Catalog/Objects/<?php print $this->hotel_room_order->getHotelRoom()->getObjectId();?>/About"</a></div>
            </body>
        </html>
        <?php
    }
}