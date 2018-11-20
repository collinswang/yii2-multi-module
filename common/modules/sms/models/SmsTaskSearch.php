<?php

namespace common\modules\sms\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\sms\models\SmsTask;

/**
 * SmsTaskSearch represents the model behind the search form about `common\modules\sms\models\SmsTask`.
 */
class SmsTaskSearch extends SmsTask
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'uid', 'source', 'template_id', 'total', 'total_success', 'create_at', 'update_at', 'is_hidden', 'status'], 'integer'],
            [['file'], 'safe'],
            [['single_price', 'total_price'], 'number'],
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
        $query = SmsTask::find();

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
            'source' => $this->source,
            'template_id' => $this->template_id,
            'total' => $this->total,
            'total_success' => $this->total_success,
            'create_at' => $this->create_at,
            'update_at' => $this->update_at,
            'is_hidden' => $this->is_hidden,
            'status' => $this->status,
            'single_price' => $this->single_price,
            'total_price' => $this->total_price,
        ]);

        $query->andFilterWhere(['like', 'file', $this->file]);
        $query->orderBy('id desc');

        return $dataProvider;
    }
}
