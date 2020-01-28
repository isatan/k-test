<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Log\Log;
use Cake\Routing\Router;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false,
        ]);
        
        /*
         * Enable the following component for recommended CakePHP security settings.
         * see https://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');
    }


    public function beforeFilter(Event $event)
    {
        $this->RequestHandler->ext = 'json';
        Log::info('[start request] ' . Router::reverse($this->request));
    }


    public function afterFilter(Event $event)
    {
        Log::info('[end request] ' . Router::reverse($this->request));
    }


    /**
     * エラーを示すレスポンスをセットします。
     * 
     * @param string $message エラーメッセージ
     * @param int $status エラーを示す httpステータスコード
     */
    protected function setFaildResponse(string $message, int $status)
    {
        $this->set([
            "success" => false,
            "message" => $message,
            "estimated_data" => [],
            '_serialize' => ['success', 'message', 'estimated_data'],
        ]);

        $this->response = $this->response->withStatus($status);
    }
}
