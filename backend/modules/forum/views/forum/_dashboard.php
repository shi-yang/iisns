<?php 

use shiyang\webuploader\Cropper;
use yii\helpers\Url;

?>
<div class="row">
    <div class="col-md-6">
        <?= $this->render('_form', [
            'model'=>$model, 
        ]); ?>
    </div>
    <div class="col-md-6">
        <div class="form-group">
          <label class="control-label col-md-12"><?= Yii::t('app', 'Forum Icon') ?></label>
          <div class="col-md-6">
            <div class="fileupload fileupload-new">
              <div class="fileupload-new img-preview" style="width: 150px; height: 150px;">
                <img src="<?= Yii::getAlias('@forum_icon').$model->forum_icon ?>"  style="width: 150px; height: 150px;">
              </div>
            </div>
          </div>
          <div class="col-md-6">
              <div class="fileupload fileupload-new">
                  <div class="img-preview"></div>
              </div>
          </div>
        </div>
        <div class="clearfix"></div>
        <div class="form-group">
          <div class="col-md-12">
            <?= Cropper::widget() ?>
          </div>
        </div>
    </div>
</div>
