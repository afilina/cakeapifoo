<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\ORM\Entity;
use Cake\Validation\Validator;

use ApiFoo\Api\ApiRequest;
use ApiFoo\Api\ApiRepository;
use ApiFoo\Adapters\ORM\Cake\CakeOrm32;

class GamesTable extends Table
{
    public function getApiList(ApiRequest $apiRequest, $hydrate = false)
    {
        $this->alias('root');
        $query = $this
            ->find('all')
            ->hydrate($hydrate)
            ->select(['root.id', 'root.title'])
        ;

        $apiRepository = new ApiRepository(new CakeOrm32($this));
        $results = $apiRepository->getList($query, $apiRequest);

        return $results;
    }

    public function getApiItem(ApiRequest $apiRequest, $hydrate = false)
    {
        // Not ->get because we might do it by slug
        $this->alias('root');
        $query = $this
            ->find('all')
            ->hydrate($hydrate)
            ->select(['root.id', 'root.title', 'root.image_path'])
        ;

        $apiRepository = new ApiRepository(new CakeOrm32($this));
        $results = $apiRepository->getItem($query, $apiRequest);

        return $results;
    }

    public function validationDefault(Validator $validator)
    {
        $validator
            ->requirePresence('title')
            ->notEmpty('title', 'Cannot be empty')
            ->add('title', [
                'length' => [
                    'rule' => ['minLength', 2],
                    'message' => 'Min 2 characters',
                ]
            ])
        ;
        return $validator;
    }

    public function saveApiItem(ApiRequest $apiRequest, Entity $item = null, $newRecord = true)
    {
        if ($newRecord) {
            $item = $this->newEntity($apiRequest->getBody());
        } else {
            $item = $this->patchEntity($item, $apiRequest->getBody());
        }

        $errors = $item->errors();
        if (count($errors) > 0) {
            return [
                'errors' => $errors,
            ];
        }

        $this->save($item);

        return [
            'data' => $item->toArray(),
        ];
    }

    public function addIdFilter(Query $query, $value)
    {
        $query->andWhere(['root.id' => $value]);
    }

    public function addTitleFilter(Query $query, $value)
    {
        $query->andWhere(['root.title LIKE' => '%'.$value.'%']);
    }

    public function addTitleSort(Query $query, $order)
    {
        $query->order('root.title', $order == '-' ? 'DESC' : 'ASC');
    }
}