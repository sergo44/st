<?php

namespace St\Catalog\CallableControllers;

use Override;
use PHPMailer\PHPMailer\Exception as PHPMailerException;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use St\Catalog\HotelRoomOrder;
use St\Catalog\Views\AboutObject\OrderHotelRoomEmailBodyHtmlView;
use St\Catalog\Views\AboutObject\OrderHotelRoomJsonView;
use St\FrontController\CallableController;
use St\FrontController\CallableControllerException;
use St\FrontController\ICallableController;
use St\Result;
use St\Views\IView;

class OrderHotelRoomController extends CallableController implements ICallableController
{
    /**
     * Возвращает необходимый вид
     * @return OrderHotelRoomJsonView
     */
    #[Override] public function getView(): IView
    {
        return parent::getView();
    }

    /**
     * Контроллер отправки заявки
     * @return $this
     */
    public function index(): OrderHotelRoomController
    {
        $this->getView()->setResult( new Result() );

        try {

            $hotel_room_id = intval($this->getUserInputData("hotel_room_id") ?: 0);
            $name = trim($this->getUserInputData("name", 255) ?: "");
            $email = trim($this->getUserInputData("email", 255) ?: "");
            $phone = trim($this->getUserInputData("phone", 255) ?: "");
            $arrival_date = trim($this->getUserInputData("arrival_date", 255) ?: "");
            $departure_date = trim($this->getUserInputData("departure_date", 255) ?: "");
            $remark = trim($this->getUserInputData("remark", 65535) ?: "");

            if (!$hotel_room_id) {
                throw new CallableControllerException("Не указан идентификатор номера, скорее всего вы перешли по неверной ссылке. Пожалуйста, попробуйте еще раз");
            }

            if (!$name) {
                throw new CallableControllerException("Пожалуйста, укажите Ваше имя");
            }

            if (!$email && !$phone) {
                throw new CallableControllerException("Пожалуйста, укажите контактные данные - адрес электронной почты или телефон");
            }

            if (!$arrival_date) {
                throw new CallableControllerException("Пожалуйста, укажите желаемую дату заезда");
            }

            if (!$departure_date) {
                throw new CallableControllerException("Пожалуйста, укажите желаемую дату выезда");
            }

            $hotel_room_order = new HotelRoomOrder();
            $hotel_room_order
                ->setHotelRoomId($hotel_room_id)
                ->setName($name)
                ->setEmail($email)
                ->setPhone($phone)
                ->setArrivalDate($arrival_date)
                ->setDepartureDate($departure_date)
                ->setRemark($remark)
            ;

            if (!$hotel_room_order->getHotelRoom()->getHotelRoomId()) {
                throw new CallableControllerException("Указанный номер не найден");
            }

            $phpmailer = new PHPMailer(true);
            $phpmailer->SMTPDebug = SMTP::DEBUG_OFF;
            $phpmailer->isSMTP();
            $phpmailer->Host = ST_SMTP_HOST;
            $phpmailer->Username = ST_SMTP_PASSWORD;
            $phpmailer->Password = "4D5KPJ22MZ2NrmH3z0gB";
            $phpmailer->SMTPAuth = true;
            $phpmailer->Port = 465;
            $phpmailer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $phpmailer->CharSet = PHPMailer::CHARSET_UTF8;

            $phpmailer->setFrom('soberi.tur@mail.ru', 'Собери Тур');
            $phpmailer->addAddress($hotel_room_order->getHotelRoom()->getCatalogObject()->getContactEmail());

            $phpmailer->isHTML(true);
            $phpmailer->Subject = "Заявка с сайта Собери Тур";
            $phpmailer->Body = (new OrderHotelRoomEmailBodyHtmlView( $hotel_room_order ))->fetch();
            $phpmailer->AltBody = strip_tags($phpmailer->Body);
            $phpmailer->send();

        } catch (CallableControllerException | PHPMailerException $e) {
            $this->getView()->getResult()->addError($e->getMessage());
        }


        return $this;
    }
}