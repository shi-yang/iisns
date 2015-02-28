<!-- Large modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php echo Yii::t('user', 'Edit Icon'); ?></h4>
      </div>
      <div class="modal-body">
		<?php for ($name=1; $name <= 40; $name++) { ?>
			<a href="javascript:;" onclick="face_select(<?php echo $name; ?>)">
				<img src="/upload/user/images/<?php echo $name.'.jpg'?>" alt="..." class="img-thumbnail">
			</a>
		<?php } ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo Yii::t('common', 'Cancel'); ?></button>
      </div>
    </div>
  </div>
</div>
<script>
	function face_select (id) {
		jQuery.ajax({
			'beforeSend':function(){$("#myModal").modal("hide");Loading.show()},
			'success':function(){Loading.hide();window.location.reload()},
			'url':'/user/setting/settingFace/name/'+ id,'cache':false
		});
	 } 
</script>