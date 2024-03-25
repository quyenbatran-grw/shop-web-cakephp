<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Event\EventInterface;
use App\Model\Entity\Master;
/**
 * Masters Model
 *
 * @method \App\Model\Entity\Master newEmptyEntity()
 * @method \App\Model\Entity\Master newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Master[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Master get($primaryKey, $options = [])
 * @method \App\Model\Entity\Master findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Master patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Master[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Master|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Master saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Master[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Master[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Master[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Master[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class MastersTable extends Table
{
    const MADE_IN = 1;
    const SPONSOR = 2;
    const UNIT = 3;
    public static $types = [
        self::MADE_IN => 'Xuất xứ',
        self::SPONSOR => 'Nhà phân phối',
        self::UNIT => 'Đơn vị sản phẩm',
    ];
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('masters');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        // $this->addBehavior('Tree', [
        //     'parent' => 'type',
        //     // 'recoverOrder' => ['ranking' => 'DESC'],
        //     'left' => 'ranking',
        //     'right' => 'ranking'
        // ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('type')
            ->notEmptyString('type');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->notEmptyString('ranking');

        return $validator;
    }

    public function afterDelete(EventInterface $event, EntityInterface $entity, ArrayObject $options) {
        $masters = $this->find()->where(['type' => $entity->type])->orderAsc('ranking')->all();
        foreach ($masters as $key => $master) {
            $master->ranking = $key + 1;
        }
        $this->saveMany($masters);
    }

    /**
     * 種別でマスター一覧を取得
     * @param int $type 種別
     * @return Query
     */
    public function findByType(Query $query, array $options): Query {
        if (!empty($options['type'])) {
            $query->where(['type'=> $options['type']]);
        }
        return $query;
    }

    /**
     * 上に並び順の変更
     * @param App\Modal\Entity\Master
     * @return Boolean
     */
    public function moveUp($master) {
        $ranking = $master->ranking;
        $masters = $this->find()->where(['type' => $master->type]);
        if($ranking > 1) {
            foreach ($masters as $key => $master) {
                if($master->ranking == $ranking) {
                    $master->ranking = $ranking - 1;
                } else if($master->ranking == $ranking - 1) {
                    $master->ranking = $ranking;
                }
            }
        }
        return $this->saveMany($masters);
    }

    /**
     * 下に並び順の変更
     * @param App\Modal\Entity\Master
     * @return Boolean
     */
    public function moveDown($master) {
        $ranking = $master->ranking;
        $masters = $this->find()->where(['type' => $master->type]);
        if($ranking < count($masters->toArray())) {
            foreach ($masters as $key => $master) {
                if($master->ranking == $ranking) {
                    $master->ranking = $ranking + 1;
                } else if($master->ranking == $ranking + 1) {
                    $master->ranking = $ranking;
                }
            }
        }
        return $this->saveMany($masters);
    }

    /**
     * 
     */
    public function resetRanking($type) {
        $ranking = 0;
        $this->find()->where(['type'=> $type])->all()
        ->map(function(Master $master) use($ranking) {
            $ranking++;
            $master->ranking = $ranking;
            return $master;
        });
    }
}
