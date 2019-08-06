<?
namespace Newmark\Replacemarks;
use Bitrix\Main\Config\Option;

class Main{
    private static $allOptions;
    private static $defaultMarks;
    /**
     * @return mixed
     */
    private static function getModuleId()
    {
        return pathinfo(__DIR__)["basename"];
    }

    /**
     * @param $excludePages
     * @return bool
     */
    private static function checkPagePermission($excludePages){
        $curPage = $GLOBALS['APPLICATION']->GetCurPage();
        $pages  = preg_split("/\r\n|\n|\r/", $excludePages);

        foreach ($pages as $key => $page) {
            if(substr($page,-1) == "*"){
                $pageNoMask = substr($page, 0, -1);
                if($curPage != $pageNoMask && strpos($curPage, $pageNoMask) !== false)
                    return false;
            }

            if($curPage == $page)
                    return false;
        }

        return true;
    }
    /**
     * @param $module_id
     * @return array
     */
    private static function getOptions(){
        if(!empty(self::$allOptions))
            return self::$allOptions;
        $optionsArr = array(
            "switch_on" 	=> Option::get(self::getModuleId(), "switch_on", "Y"),
            "exclude"       => Option::get(self::getModuleId(), "exclude", ""),
            "marks"         => Option::get(self::getModuleId(), 'marks', "")
        );
        self::$allOptions = $optionsArr;
        return $optionsArr;
    }

    /**
     * @param string $content
     * @return bool
     */
    public static function replaceActions(&$content = ''){
        if(!$content || defined("ADMIN_SECTION"))
            return false;

        $options = self::getOptions();
        if(!$options['marks'])
            $options['marks'] = json_encode(Wordbook::getDefaultArray());

        //start replace?
        if($options['switch_on'] == 'Y' && self::checkPagePermission($options['exclude']))
            self::replace($content, $options);


        return false;
    }

    /**
     * @param $value
     * @return mixed
     */
    private static function getValue($value){
        if(array_key_exists($value['value'], self::$defaultMarks))
            return self::$defaultMarks[$value['value']];
        else
            return $value['value'];
    }

    /**
     * @param $value
     * @param $state
     * @return string
     */
    private static function stateCheck($value, $state){
        switch ($state){
            case 'lower':
                $value = toLower($value);
                break;
            case 'upper':
                $value = toUpper($value);
                break;
        }
        return $value;
    }

    /**
     * @param $marks
     * @return array
     */
    private static function getReplacesArray($marks){
        $arr = array();
        foreach ($marks as $mark => $value) {
            $arr['/'.$mark.'/'] = function ($matches) use ($value){
                return self::stateCheck(self::getValue($value), $value['state']);
            };
        }
        return $arr;
    }

    /**
     *
     */
    private static function fillDefaultMarks(){
        self::$defaultMarks = Wordbook::getValuesArr();
    }

    /**
     * @param $content
     * @param $options
     * @return bool
     */
    private static function replace(&$content, $options){
        $marks = json_decode($options['marks'], true);
        if(!is_array($marks))
            return false;
        self::fillDefaultMarks();
        $content = preg_replace_callback_array(
            self::getReplacesArray($marks),
            $content
        );

        return false;
    }
}

?>