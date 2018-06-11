<?php 
class loginServiceCept
{
    public function _before(AcceptanceTester $I) {}

    public function _after(AcceptanceTester $I) {}

    public function formFillSave(AcceptanceTester $I)
    {
    $I->wantTo('login serivce');

    $I->amOnPage('/');

    $I->seeLink('#get_resutl');
    $I->see("Modal");
    $I->fillField('order','700');
    $I->click('.get_result');
    $I->sendForm('#modal_form');
    $result = $I->seeInDatabase ('Orders', array ($I->responseForm()));
	}
}