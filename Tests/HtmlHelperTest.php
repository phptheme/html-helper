<?php
/**
 * @author PhpTheme Dev Team <dev@getphptheme.com>
 * @license MIT
 * @link http://getphptheme.com
 */
namespace PhpTheme\HtmlHelper\Tests;

use PhpTheme\HtmlHelper\HtmlHelper;

class HtmlHelperTest extends \PHPUnit\Framework\TestCase
{

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