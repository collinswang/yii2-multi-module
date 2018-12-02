<?php

namespace common\modules\finance\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\finance\models\FinanceIncome;

/**
 * FinanceIncomeSearch represents the model behind the search form about `common\modules\finance\models\FinanceIncome`.
 */
class FinanceIncomeSearch extends FinanceIncome
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'uid', 'create_time', 'deal_time', 'type', 'status', 'admin_id', 'invisible'], 'integer'],
            [['payable', 'fee_rate', 'fee', 'received'], 'number'],
            [['admin_note'], 'safe'],
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
        $query = FinanceIncome::find();

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
            'payable' => $this->payable,
            'fee_rate' => $this->fee_rate,
            'fee' => $this->fee,
            'received' => $this->received,
            'create_time' => $this->create_time,
            'deal_time' => $this->deal_time,
            'type' => $this->type,
            'status' => $this->status,
            'admin_id' => $this->admin_id,
            'invisible' => $this->invisible,
        ]);

        $query->andFilterWhere(['like', 'admin_note', $this->admin_note]);
        $query->orderBy('id desc');

        return $dataProvider;
    }
}
