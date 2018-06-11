<?php 
class loginServiceCept
{
    public function _before(AcceptanceTester $I) {}

    public function _after(AcceptanceTester $I) {}

    public function formFillSave(AcceptanceTester $I)
    {
    $I->wantTo('login serivce');

    $I->amOnPage('/aut/register.php');

    $I->fillField('inputEmail','v@m.ru');
    $I->fillField('inputPassword','12345678');
    $I->click('.btn-primary');
    $I->sendForm('.form-horizontal');
    $mails = $I->grabColumnFromDatabase ('Service', 'ID_Service', array ('E_mail' => 'v@m.ru'));
    if (empty($mails)) {
    	exit();
    }
    }
}
