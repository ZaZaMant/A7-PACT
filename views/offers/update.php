<?php

/** @var $offer \app\models\offer\Offer */
/** @var $address \app\models\Address */
/** @var $specificData \app\core\DBModel */
/** @var $this \app\core\View */

use app\core\Application;
use app\core\form\Form;
use app\models\offer\Offer;

//var_dump($offer);

$this->title = "Modification d'une offre";
$this->jsFile = "offerUpdate";

$form = new Form();

?>

<!-- Title -->
<div class="w-full flex flex-col gap-2 items-center justify-center py-16">
    <h3 class="heading-3 text-gray-4">Modifier l'offre</h3>
    <h1 class="heading-1"><?php echo $offer['title'] ?></h1>
</div>

<form action="" method="post" id="create-offer" enctype="multipart/form-data">

    <div class="grid grid-cols-5 gap-8">
        <div class="w-full flex flex-col col-span-3">

            <div class="flex flex-col gap-12">

                <!-- ------------------------------------------------------------------- -->
                <!-- Information of the option                                           -->
                <!-- ------------------------------------------------------------------- -->

                <section>
                    <h2 class="section-header">Informations</h2>

                    <div class="flex flex-col gap-2">
                        <?php echo $form->field($model, 'title') ?>
                        <?php echo $form->textarea($model, 'summary') ?>
                        <?php echo $form->textarea($model, 'description') ?>

                        <!-- Tags of the category -->
                        <?php $tags = [
                            'restaurant'=> ['Française', 'Fruit de mer', 'Plastique', 'Italienne', 'Indienne', 'Gastronomique', 'Restauration rapide', 'Crêperie'],
                            'others'=> ['Culturel', 'Gastronomie', 'Patrimoine', 'Musée', 'Histoire', 'Atelier', 'Urbain', 'Musique', 'Nature', 'Famille', 'Plein air', 'Cirque', 'Sport', 'Son et lumière', 'Nautique', 'Humour']
                        ] ?>
                        <div id="tags" class="grid grid-cols-2 my-2">
                            <?php if ($offer['category']=='restaurant'){foreach ($tags['restaurant'] as $tag) {?>
                            <div class="flex items-center gap-1">
                                <input type="checkbox" class="checkbox checkbox-normal" name="tags[]"
                                    value="<?php echo $tag; ?>" id="<?php echo $tag; ?>">
                                <label for="<?php echo $tag; ?>"><?php echo $tag; ?></label>
                            </div>
                            <?php }} else {foreach ($tags['others'] as $tag) { ?>
                            <div class="flex items-center gap-1">
                                <input type="checkbox" class="checkbox checkbox-normal" name="tags[]"
                                    value="<?php echo $tag; ?>" id="<?php echo $tag; ?>">
                                <label for="<?php echo $tag; ?>"><?php echo $tag; ?></label>
                            </div>
                            <?php } }?>
                        </div>

                        <!-- Site web of the offer -->
                        <?php echo $form->field($model, 'website') ?>
                        <?php echo $form->field($model, 'phone_number') ?>
                    </div>
                </section>


                <!-- ------------------------------------------------------------------- -->
                <!-- Complementary data                                                       -->
                <!-- ------------------------------------------------------------------- -->

                <section id="complementary-section">

                    <h2 class="section-header">Informations complémentaires </h2>
                    <?php
                switch ($offer['category']) {
                    case 'restaurant':
                        ?>
                    <!-- Restaurant -->
                    <div class="complementary-section flex flex-col gap-4" data-category="restaurant">
                        <div class="flex flex-col gap-2">
                            <label for="restaurant-image">Image de la carte</label>
                            <input id="restaurant-image" type="file" accept="image/png, image/jpg"
                                name="restaurant-image" required>
                        </div>

                        <!-- Range price for the RESTAURANT -->
                        <div class="flex gap-4">

                            <x-select id="price-low" name="price-range" value="1" class="w-full" required>
                                <label slot="label">Gamme de prix</label>
                                <span slot="trigger">€</span>
                                <div slot="options">
                                    <div data-value="1">€ - menu à moins de 25€</div>
                                    <div data-value="2">€€ - entre 25 et 40€</div>
                                    <div data-value="3">€€€ - au-delà de 40€</div>
                                </div>
                            </x-select>

                        </div>
                    </div>

                    <?php
                        break;
                    case 'activity':
                        ?>
                    <!-- Activity -->
                    <div class="complementary-section flex flex-col gap-4" data-category="activity">
                        <?php echo $form->field($specificData, 'duration')->numberField() ?>
                        <?php echo $form->field($specificData, 'required_age')->numberField() ?>
                    </div>
                    <?php
                        break;
                    case 'show':
                        ?>
                    <!-- Show -->
                    <div class="complementary-section flex flex-col gap-4" data-category="show">
                        <?php echo $form->field($specificData, 'duration')->numberField() ?>
                        <?php echo $form->field($specificData, 'capacity')->numberField() ?>

                    </div> <!-- Period for visit and show -->
                    <div id="period-section" class="flex flex-col gap-4 mt-4">

                        <div class="flex gap-4 items-center">
                            <div class="flex items-center">
                                <input class="switch" type="checkbox" id="switch-period" name="visit-guide" />
                                <label class="switch" for="switch-period"></label>
                            </div>
                            <label for="switch-period" id="switch-period-label">A une période</label>
                        </div>

                        <div id="period-fields" class="flex gap-4 hidden"></div>
                    </div><?php
                        break;
                    case 'visit': ?>
                    <!-- Visit -->

                    <div class="complementary-section flex flex-col gap-4" data-category="visit">
                        <?php echo $form->field($specificData, 'duration')->numberField() ?>
                        <div class="flex gap-4 items-center">
                            <div class="flex items-center">
                                <input class="switch" type="checkbox" id="switch-guide" name="visit-guide" />
                                <label class="switch" for="switch-guide"></label>
                            </div>
                            <label for="switch-guide">Avec guide de visite</label>
                        </div>
                        <!--<x-input>
                             <p slot="label">Durée de la visite (h)</p>
                            <input slot="input" type="text" name="visit-duration" placeholder="2h15" required>
                        </x-input>

                        <x-input>
                            <p slot="label">Langues disponibles pour la visite</p>
                            <input slot="input" type="text" name="visit-languages" placeholder="anglais,français..."
                                required>
                            <p slot="helper">Séparez les langues par une ,</p>
                        </x-input>

                        <div class="flex gap-4 items-center">
                            <div class="flex items-center">
                                <input class="switch" type="checkbox" id="switch-guide" name="visit-guide" />
                                <label class="switch" for="switch-guide"></label>
                            </div>
                            <label for="switch-guide">Avec guide de visite</label>
                        </div>

                    </div>
                    <!-- Period for visit and show -->
                    <div id="period-section" class="flex flex-col gap-4 mt-4">

                        <div class="flex gap-4 items-center">
                            <div class="flex items-center">
                                <input class="switch" type="checkbox" id="switch-period" name="visit-guide" />
                                <label class="switch" for="switch-period"></label>
                            </div>
                            <label for="switch-period" id="switch-period-label">A une période</label>
                        </div>

                        <div id="period-fields" class="flex gap-4 hidden"></div>
                    </div><?php
                        break;
                    case 'attraction_park':
                        ?>
                    <!-- Attraction parc-->
                    <div class="complementary-section flex flex-col gap-4" data-category="attraction-parc">
                        <?php echo $form->field($specificData, 'url_image_park_map') ?>
                        <?php echo $form->field($specificData, 'required_age')?>
                    </div>
                    <?php
                        break;
                } ?>
                </section>


                <!-- ------------------------------------------------------------------- -->
                <!-- Localisation                                                        -->
                <!-- ------------------------------------------------------------------- -->

                <section>
                    <h2 class="section-header">Localisation</h2>

                    <div class="flex flex-col gap-4">
                        <x-input>
                            <p slot="label">Adresse complète</p>
                            <input slot="input" id="address-field" type="text" placeholder="">
                            <p slot="helper">Champ avec suggestions qui modifie les champs suivants</p>
                            <div slot="list" id="address-autocomplete" data-no-filter></div>
                        </x-input>

                        <div class="flex flex-col gap-2">
                            <div class="flex gap-4">
                                <?php echo $form->field($address, 'number') ?>
                                <!--                            <x-input class="w-[200px]">-->
                                <!--                                <p slot="label">Numéro de rue</p>-->
                                <!--                                <input slot="input" id="address-number" type="number" name="address-number"-->
                                <!--                                    placeholder="2">-->
                                <!--                            </x-input>-->
                                <?php echo $form->field($address, 'street') ?>
                                <!--                            <x-input>-->
                                <!--                                <p slot="label">Nom de la rue</p>-->
                                <!--                                <input slot="input" id="address-street" type="text" name="address-street"-->
                                <!--                                    placeholder="Rue Edouard Branly" required>-->
                                <!--                            </x-input>-->
                            </div>
                            <div class="flex gap-4">
                                <?php echo $form->field($address, 'postal_code') ?>
                                <!--                            <x-input class="w-[200px]">-->
                                <!--                                <p slot="label">Code postal</p>-->
                                <!--                                <input slot="input" id="address-postal-code" type="text" name="address-postal-code"-->
                                <!--                                    placeholder="22300" required>-->
                                <!--                            </x-input>-->
                                <?php echo $form->field($address, 'city') ?>
                                <!--                            <x-input>-->
                                <!--                                <p slot="label">Ville</p>-->
                                <!--                                <input slot="input" id="address-city" type="text" name="address-city"-->
                                <!--                                    placeholder="Lannion" required>-->
                                <!--                            </x-input>-->
                            </div>

                            <!-- Longitude and latitude inputs -->
                            <input id="address-latitude" type="hidden" name="address-latitude">
                            <input id="address-longitude" type="hidden" name="address-longitude">
                        </div>
                    </div>

                </section>


                <!-- ------------------------------------------------------------------- -->
                <!-- Schedules                                                           -->
                <!-- ------------------------------------------------------------------- -->

                <section id="schedules-section" class="hidden">
                    <h2 class="section-header">Horaires</h2>

                    <div class="flex flex-col gap-4">

                        <!-- Schedule table -->
                        <table id="schedule-table" class="table center">
                            <thead>
                                <tr>
                                    <th class="table-head" colspan="3">Grille des horaires</th>
                                </tr>
                                <tr>
                                    <th>Jour</th>
                                    <th>Ouverture</th>
                                    <th>Fermeture</th>
                                </tr>
                            </thead>

                            <!-- Days of the week are generated in the offerCreate.js -->
                            <tbody id="schedules-rows"></tbody>
                        </table>
                    </div>
                </section>

                <!-- ------------------------------------------------------------------- -->
                <!-- Price                                                               -->
                <!-- ------------------------------------------------------------------- -->

                <section class="flex flex-col hidden" id="price-section">
                    <h2 class="section-header">Vos prix</h2>

                    <div class="flex flex-col gap-2">

                        <!-- Free offer -->
                        <div class="flex gap-2 items-center">
                            <input type="radio" id="price-free" name="price" value="free" checked>
                            <label for="price-free" class="flex flex-col gap-1">Offre gratuite</label>
                        </div>

                        <!-- Paying offer -->
                        <div class="flex gap-2 items-center">
                            <input type="radio" id="price-paying" name="price" value="paying">
                            <label for="price-paying" class="flex flex-col gap-1">Offre payante</label>
                        </div>

                    </div>

                    <div id="price-fields" class="flex flex-col gap-4 hidden">

                        <!-- Minimum price for offers that NOT RESTAURANT -->
                        <div class="flex gap-4 mt-4" id="offer-minimum-price">

                            <x-input>
                                <p slot="label">Prix minimum</p>
                                <input slot="input" type="number" name="restaurant-min-price" min="1">
                            </x-input>

                        </div>

                        <!-- Price table -->
                        <table class="table center hidden">
                            <thead>
                                <tr>
                                    <th class="table-head" colspan="2">Grille tarifaire</th>
                                </tr>
                                <tr>
                                    <th>Dénomination</th>
                                    <th>Prix</th>
                                </tr>
                            </thead>

                            <tbody id="prices-rows">
                                <tr>
                                    <td>
                                        <input id="price-name" name="prices[]" type="text" placeholder="Nom"
                                            class="table-input">
                                    </td>
                                    <td>
                                        <input id="price-value" name="prices[]" type="number" placeholder="Prix"
                                            class="table-input">
                                    </td>
                                </tr>
                            </tbody>

                            <tfoot>
                                <tr>
                                    <td colspan="2">
                                        <button id="add-price-row" class="table-button">
                                            Ajouter un tarif
                                            <i data-lucide="plus"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                </section>


                <!-- ------------------------------------------------------------------- -->
                <!-- Photos                                                              -->
                <!-- ------------------------------------------------------------------- -->

                <section>
                    <h2 class="section-header">Photos ou illustrations</h2>

                    <div class="flex flex-col gap-4">

                        <!-- Uploader -->
                        <label for="photo-input" class="image-uploader">
                            <input type="file" accept="image/png, image/jpeg" id="photo-input" multiple hidden>

                            <i data-lucide="upload"></i>
                            <p>Faire glisser des fichiers pour les uploader</p>
                            <span class="button gray">Selectionner les fichier à uploader</span>
                        </label>

                        <!-- Photos -->
                        <div id="photos" class="flex flex-col gap-2">
                            <?php foreach ($offer['images'] as $image) { ?>
                            <div class="uploaded-image-card" draggable="true">
                                <input class="image-id" type="text" value="<?php echo $image->id ?>" hidden>
                                <div class="image-container">
                                    <img src="<?php echo $image->url_photo ?>" alt="Photo"
                                        class="w-20 h-20 object-cover rounded-lg" draggable="false">
                                </div>
                                <div class="card-buttons">
                                    <div>
                                        <button class="photo-remove button gray no-border only-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-trash-2">
                                                <path d="M3 6h18" />
                                                <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                                                <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                                                <line x1="10" x2="10" y1="11" y2="17" />
                                                <line x1="14" x2="14" y1="11" y2="17" />
                                            </svg>
                                        </button>
                                        <button class="photo-maximise button gray no-border only-icon" disabled>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-maximize-2">
                                                <polyline points="15 3 21 3 21 9" />
                                                <polyline points="9 21 3 21 3 15" />
                                                <line x1="21" x2="14" y1="3" y2="10" />
                                                <line x1="3" x2="10" y1="21" y2="14" />
                                            </svg>
                                        </button>
                                        <button class="photo-crop button gray no-border only-icon" disabled>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-crop">
                                                <path d="M6 2v14a2 2 0 0 0 2 2h14" />
                                                <path d="M18 22V8a2 2 0 0 0-2-2H2" />
                                            </svg>
                                        </button>
                                    </div>

                                    <button class="photo-drag button gray no-border only-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-grip-vertical">
                                            <circle cx="9" cy="12" r="1" />
                                            <circle cx="9" cy="5" r="1" />
                                            <circle cx="9" cy="19" r="1" />
                                            <circle cx="15" cy="12" r="1" />
                                            <circle cx="15" cy="5" r="1" />
                                            <circle cx="15" cy="19" r="1" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <?php } ?>
                        </div>

                    </div>
                </section>

            </div>
        </div>


        <!-- ------------------------------------------------------------------- -->
        <!-- Sidebar                                                             -->
        <!-- ------------------------------------------------------------------- -->

        <aside id="sidebar" class="sticky col-span-2 h-fit mt-4 flex flex-col gap-4">
            <div class="flex flex-col gap-2">
                <div class="flex flex-col gap-2">
                    <div class="flex gap-4 items-center">
                        <div class="flex items-center">
                            <input class="switch" type="checkbox" id="switch-online" name="online"
                                <?php if ($offline == 1) { echo'checked';} ?> />
                            <label class="switch" for="switch-online"></label>
                        </div>
                        <label for="switch-online">Mise en ligne de l'offre</label>
                    </div>
                    <a href="/dashboard" class="button gray">Annuler</a>
                    <a href="/offres/preview" class="button gray" aria-disabled>Preview de l'offre</a>
                    <button class="button purple" form="create-offer" type="submit">Modifier l'offre</button>
                </div>
        </aside>

    </div>
</form>