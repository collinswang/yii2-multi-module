<?php

namespace common\modules\sms\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\sms\models\Sms;

/**
 * SmsSearch represents the model behind the search form about `common\modules\sms\models\Sms`.
 */
class SmsSearch extends Sms
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'uid', 'source', 'type', 'mobile', 'template_id', 'create_at', 'update_at', 'send_status', 'is_hidden', 'sid', 'order_id'], 'integer'],
            [['content', 'send_desc'], 'safe'],
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
        $query = Sms::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
            'pagination' => [
                'pageSize' => 20,
            ],
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
            'type' => $this->type,
            'mobile' => $this->mobile,
            'template_id' => $this->template_id,
            'create_at' => $this->create_at,
            'update_at' => $this->update_at,
            'send_status' => $this->send_status,
            'is_hidden' => $this->is_hidden,
            'sid' => $this->sid,
            'order_id' => $this->order_id,
        ]);

        $query->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'send_desc', $this->send_desc]);

        return $dataProvider;
    }
}
