<?php

namespace St\Sights;

use St\ApplicationError;
use St\Cities\CitiesEnumHelper;
use St\FrontController\FileRoute;
use St\FrontController\ICallableController;
use St\FrontController\IRoute;
use St\HttpError403Exception;
use St\HttpError404Exception;
use St\Layouts\Site\UserHtmlLayout;
use St\Sights;
use St\Layouts;
use St\Views;

class Routes extends FileRoute implements IRoute
{

    /**
     * Маршрутизация для "Достопримечательностей"
     * @throws HttpError403Exception
     * @throws ApplicationError
     * @throws HttpError404Exception
     */
    #[\Override] public function tryRoute(): ICallableController|null
    {

        if (preg_match("#^/?Sights/Add/?$#", $this->dispatcher->getPath())) {
            return (new Sights\CallableControllers\AddSightController(
                $_REQUEST,
                new UserHtmlLayout(),
                new Sights\Views\AddSight\AddSightHtmlView()
            ))->index();
        }

        if (preg_match("#^/?Sights/Add/Go/?$#", $this->dispatcher->getPath())) {
            return (new Sights\CallableControllers\AddSightGoController(
                $_REQUEST,
                new UserHtmlLayout(),
                new Sights\Views\AddSight\AddSightGoHtmlView()
            ))->index();
        }

        if (preg_match("#^/?Sights/List/?$#", $this->dispatcher->getPath())) {
            return (new Sights\CallableControllers\ListSightsController(
                $_REQUEST,
                new UserHtmlLayout(),
                new Sights\Views\ListSightsHtmlView()
            ))->index();
        }

        if (preg_match("#^/?Sights/([1-9][0-9]*)/Edit/?$#", $this->dispatcher->getPath(), $match)) {
            return (new Sights\CallableControllers\EditSightController(
                $_REQUEST,
                new UserHtmlLayout(),
                new Sights\Views\EditSight\EditSightHtmlView()
            ))->index((int)$match[1]);
        }

        if (preg_match("#^/?Sights/Edit/([1-9][0-9]*)/Go/?$#", $this->dispatcher->getPath(), $match)) {
            return (new Sights\CallableControllers\EditSightController(
                $_REQUEST,
                new UserHtmlLayout(),
                new Sights\Views\EditSight\EditSightHtmlView()
            ))->go((int)$match[1]);
        }

        if (
            preg_match("#^/?Sights/([1-9][0-9]*)/Edit/([1-9][0-9]*)/PurgeImage/?$#", $this->dispatcher->getPath(), $match)
            || preg_match("#^/?Sights/([1-9][0-9]*)/Edit/Go/([1-9][0-9]*)/PurgeImage/?$#", $this->dispatcher->getPath(), $match)
        ) {
            return (new Sights\CallableControllers\PurgeSightImageController(
                $_REQUEST,
                new Layouts\JsonLayout(),
                new Views\Common\ResultJsonView()
            ))->index((int)$match[1], (int)$match[2]);
        }

        if (preg_match("#^/?Sights/Wait/?$#", $this->dispatcher->getPath(), $match)) {
            return (new Sights\CallableControllers\WaitSightsController(
                $_REQUEST,
                new UserHtmlLayout(),
                new Sights\Views\WaitSights\ListWaitSightsHtmlView()
            ))->index();
        }

        if (preg_match("#^/?Sights/Wait/([1-9][0-9]*)/Approve/?$#", $this->dispatcher->getPath(), $match)) {
            return (new Sights\CallableControllers\ManageSightsController(
                $_REQUEST,
                new UserHtmlLayout(),
                new Sights\Views\WaitSights\ManageSightHtmlView()
            ))->approve($match[1], SightStatusEnum::Approved);
        }

        if (preg_match("#^/?Sights/Wait/([1-9][0-9]*)/Decline/?$#", $this->dispatcher->getPath(), $match)) {
            return (new Sights\CallableControllers\ManageSightsController(
                $_REQUEST,
                new UserHtmlLayout(),
                new Sights\Views\WaitSights\ManageSightHtmlView()
            ))->approve($match[1], SightStatusEnum::Decline);
        }

        if (preg_match("#^/?Sights/([1-9][0-9]*)/About/?$#", $this->dispatcher->getPath(), $match)) {
            return (new Sights\CallableControllers\AboutSightController(
                $_REQUEST,
                new Layouts\Site\AboutObjectHtmlLayout(),
                new Sights\Views\AboutSight\AboutSightHtmlView()
            ))->index($match[1]);
        }

        if (preg_match("#^/?Sights/([1-9][0-9]*)/About/?$#", $this->dispatcher->getPath(), $match)) {
            return (new Sights\CallableControllers\AboutSightController(
                $_REQUEST,
                new Layouts\Site\AboutObjectHtmlLayout(),
                new Sights\Views\AboutSight\AboutSightHtmlView()
            ))->index($match[1]);
        }

        if (preg_match("#^/?Sights/Show/?$#", $this->dispatcher->getPath(), $match)) {
            return (new Sights\CallableControllers\ShowSightsController(
                $_REQUEST,
                new Layouts\Site\AboutObjectHtmlLayout(),
                new Sights\Views\ShowSights\ShowSightsHtmlView()
            ))->index();
        }

        if (preg_match("#^/?Sights/Buryatia/WarmLake/?$#", $this->dispatcher->getPath(), $match)) {
            return (new Sights\CallableControllers\ShowSightsController(
                $_REQUEST,
                new Layouts\Site\AboutObjectHtmlLayout(),
                new Sights\Views\ShowSights\ShowSightsHtmlView()
            ))->index(CitiesEnumHelper::WarnLake->value);
        }

        if (preg_match("#^/?Sights/Irkutsk/Listvyanka/?$#", $this->dispatcher->getPath(), $match)) {
            return (new Sights\CallableControllers\ShowSightsController(
                $_REQUEST,
                new Layouts\Site\AboutObjectHtmlLayout(),
                new Sights\Views\ShowSights\ShowSightsHtmlView()
            ))->index(CitiesEnumHelper::Listvyanka->value);
        }

        if (preg_match("#^/?Sights/Buryatia/Goryachinsk/?$#", $this->dispatcher->getPath(), $match)) {
            return (new Sights\CallableControllers\ShowSightsController(
                $_REQUEST,
                new Layouts\Site\AboutObjectHtmlLayout(),
                new Sights\Views\ShowSights\ShowSightsHtmlView()
            ))->index(CitiesEnumHelper::Goryachinsk->value);
        }

        if (preg_match("#^/?Sights/Irkutsk/Olkhon/?$#", $this->dispatcher->getPath(), $match)) {
            return (new Sights\CallableControllers\ShowSightsController(
                $_REQUEST,
                new Layouts\Site\AboutObjectHtmlLayout(),
                new Sights\Views\ShowSights\ShowSightsHtmlView()
            ))->index(CitiesEnumHelper::Olkhon->value);
        }

        if (preg_match("#^/?Sights/Buryatia/Arshan/?$#", $this->dispatcher->getPath(), $match)) {
            return (new Sights\CallableControllers\ShowSightsController(
                $_REQUEST,
                new Layouts\Site\AboutObjectHtmlLayout(),
                new Sights\Views\ShowSights\ShowSightsHtmlView()
            ))->index(CitiesEnumHelper::Arshan->value);
        }


        return null;
    }
}