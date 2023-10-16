<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle(" ");
$GLOBALS['APPLICATION']->RestartBuffer();

use Bitrix\Main\Application;
use Bitrix\Main\Web\Cookie;

$application = Application::getInstance();
$context = $application->getContext();

/* Избранное */
global $APPLICATION;
if ($_GET['id']) {
    if (!$USER->IsAuthorized()) // Для неавторизованного
    {
        $arElements = unserialize($APPLICATION->get_cookie('favorites'));

        if (!in_array($_GET['id'], $arElements)) {
            $arElements[] = $_GET['id'];
            $result = 1; // Датчик. Добавляем
        } else {
            $key = array_search($_GET['id'], $arElements); // Находим элемент, который нужно удалить из избранного
            unset($arElements[$key]);
            $result = 2; // Датчик. Удаляем
        }
        $cookie = new Cookie("favorites", serialize($arElements), time() + 60 * 60 * 24 * 60);
        $cookie->setDomain($context->getServer()->getHttpHost());
        $cookie->setHttpOnly(false);
        $context->getResponse()->addCookie($cookie);
        $context->getResponse()->flush("");
    }
}
/* Избранное */
echo json_encode($result);
die(); ?>
<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>