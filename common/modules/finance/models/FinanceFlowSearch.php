<?php

namespace common\modules\finance\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\finance\models\FinanceFlow;

/**
 * FinanceFlowSearch represents the model behind the search form about `common\modules\finance\models\FinanceFlow`.
 */
class FinanceFlowSearch extends FinanceFlow
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'uid', 'target_type', 'target_id', 'create_time', 'invisible'], 'integer'],
            [['money'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = FinanceFlow::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'uid' => $this->uid,
            'money' => $this->money,
            'target_type' => $this->target_type,
            'target_id' => $this->target_id,
            'create_time' => $this->create_time,
            'invisible' => $this->invisible,
        ]);

        $query->orderBy("id desc");

        return $dataProvider;
    }
}
