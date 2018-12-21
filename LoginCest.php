<?php

namespace tests\api;

use \ApiTester;

class LoginCest 
{
    public function _before(ApiTester $I) 
    {
    }

    public function _after(ApiTester $I) 
    {
    }

    /**
    * @dataProvider pageProvider
    */
    public function checkLogin(AcceptanceTester $I, \Codeception\Example $example)
    {
        //
        $I->sendPOST($example['url'], $example['credentials']);

        //Assertion
        $I->seeResponseContainsJson($example['response']);
    }

    /**
     * @return array
     */
    protected function loginProvider()
    {
        return [
            ['url'=>"/api/auth", 
                'credentials' => [' username' => 'correct', 'password' => 'correct'],
                'response' => ['success' => true, "data" => "", "errors" => null]
            ],
            ['url'=>"/api/auth", 
                'credentials' => [' username' => 'correct', 'password' => 'correct'],
                'response' => ['success' => true, "data" => "", "errors" => [password => [code => 400, "message" => "Неверный пароль"]]]
            ],
            ['url'=>"/api/auth", 
                'credentials' => [' username' => 'correct', 'password' => 'correct'],
                'response' => ['success' => true, "data" => "", "errors" => [username => [code => 400, "message" => "Такой email не зарегистрирован"]]]
            ],
        ];
    }

    //Steps to run Api test
    //Firsst - codecept build
    //Second - codecept run -vv
}