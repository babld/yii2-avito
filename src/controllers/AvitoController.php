<?php

namespace babld\avito\controllers;

use babld\avito\components\Avito;
use yii\web\Controller;

class AvitoController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index', []);
    }

    public function actionExport(string $class, array $itemIds)
    {
        $avitoComponent = new Avito();

        $xml = $avitoComponent->generateXml($class, $itemIds);
        $success = $avitoComponent->saveXml($xml);

        return $this->render('export', ['success' => $success]);
    }
}
