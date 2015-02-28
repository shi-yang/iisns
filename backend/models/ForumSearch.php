<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Forum;

/**
 * ForumSearch represents the model behind the search form about `backend\models\Forum`.
 */
class ForumSearch extends Forum
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'create_time'], 'integer'],
            [['forum_name', 'forum_desc', 'forum_url', 'forum_icon', 'theme', 'layout'], 'safe'],
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
        $query = Forum::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'create_time' => $this->create_time,
        ]);

        $query->andFilterWhere(['like', 'forum_name', $this->forum_name])
            ->andFilterWhere(['like', 'forum_desc', $this->forum_desc])
            ->andFilterWhere(['like', 'forum_url', $this->forum_url])
            ->andFilterWhere(['like', 'forum_icon', $this->forum_icon])
            ->andFilterWhere(['like', 'theme', $this->theme])
            ->andFilterWhere(['like', 'layout', $this->layout]);

        return $dataProvider;
    }
}
