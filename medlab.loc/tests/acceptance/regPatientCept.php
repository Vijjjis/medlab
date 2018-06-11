<?php 
class loginPatientCept
{
    public function _before(AcceptanceTester $I) {}

    public function _after(AcceptanceTester $I) {}

    public function formFillSave(AcceptanceTester $I)
    {
    $I->wantTo('register patient without E-mail');

    $I->amOnPage('/aut/register.php');

    $I->fillField('inputEmail','v@m.ru');
    $I->fillField('inputPassword','12345678');
    $I->fillField('lastName','Aliev');
    $I->fillField('firstName','Timur');
    $I->fillField('fatherName','');
    $I->CheckOption('Gender','Мужской');
    $I->fillField('address','');
    $I->fillField('phone','+79374389251');
    $I->click('.btn-primary');
    $I->sendForm('.form-horizontal');

    $I->haveInDatabase('Patient', array($I->responseForm()));
    }
}
