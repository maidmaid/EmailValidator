<?php

namespace Egulias\Tests\EmailValidator\Validation;

use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\DNSCheckValidation;
use Egulias\EmailValidator\Validation\MultipleValidationWithAnd;
use Egulias\EmailValidator\Validation\NoRFCWarningsValidation;
use Egulias\EmailValidator\Validation\RFCValidation;

class IsEmailFunctionTests extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider isEmailTestSuite
     */
    public function testAgainstIsEmailTestSuite($email)
    {
        $validator = new EmailValidator();
        $validations = new MultipleValidationWithAnd([
            new NoRFCWarningsValidation(),
            new DNSCheckValidation()
        ]);

        $this->assertFalse($validator->isValid($email, $validations), "Tested email " . $email);

    }

    public function isEmailTestSuite()
    {
        $testSuite = dirname(__FILE__) . '/../../resources/is_email_tests.xml';
        $document = new \DOMDocument();
        $document->load($testSuite);
        $elements = $document->getElementsByTagName('test');
        $tests = [];

        foreach($elements as $testElement) {
            $childNode = $testElement->childNodes;
            $tests[][] = ($childNode->item(1)->getAttribute('value'));
        }

        return $tests;
    }
}
