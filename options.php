<?
use Bitrix\Main\Localization\Loc;
use	Bitrix\Main\HttpApplication;
use Bitrix\Main\Loader;
use Bitrix\Main\Config\Option;
use Newmark\Replacemarks\Wordbook;

Loc::loadMessages(__FILE__);

$request = HttpApplication::getInstance()->getContext()->getRequest();

$module_id = htmlspecialcharsbx($request["mid"] != "" ? $request["mid"] : $request["id"]);

Loader::includeModule($module_id);

$defaultArray = Wordbook::getDefaultArray();
$selectArr = Wordbook::getValuesArr(true);

$aTabs = array(
    array(
        "DIV" 	  => "edit1",
        "TAB" 	  => Loc::getMessage("NEWMARK_REPLACEMARKS_OPTIONS_TAB_NAME"),
        "TITLE"   => Loc::getMessage("NEWMARK_REPLACEMARKS_OPTIONS_TAB_TITLE"),
        "OPTIONS" => array(
            Loc::getMessage("NEWMARK_REPLACEMARKS_OPTIONS_TAB_COMMON"),
            array(
                "switch_on",
                Loc::getMessage("NEWMARK_REPLACEMARKS_OPTIONS_TAB_SWITCH_ON"),
                "Y",
                array("checkbox")
            ),
            Loc::getMessage("NEWMARK_REPLACEMARKS_OPTIONS_TAB_ACTION"),
            array(
                "exclude",
                Loc::getMessage("NEWMARK_REPLACEMARKS_OPTIONS_TAB_EXCLUDE"),
                "",
                array("textarea", 10, 40)
            ),
            array(
                "marks",
                Loc::getMessage("NEWMARK_REPLACEMARKS_OPTIONS_TAB_MARKS"),
                json_encode($defaultArray),
                array("textarea", 10, 40)
            ),
        )
    )
);

if($request->isPost() && check_bitrix_sessid()){

    foreach($aTabs as $aTab){

        foreach($aTab["OPTIONS"] as $arOption){

            if(!is_array($arOption)){

                continue;
            }

            if($arOption["note"]){

                continue;
            }

            if($request["apply"]){

                $optionValue = $request->getPost($arOption[0]);

                if($arOption[0] == "switch_on"){

                    if($optionValue == ""){

                        $optionValue = "N";
                    }
                }

                Option::set($module_id, $arOption[0], is_array($optionValue) ? implode(",", $optionValue) : $optionValue);
            }elseif($request["default"]){
                Option::set($module_id, $arOption[0], $arOption[2]);
            }
        }
    }

    LocalRedirect($APPLICATION->GetCurPage()."?mid=".$module_id."&lang=".LANG."&mid_menu=1");
}

$tabControl = new CAdminTabControl(
    "tabControl",
    $aTabs
);

$tabControl->Begin();

?>

<form action="<? echo($APPLICATION->GetCurPage()); ?>?mid=<? echo($module_id); ?>&lang=<? echo(LANG); ?>" method="post">
    <script>
        var selectObj = <?=json_encode($selectArr)?>;
    </script>
    <script src="/bitrix/js/<?=$module_id?>/admin.js"></script>
    <link href="/bitrix/css/<?=$module_id?>/admin.css" rel="stylesheet"/>
    <?
    foreach($aTabs as $aTab){

        if($aTab["OPTIONS"]){
            $tabControl->BeginNextTab();
            __AdmSettingsDrawList($module_id, $aTab["OPTIONS"]);
        }
    }

    $tabControl->Buttons();
    ?>

    <input type="submit" name="apply" value="<? echo(Loc::GetMessage("NEWMARK_REPLACEMARKS_OPTIONS_INPUT_APPLY")); ?>" class="adm-btn-save" />
    <input type="submit" name="default" value="<? echo(Loc::GetMessage("NEWMARK_REPLACEMARKS_OPTIONS_INPUT_DEFAULT")); ?>" />
    <div style="text-align:right;">
        <a href="https://nmark.ru/" target="_blank" style="display:inline-block;">
            <img src="/bitrix/images/<?=$module_id?>/nmlogo.png"/>
        </a>
    </div>


    <?
    echo(bitrix_sessid_post());
    ?>

</form>
<?$tabControl->End();?>
