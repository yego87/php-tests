<?php

namespace tests\unit\app\models;

use app\models\Button;

/**
 * Test for model Button
 */
class ButtonTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @inheritdoc
     */
    protected Button $button;

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        parent::setUp();
        $this->$button = new Button();
    }

    /**
    * @dataProvider validationProvider
    */
    public function testValidation($values, $expectedResult)
    {
        $this->button->attributes = $values;
        $actualResult = $this->button->validate();

        $this->tester->assertEquals($expectedResult, $actualResult);
    }

    /**
     * @return array
     */
    protected function validationProvider()
    {
        return [
            ['empty value' => 
                ['value' => null],
                false
            ],
            ['not string' => 
                ['value' => true],
                false
            ],
            ['invalid UTF8' => 
                ['value' => "\xc3\x28"],
                false
            ],
            ['correct value' => 
                ['value' => "correct"],
                true
            ]
        ];
    }
    
    /**
    * @dataProvider socialButtonProvider
    */
    public function testGetSocialButtonCorrect($types, $expectedInstance)
    {
        foreach ($types as $type) {
            $this->button->type = $type
            $actualInstance = $this->button->getSocialButton();
      
            $this->tester->assertInstanceOf($expectedInstance, $actualInstance);
        }
    }
    
    /**
     * @return array
     */
    protected function socialButtonProvider()
    {
        return [
            ['correct types of Buttons' => 
                ['buttons' => 
                    ['email', 'instagram', 'messenger', 'odnoklassniki', 'vk']//...and other buttons
                ],
                ['instance' => 'app\models\base\Button']
            ]
        ];
    }

    public function testGetSocialButtonTrownException()
    {
        $this->tester->expectThrowable(new \RuntimeException('Type not allowed'), function() {
            $this->button->type = 'exception';
            $this->button->getSocialButton();
        });
    }
}
