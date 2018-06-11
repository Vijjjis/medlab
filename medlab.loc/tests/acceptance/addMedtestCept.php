<?php 
$I = new AcceptanceTester($scenario);
$I->wantTo('Добавление исследования');
$I->amOnPage('/php/operator/medtestcontrol/mc.php/');
$I->see('Medtest');
$I->fillField('name','');
$I->fillField('price','170');
$I->fillField('typebio', 'Кровь');
$I->click('.result-button');
$I->haveInDatabase('Patient', array('name' => '', 'price'=>'170' , 'typebio' => 'Кровь'));
?>