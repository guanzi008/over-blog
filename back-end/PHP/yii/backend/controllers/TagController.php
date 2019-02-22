<?php
/**
 * Created by huxin.
 * User: huxin
 * Date: 2019-02-22
 * Time: 09:18
 */

namespace backend\controllers;


use app\models\Tag;

class TagController extends BasicController
{
    public $enableCsrfValidation = false;
    private $tag;

    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
        $this->tag = new Tag();
    }

    /**
     * 获取标签列表
     * Date: 2019-02-22 10:10
     * @return \yii\web\Response
     */
    public function actionTagList()
    {
        $data = $this->get();
        $this->tag->scenario = 'tagList';
        $this->tag->attributes = $data;
        if($this->tag->validate()){
            $list = $this->tag->find()
                ->offset(($data['pageNum'] - 1) * $data['pageSize'])
                ->limit($data['pageSize'])
                ->all();
            return !empty($list)?$this->success('获取标签列表成功！',$list)
                :$this->error('暂无标签列表数据！');
        }
        return $this->error(current($this->tag->firstErrors));
    }

    /**
     * 添加标签
     * Date: 2019-02-22 10:15
     * @return \yii\web\Response
     */
    public function actionAddTag()
    {
        $data = $this->post();
        $this->tag->scenario = 'tagAdd';
        $this->tag->attributes = $data;
        if($this->tag->validate()){
            $res = $this->tag->save(false);
            return $res?$this->success('添加标签成功！')
                :$this->error('添加标签失败，请稍后再试！');
        }
        return $this->error(current($this->tag->firstErrors));
    }

    /**
     * 修改标签
     * Date: 2019-02-22 10:21
     * @return \yii\web\Response
     */
    public function actionUpdateTag()
    {
        $data = $this->post();
        $this->tag->scenario = 'tagUpdate';
        $this->tag->attributes = $data;
        if($this->tag->validate()){
            $exist_tag = $this->tag->findOne($data['id']);
            $exist_tag->name = $data['name'];
            $res = $exist_tag->save(false,['name','updated_at']);
            return $res?$this->success('修改标签成功！')
                :$this->error('修改标签失败，请稍后再试！');
        }
        return $this->error(current($this->tag->firstErrors));
    }

    /**
     * 删除标签
     * Date: 2019-02-22 10:21
     * @return \yii\web\Response
     */
    public function actionDelTag()
    {
        $data = $this->post();
        $this->tag->scenario = 'tagDelete';
        $this->tag->attributes = $data;
        if($this->tag->validate()){
            $exist_tag = $this->tag->findOne($data['id']);
            $res = $exist_tag->delete();
            return $res?$this->success('删除标签成功！')
                :$this->error('删除标签失败，请稍后再试！');
        }
        return $this->error(current($this->tag->firstErrors));
    }
}