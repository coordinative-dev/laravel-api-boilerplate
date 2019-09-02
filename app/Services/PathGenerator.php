<?php

namespace App\Services;

use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\PathGenerator\BasePathGenerator;

class PathGenerator extends BasePathGenerator
{
    /**
     * @param Media $media
     *
     * @return string
     */
    protected function getBasePath(Media $media): string
    {
        return with(new $media->model_type())->getTable() . '/' . $media->getKey();
    }
}
