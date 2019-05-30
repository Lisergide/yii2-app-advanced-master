<?php namespace frontend\tests;

use common\models\LoginForm;
use frontend\models\ContactForm;

// Создайте класс юнит тестов во фронтэнде, реализовав в нем проверки с помощью перечисленных методов,
// тест должен проходить успешно.
class FirstTest extends \Codeception\Test\Unit
{
    /**
     * @var \frontend\tests\UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testVariable()
    {
        // Используйте хотя бы для одной проверки BDD стиль описания expect()->.
        // - $this->assertTrue - сравнении с true
        $obj = new LoginForm();
        expect('rememberMe is true', $obj->rememberMe)->equals(true);

        $a = 123;
        $this->assertNotEmpty($a);
        // - $this->assertEquals - равно ожидаемому значению
        $this->assertEquals(123, $a);
        // - $this->assertLessThan - меньше ожидаемого значения
        $this->assertLessThan(223, $a);

        $contactForm = new ContactForm([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'subject' => 'Doe LTD',
            'body' => 'John Doe Example',

        ]);

        // - $this->assertAttributeEquals - значение атрибута (свойства) объекта равно ожидаемому значению
        $this->assertAttributeEquals('John Doe', 'name', $contactForm);
        $this->assertAttributeEquals('johndoe@example.com', 'email', $contactForm);
        $this->assertAttributeEquals('Doe LTD', 'subject', $contactForm);
        $this->assertAttributeEquals('John Doe Example', 'body', $contactForm);

        $array = [
            'id' => 1,
            'username' => 'admin',
            'email' => 'admin@example.ru',
            'avatar' => 'yes',
            'status' => 10
        ];

        // - $this->assertArrayHasKey - в массиве есть указанный ключ
        $this->assertArrayHasKey('username', $array);
        $this->assertArrayHasKey('avatar', $array);
    }
}