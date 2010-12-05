<?php

namespace Respect\Validation\Rules;

class PrivClass
{

    private $bar = 'foo';

}

class HasAttributeTest extends \PHPUnit_Framework_TestCase
{

    public function testHasAttribute()
    {
        $validator = new HasAttribute('bar');
        $obj = new \stdClass;
        $obj->bar = 'foo';
        $this->assertTrue($validator->assert($obj));
    }

    /**
     * @expectedException Respect\Validation\Exceptions\ValidationException
     */
    public function testNotNull()
    {
        $validator = new HasAttribute('bar');
        $obj = new \stdClass;
        $obj->baraaaaa = 'foo';
        $this->assertTrue($validator->assert($obj));
    }

    /**
     * @dataProvider providerForInvalidAtrributeNames
     * @expectedException Respect\Validation\Exceptions\ComponentException
     */
    public function testInvalidParameters($attributeName)
    {
        $validator = new HasAttribute($attributeName);
    }

    public function providerForInvalidAtrributeNames()
    {
        return array(
            array(new \stdClass),
            array(123),
            array('')
        );
    }

    public function testValidatorAttribute()
    {
        $subValidator = new StringLength(1, 3);
        $validator = new HasAttribute('bar', $subValidator);
        $obj = new \stdClass;
        $obj->bar = 'foo';
        $this->assertTrue($validator->assert($obj));
    }

    public function testValidatorPrivateAttribute()
    {
        $subValidator = new StringLength(1, 3);
        $validator = new HasAttribute('bar', $subValidator);
        $obj = new PrivClass;
        $this->assertTrue($validator->assert($obj));
    }

}