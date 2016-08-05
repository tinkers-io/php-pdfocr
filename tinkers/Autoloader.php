<?php
/**
 * PdfOCR
 */
if (!defined('PDFOCR_ROOT')) {
    define('PDFOCR_ROOT', dirname(__file__));
}
echo dirname(__file__); 
/**
 * Autoloader
 */
class Autoloader
{
    /**
     * Register the Autoloader with SPL
     */
    public static function Register() {
        if (function_exists('__autoload')) {
            //    Register any existing autoloader function with SPL, so we don't get any clashes
            spl_autoload_register('__autoload');
        }
        //    Register ourselves with SPL
        return spl_autoload_register(array('Autoloader', 'Load'));
    }


    /**
     * Autoload a class identified by name
     *
     * @param string $pClassName Name of the object to load
     * @return bool
     */
    public static function Load($className){
        if (class_exists($className,FALSE)) {
            // Either already loaded
            return FALSE;
        }
        
        $classNameCorrected = str_replace('Tinkers\\PdfOCR', '', $className);

        $classFilePath = PDFOCR_ROOT . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $classNameCorrected) . '.php';

        if ((file_exists($classFilePath) === FALSE) || (is_readable($classFilePath) === FALSE)) {
            // Can't load
            return FALSE;
        }

        require($classFilePath);
    }

}

Autoloader::Register();