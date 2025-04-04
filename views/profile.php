<?php
/** @var $user \app\model\account\UserAccount */

/** @var $this \app\core\View */

use app\core\Application;
use app\core\Utils;
use app\models\account\UserAccount;
use app\models\offer\Offer;


$this->title = "Profile";
$this->cssFile = "profile";
$this->jsFile = "profile";

?>


<header class="profile-up">
    <img class="profile-page-pic object-cover" src="<?php echo $user->avatar_url ?>">
    <i data-lucide="pen_line"></i>
    <div class="profile-name">
        <h1 class="heading-2 gap-1">Profil de <span class="underline">
              <?php if ($user->isProfessional()) { ?>
                  <?php echo $user->specific()->denomination ?>
              <?php } else { ?>
                  <?php echo $user->specific()->firstname . " " . $user->specific()->lastname ?>
              <?php } ?>
          </span>
        </h1>
        <div class="profile-stats">
            <h3 class="flex heading-3 align-center gap-2">
                <i data-lucide="message-circle"></i>
                <?php if (!$user->isAdministrator()) { ?>
                    <?php if ($user->isProfessional()) { ?>
                        <span class="pt-1"><?php echo $user->specific()->opinionsReceiveCount() ?> avis reçu</span>
                    <?php } else { ?>
                        <span class="pt-1"><?php echo $user->specific()?->opinionsCount() ?> avis publié</span>
                    <?php } ?>
                <?php } ?>
            </h3>
            <?php if ($user->isProfessional()) { ?>
                <h3 class="flex heading-3 align-center gap-2">
                    <i data-lucide="heart"></i>
                    <span class="pt-1"> <?php echo $user->specific()?->offerLikes() ?>  likes</span>
                </h3>
            <?php } ?>

            <h3 class="flex heading-3 align-center gap-2">
                <i data-lucide="badge-check"></i>
                <span class="pt-1">
                    <?php if ($user->isPublicProfessional()) { ?>
                        Professionnel publique
                    <?php } elseif ($user->isPrivateProfessional()) { ?>
                        Professionnel privé
                    <?php } else { ?>
                        Membre
                    <?php } ?>
                </span>
            </h3>
            <?php if ($user->account_id == Application::$app->user->account_id) { ?>
                <a href="modification" class="mt-4">
                    <button class="button gray">Modifier mon profil<i data-lucide="pen-line"></i></button>
                </a>
            <?php } ?>
        </div>
    </div>
</header>


<?php if ($user->isProfessional()) { ?>
    <div class="flex flex-col gap-4">
        <div id="offers-container" class="flex flex-col gap-4 mt-4">
            <div id="offers-loader"></div>
        </div>
<!--        <x-tabs>-->
<!--            <x-tab class="profile-up-bandeau profile-up-bandeau-l" id="offres" role="heading"-->
<!--                   slot="tab">Offre-->
<!--            </x-tab>-->
<!--            <x-tab-panel role="region" slot="panel">-->
<!--                 All offers generated in js file -->-->
<!--                -->
<!--            </x-tab-panel>-->
<!---->
<!--            <x-tab class="profile-bandeau profile-up-bandeau-r" id="reponses" role="heading"-->
<!--                   slot="tab">Réponse-->
<!--            </x-tab>-->
<!--            <x-tab-panel role="region" slot="panel">-->
<!---->
<!--            </x-tab-panel>-->
<!--        </x-tabs>-->
    </div>
<?php } else { ?>
    <div class="flex items-center justify-center">
        <!-- All opinions generated in jsfile -->
        <div id="opinions-container" class="opinions-container">
            <div id="opinions-loader"></div>
        </div>
    </div>
<?php } ?>

<!--

<img src="https://content.imageresizer.com/images/memes/One-Piece-Enel-Shocked-meme-9.jpg">

!-->