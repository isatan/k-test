<?php

namespace App\Service;

use Cake\Core\Configure;
use Cake\Log\Log;
use Cake\Http\Client;

use App\Model\Entity\AiAnalysisLogModel;


/**
 * 画像解析WebAPIへのアクセスを仲介します。
 */
class AiAnalysisService {

    /** リクエスト用HTTPヘッダ */
    const HEADERS = array(
        "Content-Type:application/json"
    );

    /**
     * インスタンス化不要
     */
    private function __construct() {
    }

    /**
     * 指定したパスの画像を解析し分類します。
     * 解析結果が fail の場合も記録対象としてモデルが返ります。
     *
     * @param $imagePath 解析する画像の呼び出し先解析サーバ上のパス
     * @return \App\Model\Entity\AiAnalysisLogModel $model
     */
    public static function analyse(string $imagePath) {
        
        $parameters = [
            'image_path' => $imagePath
        ];
        
        $url = Configure::read('Service.aianalysis.endpoint');
        Log::info("request url = ${url}");

        $http = new Client();
        $requestTime = time();
        $response = $http->post($url, $parameters);
        $responseTime = time();
        Log::info('response body : ', $response->body());
        $resultJson = json_decode($response->body(), JSON_UNESCAPED_UNICODE);


        # レスポンス内に success が存在しない場合はエラー
        if (! array_key_exists('success', $resultJson)) {
            $errorMessage = "response is error. [response : {$response}]";
            Log::error($errorMessage);
            Log::error("Faild request parameter : ", var_export($parameters));
            throw new \Exception($errorMessage);
        }
        
        $model = new AiAnalysisLogModel();
        $model->imagePath = $imagePath;
        $model->success = $resultJson['success'];
        $model->message = $resultJson['message'];

        if (array_key_exists('class', $resultJson['estimated_data'])) {
            $model->class = $resultJson['estimated_data']['class'];
        }

        if (array_key_exists('confidence', $resultJson['estimated_data'])) {
            $model->confidence = $resultJson['estimated_data']['confidence'];
        }

        $model->requestTimestamp = $requestTime;
        $model->responseTimestamp = $responseTime;
        return $model;
    }
}