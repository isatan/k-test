<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;


/**
 * AiAnalysisLog の Entity クラス。
 * Cake の Entity を拡張するとコンストラクタの引数が全プロパティの配列となり扱いにくいので Entity をラップする。
 */
class AiAnalysisLogModel
{
    // 対応する Cake\ORM\Entity クラス
    private $_entity;

    public $id;
    public $imagePath;
    public $success;
    public $message;
    public $class;
    public $confidence;
    public $requestTimestamp;
    public $responseTimestamp;

    public function __construct()
    {
        $this->id = null;
        $this->imagePath = null;
        $this->success = null;
        $this->message = null;
        $this->class = null;
        $this->confidence = null;
        $this->requestTimestamp = null;
        $this->responseTimestamp = null;
    }

    /**
     * このモデルをDBへ保存します。
     */
    public function register()
    {
        if (! $this->_entity) {
            $table = TableRegistry::get('AiAnalysisLog');
            $this->_entity = $table->newEntity();
        }

        $this->_entity->id = $this->id;
        $this->_entity->image_path = $this->imagePath;
        $this->_entity->success = $this->success ? 'true' : 'false';
        $this->_entity->message = $this->message;
        $this->_entity->class = $this->class;
        $this->_entity->confidence = $this->confidence;
        $this->_entity->request_timestamp = $this->requestTimestamp;
        $this->_entity->response_timestamp = $this->responseTimestamp;

        if ($table->save($this->_entity)) {
            $this->id = $this->_entity->id;
        }
    }
}
