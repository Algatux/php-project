<?php

namespace App\Service;

use App\Model\Request\MappableRequestInterface;
use Symfony\Component\HttpFoundation\Request;

class RequestMapper
{
    /**
     * @throws \JsonException
     */
    public function mapJsonRequest(Request $request, MappableRequestInterface $model): void
    {
        $data = $request->getContent();
        $data = json_decode($data, true, 512, JSON_THROW_ON_ERROR);

        $propsToMap = get_class_vars(get_class($model));

        foreach (array_keys($propsToMap) as $property) {
            if (isset($data[$property])) {
                $model->$property = $data[$property];
            }
        }


    }
}
