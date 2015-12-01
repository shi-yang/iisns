<?php
/**
 * @link http://www.iisns.com/
 * @copyright Copyright (c) 2015 iiSNS
 * @license http://www.iisns.com/license/
 */

namespace app\modules\forum\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\forum\models\Forum;

/**
 * ForumSearch represents the model behind the search form about `app\modules\forum\models\Forum`.
 *
 * @author Shiyang <dr@shiyang.me>
 * @since 2.0
 */
class ForumSearch extends Forum
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'created_at'], 'integer'],
            [['forum_name', 'forum_desc', 'forum_url', 'forum_icon'], 'safe'],
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

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'forum_name', $this->forum_name])
            ->andFilterWhere(['like', 'forum_desc', $this->forum_desc])
            ->andFilterWhere(['like', 'forum_url', $this->forum_url])
            ->andFilterWhere(['like', 'forum_icon', $this->forum_icon]);

        return $dataProvider;
    }
}
