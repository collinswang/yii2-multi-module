<?php

namespace common\modules\finance\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\finance\models\FinanceAccount;

/**
 * FinanceAccountSearch represents the model behind the search form about `common\modules\finance\models\FinanceAccount`.
 */
class FinanceAccountSearch extends FinanceAccount
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'status', 'admin_id', 'last_time'], 'integer'],
            [['total_usable', 'total_income', 'total_award', 'total_outcome', 'total_withdraw', 'total_return'], 'number'],
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
        $query = FinanceAccount::find();

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
            'uid' => $this->uid,
            'total_usable' => $this->total_usable,
            'total_income' => $this->total_income,
            'total_award' => $this->total_award,
            'total_outcome' => $this->total_outcome,
            'total_withdraw' => $this->total_withdraw,
            'total_return' => $this->total_return,
            'status' => $this->status,
            'admin_id' => $this->admin_id,
            'last_time' => $this->last_time,
        ]);

        $query->andFilterWhere(['like', 'admin_note', $this->admin_note]);

        return $dataProvider;
    }
}
