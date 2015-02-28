<?php

use yii\bootstrap\Progress;

$this->title = 'Install iiSNS';
$this->registerCssFile('/css/install.css');
$currentStep = $step;
$currentStepView = 'steps/step-' . $currentStep;
?>
<?php
    $percent = ($currentStep / 5)  * 100;
    echo Progress::widget([
        'label' => $currentStep,
        'percent' => $percent,
        'barOptions' => ['class' => 'progress-bar-success progress-bar-striped active']
    ]); 
?>
<?= $this->render($currentStepView, [
    'step' => $step,
    'database' => $database,
    'admin' => $admin,
    'currentStep' => $currentStep,
    'previousStep' => $currentStep - 1,
    'nextStep' => $currentStep + 1
]); ?>

<div class="alert alert-warning" role="alert">
    <strong>
        <?= Yii::t('install', 'Problems with the installation? <a href="https://github.com/fourteenmeister/comfyCMS/issues">Write to us!</a>'); ?>
    </strong>
</div>
