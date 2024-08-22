<?php

namespace St\Images;

use St\CatalogObject;
use St\Sights\Sight;

enum ImagesObjectsEnum: string
{
    /**
     * Объект каталога
     */
    case CatalogObject = CatalogObject::class;
    /**
     * Объект каталога
     */
    case Sight = Sight::class;


    /**
     * Возвращает отношение сторон
     * @return float
     */
    public function ratio(): float
    {
        return match($this) {
            ImagesObjectsEnum::CatalogObject,
            ImagesObjectsEnum::Sight => 1
        };
    }
}
