<?php
/**
 * @author PhpTheme Dev Team <dev@getphptheme.com>
 * @license MIT
 * @link https://getphptheme.com
 */
use PhpTheme\HtmlHelper\HtmlHelper;

class HtmlHelperTest extends \PHPUnit\Framework\TestCase
{

    public function testAddClass()
    {
        $attributes = HtmlHelper::addClass(['class' => 'class1'], 'class2');

        $attributes = HtmlHelper::addClass($attributes, 'class2');

        $classes = explode(' ', $attributes['class']);

        $this->assertTrue((array_search('class1', $classes) !== false) ? true : false);

        $this->assertTrue((array_search('class2', $classes) !== false) ? true : false);
    
        $this->assertEquals(count($classes), 2);
    }

    public function testExplodeStyle()
    {
        $attributes = HtmlHelper::explodeStyle('width: 1%; white-space: nowrap; padding: 0px 10px;');

        $this->assertEquals($attributes, [
            'width' => '1%',
            'white-space' => 'nowrap',
            'padding' => '0px 10px'
        ]);
    }

}