<?php

namespace common\models\admin;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\admin\AdminRole;

/**
 * AdminRoleSearch represents the model behind the search form of `common\models\admin\AdminRole`.
 */
class AdminRoleSearch extends AdminRole
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['code', 'name', 'des', 'create_user', 'create_date', 'update_user', 'update_date', 'status', 'rule'], 'safe'],
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
        $query = AdminRole::find();
        $order = [];
        if (isset($params['sort']) && !empty($params['sort'])) {
            $order = $params['sort'];
            unset($query['sort']);
        } elseif (isset($this->primaryKey()[0]) && !empty($this->primaryKey()[0])) {
            $order = [$this->primaryKey()[0] => SORT_DESC];
        }
        $query->orderBy($order);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false,
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
            'create_date' => $this->create_date,
            'update_date' => $this->update_date,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'des', $this->des])
            ->andFilterWhere(['like', 'create_user', $this->create_user])
            ->andFilterWhere(['like', 'update_user', $this->update_user])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'rule', $this->rule]);

        return $dataProvider;
    }
}
