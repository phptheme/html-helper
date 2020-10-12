<?php
/**
 * @author PhpTheme Dev Team <dev@getphptheme.com>
 * @license MIT
 * @link https://getphptheme.com
 */
namespace PhpTheme\HtmlHelper;

class HtmlHelper
{

    public static function addClass(array $attributes, string $class)
    {
        $attributes['class'] = static::mergeClass(
            array_key_exists('class', $attributes) ? $attributes['class'] : [], 
            (array) $class
        );

        return $attributes;
    }

    public static function mergeClass($class1, $class2)
    {
        if (is_array($class2))
        {
            if (!is_array($class1))
            {
                $class1 = explode(' ', $class1);
            }

            foreach($class2 as $class)
            {
                if (array_search($class, $class1) === false)
                {
                    $class1[] = $class;
                }
            }

            return implode(' ', $class1);
        }

        return $class2;
    }

    public static function explodeStyle(string $style)
    {
        $return = [];

        $strings = explode(';', $style);

        foreach($strings as $string)
        {
            $string = trim($string);

            if (!$string)
            {
                continue;
            }

            list($key, $value) = explode(':', $string);

            $return[$key] = trim($value);
        }

        return $return;
    }

    public static function implodeStyle(array $style)
    {
        $strings = [];

        foreach($style as $key => $value)
        {
            $strings[] = $key . ': ' . $value;
        }

        return implode('; ', $strings);
    }

    public static function mergeStyle($style1, $style2)
    {
        if (is_array($style2))
        {
            if (!is_array($style1))
            {
                $style1 = static::explodeStyle($style1);
            }

            foreach($style2 as $key => $value)
            {
                $style1[$key] = $value;
            }

            return static::implodeStyle($style1);
        }

        return $style2;
    }    

    public static function mergeAttributes(array $array1, array $array2)
    {
        $args = func_get_args();

        $return = array_shift($args);

        if (count($args) > 1)
        {
            foreach($args as $array)
            {
                $return = static::mergeAttributes($return, $array);
            }

            return $return;
        }

        foreach($array2 as $key => $value)
        {
            if (($key == 'class') && array_key_exists($key, $return))
            {
                $return[$key] = static::mergeClass($return[$key], $value);
            }
            elseif(($key == 'style') && array_key_exists($key, $return))
            {
                $return[$key] = static::mergeStyle($return[$key], $value);
            }
            else
            {
                $return[$key] = $value;
            }
        }

        return $return;
    }

    public static function mergeOptions(array $array1, array $array2)
    {
        $args = func_get_args();

        $return = array_shift($args);

        if (count($args) > 1)
        {
            foreach($args as $array)
            {
                $return = static::mergeOptions($return, $array);
            }

            return $return;
        }

        foreach($array2 as $key => $value)
        {
            if (($key == 'attributes') && array_key_exists($key, $return))
            {
                $return[$key] = static::mergeAttributes($return[$key], $value);
            }
            else
            {
                $return[$key] = $value;
            }
        }

        return $return;
    }

    public static function renderAttributes($attributes) : string
    {
        $return = '';

        if (array_key_exists('class', $attributes) && is_array($attributes['class']))
        {
            $attributes['class'] = implode(' ', $attributes['class']);
        }

        if (array_key_exists('style', $attributes) && is_array($attributes['style']))
        {
            $attributes['style'] = static::implodeStyle($attributes['style']);
        }

        foreach($attributes as $key => $value)
        {
            if ($value === true)
            {
                $return .= ' ' . $key;
            }
            else
            {
                $return .= ' ' . $key . '="' . $value . '"';
            }
        }

        return $return;
    }

    public static function beginTag($tag, array $attributes = [])
    {
        if ($tag)
        {
            return '<' . $tag . static::renderAttributes($attributes) . '>';
        }

        return '';
    }

    public static function endTag($tag)
    {
        if ($tag)
        {
            return '</' . $tag . '>';
        }

        return '';
    }

    public static function tag($tag, $content, array $attributes = [])
    {
        $return = static::beginTag($tag, $attributes);

        $return .= $content;

        $return .= static::endTag($tag);

        return $return;
    }

    public static function shortTag($tag, array $attributes = [])
    {
        return '<' . $tag . static::renderAttributes($attributes) . '>';
    }

}