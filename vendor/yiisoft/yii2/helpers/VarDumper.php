<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace yii\helpers;

/**
 * VarDumper is intended to replace the buggy PHP function var_dump and print_r.
 * It can correctly identify the recursively referenced objects in a complex
 * object structure. It also has a recursive depth control to avoid indefinite
 * recursive display of some peculiar variables.
 *
 * VarDumper can be used as follows,
 *
 * ```php
 * VarDumper::dump($var);
 * ```
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class VarDumper extends BaseVarDumper
{
	/** 
 * ������Ѻõı������ 
 * @param mixed $var ���� 
 * @param boolean $echo �Ƿ���� Ĭ��ΪTrue ���Ϊfalse �򷵻�����ַ��� 
 * @param string $label ��ǩ Ĭ��Ϊ�� 
 * @param boolean $strict �Ƿ��Ͻ� Ĭ��Ϊtrue 
 * @return void|string 
 */  
public static function dump($var, $echo=true, $label=null, $strict=true) {  
    $label = ($label === null) ? '' : rtrim($label) . ' ';  
    if (!$strict) {  
        if (ini_get('html_errors')) {  
            $output = print_r($var, true);  
            $output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';  
        } else {  
            $output = $label . print_r($var, true);  
        }  
    } else {  
        ob_start();  
        var_dump($var);  
        $output = ob_get_clean();  
        if (!extension_loaded('xdebug')) {  
            $output = preg_replace('/\]\=\>\n(\s+)/m', '] => ', $output);  
            $output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';  
        }  
    }  
    if ($echo) {  
        echo($output);  
        return null;  
    }else  
        return $output;  
} 
}
