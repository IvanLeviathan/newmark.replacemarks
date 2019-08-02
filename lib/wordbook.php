<?

namespace Newmark\Replacemarks;

class Wordbook
{
    private static $monthNounce = array(
        "01" => array(
            "D" => "Январю",
            "T" => "Январем",
            "P" => "Январе",
        ),
        "02" => array(
            "D" => "Февралю",
            "T" => "Февралем",
            "P" => "Феврале",
        ),
        "03" => array(
            "D" => "Марту",
            "T" => "Мартом",
            "P" => "Марте",
        ),
        "04" => array(
            "D" => "Апрелю",
            "T" => "Апрелем",
            "P" => "Апреле",
        ),
        "05" => array(
            "D" => "Маю",
            "T" => "Маем",
            "P" => "Мае",
        ),
        "06" => array(
            "D" => "Июню",
            "T" => "Июнем",
            "P" => "Июне",
        ),
        "07" => array(
            "D" => "Июлю",
            "T" => "Июлем",
            "P" => "Июле",
        ),
        "08" => array(
            "D" => "Августу",
            "T" => "Августом",
            "P" => "Августе",
        ),
        "09" => array(
            "D" => "Сентябрю",
            "T" => "Сентябрем",
            "P" => "Сентябре",
        ),
        "10" => array(
            "D" => "Октябрю",
            "T" => "Октябрем",
            "P" => "Октябре",
        ),
        "11" => array(
            "D" => "Ноябрю",
            "T" => "Ноябрем",
            "P" => "Ноябре",
        ),
        "12" => array(
            "D" => "Декабрю",
            "T" => "Декабрем",
            "P" => "Декабре",
        ),
    );
    private static $weekdaysNounce = array(
        "0" => array(
            "R" => "Воскресенья",
            "D" => "Воскресенью",
            "V" => "Воскресенье",
            "T" => "Воскресеньем",
            "P" => "Воскресенье"
        ),
        "1" => array(
            "R" => "Понедельника",
            "D" => "Понедельнику",
            "V" => "Понедельник",
            "T" => "Понедельником",
            "P" => "Понедельнике"
        ),
        "2" => array(
            "R" => "Вторника",
            "D" => "Вторнику",
            "V" => "Вторник",
            "T" => "Вторником",
            "P" => "Вторнике"
        ),
        "3" => array(
            "R" => "Среды",
            "D" => "Среде",
            "V" => "Среду",
            "T" => "Средой",
            "P" => "Среде"
        ),
        "4" => array(
            "R" => "Четверга",
            "D" => "Четвергу",
            "V" => "Четверг",
            "T" => "Четвергом",
            "P" => "Четверге"
        ),
        "5" => array(
            "R" => "Пятницы",
            "D" => "Пятнице",
            "V" => "Пятницу",
            "T" => "Пятницей",
            "P" => "Пятнице"
        ),
        "6" => array(
            "R" => "Субботы",
            "D" => "Субботе",
            "V" => "Субботу",
            "T" => "Субботой",
            "P" => "Субботе"
        )
    );
    public static function getValuesArr($withPrefix = false){
        $defaultArr = array(
            "curYear" => array(
                'value' => date('Y'),
                'prefix' => 'Год - '
            ),
            "curDay" => array(
                'value' => date('d'),
                'prefix' => 'День - '
            ),
            "curMonth" => array(
                'value' => date('m'),
                'prefix' => 'Месяц - '
            ),
            "curMonthName" => array(
                'value' => FormatDate("f", date()),
                'prefix' => 'Месяц (И.п.) - '
            ),
            "curMonthNameR" => array(
                'value' => FormatDate("F", date()),
                'prefix' => 'Месяц (Р.п.) - '
            ),
            "curMonthNameD" => array(
                'value' => self::$monthNounce[date('m')]['D'],
                'prefix' => 'Месяц (Д.п.) - '
            ),
            "curMonthNameT" => array(
                'value' => self::$monthNounce[date('m')]['T'],
                'prefix' => 'Месяц (Т.п.) - '
            ),
            "curMonthNameP" => array(
                'value' => self::$monthNounce[date('m')]['P'],
                'prefix' => 'Месяц (П.п.) - '
            ),
            "curMonthNameShort" => array(
                'value' => FormatDate("M", date()),
                'prefix' => 'Месяц кор. - '
            ),
            "curWeekday" => array(
                'value' => FormatDate("l", date()),
                'prefix' => 'День недели (И.п.) - '
            ),
            "curWeekdayR" => array(
                'value' => self::$weekdaysNounce[date('w')]['R'],
                'prefix' => 'День недели (Р.п.) - '
            ),
            "curWeekdayD" => array(
                'value' => self::$weekdaysNounce[date('w')]['D'],
                'prefix' => 'День недели (Д.п.) - '
            ),
            "curWeekdayV" => array(
                'value' => self::$weekdaysNounce[date('w')]['V'],
                'prefix' => 'День недели (В.п.) - '
            ),
            "curWeekdayT" => array(
                'value' => self::$weekdaysNounce[date('w')]['T'],
                'prefix' => 'День недели (Т.п.) - '
            ),
            "curWeekdayP" => array(
                'value' => self::$weekdaysNounce[date('w')]['P'],
                'prefix' => 'День недели (П.п.) - '
            ),
            "curWeekdayShort" =>array(
                'value' => FormatDate("D", date()),
                'prefix' => 'День недели кор. - '
            ),
            "curMonthLastDay" => array(
                'value' => date("t"),
                'prefix' => 'Последний день месяца - '
            ),
        );
        $newArr = array();
        foreach ($defaultArr as $key => $item) {
            $newArr[$key] = ($withPrefix ? $item['prefix'] : '').$item['value'];
        }
        return $newArr;
    }
    public static function getDefaultArray(){
        return array(
            "#CUR_YEAR#" => array(
                'value' => 'curYear',
                'state' => 'default'
            ),
            "#CUR_DAY#" => array(
                'value' => 'curDay',
                'state' => 'default'
            ),
            "#CUR_MONTH#" => array(
                'value' => 'curMonth',
                'state' => 'default'
            ),
            "#CUR_MONTH_NAME#" => array(
                'value' => 'curMonthName',
                'state' => 'default',
            ),
            "#CUR_MONTH_NAME_ALT#" => array(
                'value' => 'curMonthNameR',
                'state' => 'default'
            ),
            "#CUR_MONTH_NAME_SHORT#" => array(
                'value' => 'curMonthNameShort',
                'state' => 'default'
            ),
            "#CUR_WEEKDAY#" => array(
                'value' => 'curWeekday',
                'state' => 'default'
            ),
            "#CUR_WEEKDAY_SHORT#" => array(
                'value' => 'curWeekdayShort',
                'state' => 'default'
            ),
            "#CUR_MONTH_LAST_DAY#" => array(
                'value' => 'curMonthLastDay',
                'state' => 'default'
            ),
        );
    }
}