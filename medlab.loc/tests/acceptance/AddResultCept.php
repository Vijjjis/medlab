<?php 
$I = new AcceptanceTester($scenario);
$I->amOnPage('/php/laborant/add_result.php/');
$I->see('Добавить результат');
$I->fillField('selectpicker_patient','1');
$I->fillField('selectpicker_order_id','500');
$I->fillField('selectpicker_medtest_of_specimen', '17');
$I->click('.add');
?>