<?php

namespace St\User\CallableControllers;

use PDOException;
use PHPMailer\PHPMailer\Exception;
use St\ApplicationError;
use St\Db;
use St\FrontController\CallableController;
use St\FrontController\ICallableController;
use St\PHPMailerHelper;
use St\User\GetWaitConfirmationCodeUsers;

class SendConfirmationEmailController extends CallableController implements ICallableController
{
    /**
     * Контроллер отправки письма с кодом подтверждения адреса электронной почты
     * @return $this
     * @throws ApplicationError
     */
    public function index(): self
    {

        $dbh = Db::getWritePDOInstance();

        try {

            $dbh->beginTransaction();

            $users = (new GetWaitConfirmationCodeUsers($dbh))
                ->setLock(true)
                ->getUsers()
            ;

            foreach ($users as $user) {
                // Отравляем письмо
                try {
                    $mailer = PHPMailerHelper::getPHPMailer();
                    $mailer->addAddress($user->getEmail(), $user->getName());
                    $mailer->Subject = 'Подтверждения адреса электронно почты';
                    $mailer->Body = '';

                    if (!$mailer->send()) {

                    }

                } catch (Exception $e) {
                    error_log($e->getMessage());
                }
            }

            $dbh->commit();

        } catch (PDOException $e) {
            throw new ApplicationError($e->getMessage());
        } finally {
            if ($dbh->inTransaction()) {
                $dbh->rollBack();
            }
        }

        return $this;
    }
}