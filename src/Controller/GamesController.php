<?php
namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\Event\Event;

use ApiFoo\Api\ApiRequest;
use ApiFoo\Api\ApiRepository;
use ApiFoo\Adapters\Cake\V3_2\CakeRequest;

class GamesController extends AppController
{
    public function beforeRender(Event $event)
    {
        $this->RequestHandler->renderAs($this, 'json');
        $this->response->type('application/json');
    }

    public function getList()
    {
        $apiRequest = new ApiRequest(new CakeRequest($this->request));

        $gamesTable = TableRegistry::get('Games');
        $response = $gamesTable->getApiList($apiRequest);

        $this->set('response', $response);
        $this->set('_serialize', 'response');
    }

    public function getItem($id)
    {
        $apiRequest = new ApiRequest(new CakeRequest($this->request));
        $apiRequest->addUserFilter('id', $id);

        $gamesTable = TableRegistry::get('Games');
        $response = $gamesTable->getApiItem($apiRequest);

        $this->set('response', $response);
        $this->set('_serialize', 'response');
    }

    public function patchItem($id)
    {
        $apiRequest = new ApiRequest(new CakeRequest($this->request));
        $apiRequest->addUserFilter('id', $id);

        $gamesTable = TableRegistry::get('Games');
        $game = $gamesTable->getApiItem($apiRequest, true)['data'];
        $response = $gamesTable->saveApiItem($apiRequest, $game, false);

        if (isset($response['errors'])) {
            $this->response->statusCode(400);
        }

        $this->set('response', $response);
        $this->set('_serialize', 'response');
    }
}
