<?php
/** @var $model \app\forms\MemberRegisterForm */

$this->title = 'Inscription membre';
$this->jsFile = 'registerMember';

?>

<div class="form-page">
    <div class="h-auth">
        <h1 class="heading-1">Inscription</h1>
        <div class="q-auth">
            <p>Déjà un compte ?</p>
            <a href="/connexion" class="link">Se connecter</a>
        </div>
    </div>
    <?php $form = \app\core\form\Form::begin('', 'post', '', 'flex flex-col justify-center items-center') ?>
    <div class="flex flex-col w-[600px] gap-6">
        <div class="form-inputs">
            <div class="flex gap-4">
                <?php echo $form->field($model, 'lastname') ?>
                <?php echo $form->field($model, 'firstname') ?>
            </div>

            <?php echo $form->field($model, 'pseudo') ?>
            <?php echo $form->field($model, 'mail') ?>
            <?php echo $form->field($model, 'phone') ?>
            <div class="flex gap-4">
                <div class="w-25%">
                    <?php echo $form->field($model, 'streetNumber') ?>
                </div>
                <?php echo $form->field($model, 'streetName') ?>
            </div>
            <div class="flex gap-4">
                <div class="w-25%">
                    <?php echo $form->field($model, 'postalCode') ?>
                </div>
                <?php echo $form->field($model, 'city') ?>
            </div>

            <?php echo $form->field($model, 'password')->passwordField() ?>
            <?php echo $form->field($model, 'passwordConfirm')->passwordField() ?>
        </div>
        <div class="flex flex-col gap-4">
            <div class="flex gap-4 items-center">
                <div class="flex items-center">
                    <input class="switch" type="checkbox" id="switch-notification" name="notification" value="true" />
                    <label class="switch" for="switch-notification"></label>
                </div>
                <label for="switch-period" id="switch-period-label">J’autorise l’envoi de notifications concernant
                    la mise en ligne de nouvelles offres et autre</label>
            </div>
            <div class="flex gap-4 items-center">
                <div class="flex items-center">
                    <input class="switch" type="checkbox" id="switch-condition-utilisation" />
                    <label class="switch" for="switch-condition-utilisation"></label>
                </div>
                <label for="switch-period" id="switch-period-label">J'accepte les <a href="" class="link">conditions générales d'utilisation</a></label>
            </div>
        </div>
        <button type="submit" class="button w-full ">S'inscrire</button>
    </div>
    <?php \app\core\form\Form::end() ?>
</div>