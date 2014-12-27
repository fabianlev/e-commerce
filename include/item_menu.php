<?php
$db = new Database();
$parents = $db->find('categories', 'all', ['conditions' => ['parent_id' => 0]]);
$children = $db->find('categories', 'all', ['conditions' => ['parent_id !=' => 0]]); ?>
<div class="col-md-3 col-md-pull-9">
    <div class="sidey">
        <ul class="nav">
            <li><a href="./"><i class="fa fa-home"></i> &nbsp;Accueil</a></li>
            <li><a href="?rub=items"><i class="fa fa-book"> &nbsp;Tous les Comics</i></a></li>
            <?php foreach ($parents as $key => $parent): ?>
            <li><a href="./#"><i class="fa fa-book"></i> &nbsp;<?= $parent->name; ?></a>
                <ul>
                    <li><a href="?rub=items&category=<?= $parent->id; ?>">Tous les <?= $parent->name ?></a></li>
                    <?php foreach($children as $child): ?>
                        <?= $child->parent_id == $key+1 ? '<li><a href="?rub=items&category=' . $child->id . '">' . $child->name . '</a></li>' : ''; ?>
                    <?php endforeach; ?>
                </ul>
            </li>
        <?php endforeach; ?>

        </ul>
    </div>
</div>