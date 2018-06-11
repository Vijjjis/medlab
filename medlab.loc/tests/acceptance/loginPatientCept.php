<?php 
class loginPatientCept
{
    public function _before(AcceptanceTester $I)
    {
    }

    public function _after(AcceptanceTester $I)
    {
    }

    public function formFillSave(AcceptanceTester $I)
    {
        $I->wantTo('Вход для пациента');

        $I->amOnPage('/login/');

        $I->fillField('email','v@m.ru');
        $I->fillField('password','12345678');
        $I->click('.user-form input[type=submit]');

        $I->seeInDatabase('Patient',     [
            'E_mail' => 'v@m.ru',
            'Password' => '550e1bafe077ff0b0b67f4e32f29d751',
        ]);

    }

}
?>
