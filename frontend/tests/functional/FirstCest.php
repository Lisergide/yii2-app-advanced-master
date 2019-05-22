<?php namespace frontend\tests\functional;

use frontend\tests\FunctionalTester;

// В фронтэнде создать класс функциональных тестов, реализовать в нем проверку с помощью датапровайдера
// содержимое активного (выделенного) пункта меню на всех страницах фронтэнда. Тест должен проходить успешно
class FirstCest
{
    public function _before(FunctionalTester $I)
    {
    }

    // tests

    /**
     * @dataProvider pageProvider
     */
    public function tryToTest(FunctionalTester $I, \Codeception\Example $data)
    {
        $I->amOnPage($data['url']);
        $I->see($data['li.active>a'], 'li.active>a');
    }

    protected function pageProvider()
    {
        return [
            ['url' => '/', 'li.active>a' => 'Home'],
            ['url' => 'site/about', 'li.active>a' => 'About'],
            ['url' => 'site/contact', 'li.active>a' => 'Contact'],
            ['url' => 'site/signup', 'li.active>a' => 'Signup'],
            ['url' => 'site/login', 'li.active>a' => 'Login'],
        ];
    }
}
