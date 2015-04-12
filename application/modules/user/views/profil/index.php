<?php 
    $profil = $this->get('profil'); 
    $birthday = new \Ilch\Date($profil->getBirthday());
    $groups = '';
    foreach($profil->getGroups() as $group) {
        if ($groups != '') {
            $groups .= ', ';
        }

        $groups .= $group->getName();
    } 
?>

<div class="profil">
    <div class="profil-header">
        <div class="row">
            <div class="col-lg-2">
                <img class="thumbnail" src="<?=$this->getStaticUrl().'../'.$this->escape($profil->getAvatar()) ?>" title="<?=$this->escape($profil->getName()) ?>">
            </div>
            <div class="col-lg-5 col-xs-12">
                <h3><?=$this->escape($profil->getName()) ?></h3>
                <?php if($this->getUser() and $this->getUser()->getId() != $this->escape($profil->getID())): ?>
                    <a href="<?=$this->getUrl(array('module' => 'user', 'controller' => 'panel', 'action' => 'dialognew', 'id' => $profil->getId())) ?>" >Neue Nachricht</a>
                 <?php endif; ?>
                <div class="detail">
                    <i class="fa fa-sign-in" title="<?=$this->getTrans('regist') ?>"></i> <?=$this->escape($profil->getDateCreated()) ?>
                </div>
            </div>
            <div class="col-lg-4 hidden-xs concatLinks-lg">
                <a class="fa fa-envelope" title="E-Mail"></a>
                <a class="fa fa-globe" title="<?=$this->getTrans('website') ?>"></a>
                <a class="fa fa-facebook" title="Facebook"></a>
                <a class="fa fa-google-plus" title="Goggle+"></a>
                <a class="fa fa-twitter" title="Twitter"></a>
            </div>
        </div>
        
    </div>
    <br />
    <div class="profil-content">
        <legend><?=$this->getTrans('profileDetails') ?></legend>
        <div class="row">
            <div class="col-lg-2 detail bold">
                First Name:
            </div>
            <div class="col-lg-8 detail">
                <?=$this->escape($profil->getFirstName()) ?>
            </div>
        </div>
         <div class="row">
            <div class="col-lg-2 detail bold">
                Last Name:
            </div>
            <div class="col-lg-8 detail">
                <?=$this->escape($profil->getLastName()) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2 detail bold">
                Wohnort:
            </div>
            <div class="col-lg-8 detail">
                <?=$this->escape($profil->getCity()) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2 detail bold">
                Homepage:
            </div>
            <div class="col-lg-8 detail">
                <?=$this->escape($profil->getHomepage()) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2 detail bold">
                Birthday:
            </div>
            <div class="col-lg-8 detail">
                <?=$birthday->format('d-m-Y', true) ?>
            </div>
        </div>
        <div class="clearfix"></div>
        <br />
        <legend><?=$this->getTrans('others') ?></legend>
        <div class="row">
            <div class="col-lg-2 detail bold">
                <?=$this->getTrans('groups') ?>:
            </div>
            <div class="col-lg-8 detail">
                <?=$this->escape($groups) ?>
            </div>
        </div>
    </div>
</div>
