<?php

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Routing\Router;
use Cake\Event\Event;
use Cake\Datasource\ConnectionManager;
use Cake\Log\Log;

use App\Common\AppException;
use App\Model\Entity\AiAnalysisLogModel;
use App\Service\AiAnalysisService;

/**
 * 画像解析を行いログに保存するAPIを提供します。
 */
class AiAnalysisLogController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
    }


    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->RequestHandler->ext = 'json';
    }


    /**
     * @api {post} /rest/v1/analyse analyse
     * @apiName analyse
     * @apiDescription 指定したサーバ上の画像パスを解析し、解析結果をデータベースに記録します。
     * @apiParam {String} image_path APIサーバ上の画像ファイルパス
     * 
     * @apiSuccess {boolean} success true 登録が成功したことを示します。
     * @apiSuccessExample {json} レスポンス例
     *  {
     *      "success": true
     *  }
     * 
     * @apiError (400) {json} - image_path の指定がない場合
     */
    public function analyse()
    {
        $imagePath = $this->request->getData('image_path');

        if (! $imagePath) {
            $this->setFaildResponse('parameter image_path is required.', 400);
            return;
        }

        $model = null;

        try {
            $model = AiAnalysisService::analyse($imagePath);
            Log::info("analysis api success. [image_path : {$imagePath}]");
        }
        catch (Exception $e) {
            $this->setFaildResponse('Ai analysis server request error.', 500);
            return;
        }

        $connection = ConnectionManager::get('default');
        $connection->begin();

        try {
            $model->register();
            $connection->commit();
        }
        catch (Exception $e) {
            Log::error("database error. [image_path : {$imagePath}]");
            $connection->rollback();
            throw $e;
        }
        // connection->close() APIは存在しないので finally は不要

        $this->set([
            'success' => true,
            '_serialize' => ['success'],
        ]);
    }
}
