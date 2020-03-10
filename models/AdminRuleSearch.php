<?php

namespace common\models\admin;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\admin\AdminRule;

/**
 * AdminRuleSearch represents the model behind the search form of `common\models\admin\AdminRule`.
 */
class AdminRuleSearch extends AdminRule
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'pid', 'order'], 'integer'],
            [['route', 'title', 'icon', 'type', 'condition', 'tips', 'is_show', 'status'], 'safe'],
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
        $query = AdminRule::find();
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
            'pid' => $this->pid,
            'order' => $this->order,
        ]);

        $query->andFilterWhere(['like', 'route', $this->route])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'icon', $this->icon])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'condition', $this->condition])
            ->andFilterWhere(['like', 'tips', $this->tips])
            ->andFilterWhere(['like', 'is_show', $this->is_show])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
