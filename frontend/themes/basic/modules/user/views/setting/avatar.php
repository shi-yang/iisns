<?php
use yii\helpers\Url;
?>
<!-- Large modal -->
<div class="modal fade" id="avatarModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel"><?= Yii::t('app', 'System avatar') ?></h4>
      </div>
      <div class="modal-body">
        <?php for ($name=1; $name <= 40; $name++) { ?>
            <a href="<?= Url::toRoute(['/user/setting/avatar', 'name' => $name]) ?>" onclick="return false;" data-clicklog="selectAvatar">
                <img src="<?= Yii::getAlias('@avatar/default/') . $name.'.jpg'?>" alt="User avatar" class="img-thumbnail">
            </a>
        <?php } ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?= Yii::t('app', 'Cancel'); ?></button>
      </div>
    </div>
  </div>
</div>
<?php
$js = "
  $('[data-clicklog=selectAvatar]').on('click', function(){
    jQuery.ajax({
        url: $(this).attr('href'),
        success: function() {
          $('#avatarModal').modal('hide');
          window.location.reload();
        }
    });
  });
";
$this->registerJs($js);
?>
