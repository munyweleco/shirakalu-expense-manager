<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Payment;

/**
 * app\models\search\PaymentSearch represents the model behind the search form about `app\models\Payment`.
 */
 class PaymentSearch extends Payment
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'staff_id', 'operation_id'], 'integer'],
            [['rate', 'acres', 'amount'], 'number'],
            [['payment_date', 'is_finalized', 'created_at', 'updated_at'], 'safe'],
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
        $query = Payment::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'staff_id' => $this->staff_id,
            'operation_id' => $this->operation_id,
            'rate' => $this->rate,
            'acres' => $this->acres,
            'amount' => $this->amount,
            'payment_date' => $this->payment_date,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'is_finalized', $this->is_finalized]);

        return $dataProvider;
    }
}
