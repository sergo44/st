<?php

namespace St\Images;

use St\CatalogObject;

enum ImagesObjectsEnum: string
{
    /**
     * Объект каталога
     */
    case CatalogObject = CatalogObject::class;

    /**
     * Возвращает отношение сторон
     * @return float
     */
    public function ratio(): float
    {
        return match($this) {
            ImagesObjectsEnum::CatalogObject => 1 // 640/640
        };
    }
}
