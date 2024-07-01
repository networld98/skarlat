<?
//Определяем пользователь партнер или нет
global $countItemsInCart, $USER;

if($countItemsInCart){
	$countItemsInCartTest = " (".$countItemsInCart.")";
}

$dbUser = \Bitrix\Main\UserTable::getList(array(
	'select' => array('ID', 'UF_AFFILIATE', 'UF_COUPON'),
	'filter' => array('ID' => $USER->GetID())
));
$arUser = $dbUser->fetch();
$partner = $arUser['UF_AFFILIATE'];

$aMenuLinks = Array(
	Array(
		"Профиль",
		"",
		Array(),
		Array("FROM_IBLOCK"=>"1", "IS_PARENT"=>"1", "DEPTH_LEVEL"=>"2", "link" => "profil", "icon" => '<svg viewBox="0 0 18 18">
                        <path d="M12.1641 11.6719H11.3745C10.9199 11.6719 10.7212 11.1055 11.0468 10.8299C12.7139 9.41484 13.7461 6.53625 13.7461 4.74609C13.7461 2.12906 11.617 0 9 0C6.38262 0 4.25391 2.12906 4.25391 4.74609C4.25391 6.53625 5.28574 9.41484 6.95285 10.8299C7.2777 11.1048 7.08082 11.6719 6.6252 11.6719H5.83594C3.21855 11.6719 1.08984 13.8009 1.08984 16.418V17.4727C1.08984 17.7641 1.32574 18 1.61719 18H16.3828C16.6743 18 16.9102 17.7641 16.9102 17.4727V16.418C16.9102 13.8009 14.7811 11.6719 12.1641 11.6719Z"></path></svg>'),
		""
	),
	Array(
		"Доставка",
		"",
		Array(),
		Array("FROM_IBLOCK"=>"1", "IS_PARENT"=>"1", "DEPTH_LEVEL"=>"2", "link" => "delivery", "icon" => '<svg viewBox="0 0 20 20">
                        <g>
                            <path d="M7.62488 3.9765V14.1485L12.3827 16.0233V5.85138L7.62488 3.9765Z"></path>
                            <path d="M3.52332 4.98195V15.2306L6.44519 14.1655V3.91672L3.52332 4.98195Z"></path>
                            <path d="M13.5624 5.83432V16.0831L16.4843 15.0178V4.76917L13.5624 5.83432Z"></path>
                            <path d="M19.2137 0.0362213L12.9789 2.30341L7.24844 0.0424713C7.11562 -0.0106537 6.96836 -0.0129974 6.83086 0.0362213L0.385547 2.37997C0.154297 2.46392 0 2.68388 0 2.93032V19.4138C0 19.8243 0.408984 20.1032 0.785938 19.9642L7.0207 17.6974L12.7512 19.9579C12.8852 20.0122 13.0316 20.0142 13.1687 19.9642L19.6141 17.6204C19.8453 17.5364 20 17.3165 20 17.07V0.586573C20 0.177628 19.5926 -0.102451 19.2137 0.0362213ZM17.6562 15.4283C17.6562 15.6751 17.5016 15.8947 17.2703 15.979C17.1051 16.0392 13.1687 17.4911 13.0086 17.4911C12.7824 17.4911 7.27109 15.2728 7.06094 15.1888L3.12969 16.6181C2.75078 16.7568 2.34375 16.4763 2.34375 16.0677V4.57216C2.34375 4.32528 2.49805 4.10575 2.7293 4.02177L6.79062 2.54482C6.92812 2.4956 7.07695 2.49794 7.20859 2.55107L7.25898 2.57138H7.25937L12.9387 4.812L16.8699 3.38232C17.2496 3.24442 17.6562 3.52372 17.6562 3.9331V15.4283Z"></path>
                        </g></svg>'),
		""
	),
	Array(
		"Корзина".$countItemsInCartTest,
		"/ru/personal/cart/",
		Array(),
		Array("FROM_IBLOCK"=>"1", "IS_PARENT"=>"1", "DEPTH_LEVEL"=>"2", "icon"=>'<svg viewBox="0 0 18 18" fill="none">
                            <g>
                                <path
                                        d="M16.4185 5.83606H4.63555C3.82804 5.83606 3.15241 6.44117 3.06385 7.24347L2.98584 7.9454H17.951L17.9902 7.59313C18.0969 6.63783 17.3388 5.83606 16.4185 5.83606Z"
                                        fill="black"
                                />
                                <path
                                        d="M2.86812 9L2.04736 16.3827H2.63651H15.5977C15.7996 16.3827 15.9932 16.3448 16.1715 16.2756C16.7063 16.0678 17.103 15.577 17.1694 14.9753L17.8334 9H2.86812Z"
                                        fill="black"
                                />
                                <path
                                        d="M15.4872 3.72665H8.12837L6.17354 1.77182C6.07465 1.67293 5.94077 1.61731 5.80071 1.61731H1.582C0.709664 1.61731 0 2.32697 0 3.19934V14.8007C0 15.4669 0.41509 16.0354 0.99907 16.2683L2.01512 7.12703C2.16345 5.78969 3.28968 4.78134 4.63535 4.78134H16.4183C16.6133 4.78134 16.8052 4.80514 16.9925 4.84708C16.7935 4.20077 16.1979 3.72665 15.4872 3.72665Z"
                                        fill="black"
                                />
                            </g>
                        </svg>'),
		""
	),
	Array(
		"Избранное",
		"/ru/favourite/",
		Array(),
		Array("FROM_IBLOCK"=>"1", "IS_PARENT"=>"1", "DEPTH_LEVEL"=>"2", "icon" => '<svg viewBox="0 0 18 18">
                            <path d="M13.2539 1.08984C11.121 1.08984 9.75199 2.57941 9.03516 3.92098C8.31832 2.57941 6.87937 1.08984 4.74609 1.08984C2.04047 1.08984 0 3.30398 0 6.24059C0 9.41871 2.55938 11.5991 6.43324 14.9006C7.11914 15.4856 7.9207 16.1082 8.68816 16.7797C8.78695 16.8669 8.91176 16.9102 9.03516 16.9102C9.15891 16.9102 9.28336 16.8669 9.38215 16.7797C10.1496 16.1082 10.8809 15.4856 11.5668 14.9006C15.4406 11.5991 18 9.41871 18 6.24059C18 3.30398 15.9595 1.08984 13.2539 1.08984Z"></path></svg>'),
		""
	),

	Array(
		"Вопрос-ответ",
		"",
		Array(),
		Array("FROM_IBLOCK"=>"1", "IS_PARENT"=>"1", "DEPTH_LEVEL"=>"2", "link" => "question", "icon" => '<svg viewBox="0 0 20 20">
                  <path d="M10.0391 0C4.54648 0 0 4.46836 0 9.96094C0 15.4535 4.54648 20 10.0391 20C15.5316 20 20 15.4535 20 9.96094C20 4.46836 15.5316 0 10.0391 0ZM10.0391 17.0703C9.39297 17.0703 8.86719 16.5445 8.86719 15.8984C8.86719 15.2523 9.39297 14.7266 10.0391 14.7266C10.6848 14.7266 11.2109 15.2523 11.2109 15.8984C11.2109 16.5445 10.6848 17.0703 10.0391 17.0703ZM12.116 9.86758C11.5316 10.2969 11.2109 11.4309 11.2109 11.9969V12.3047C11.2109 12.9508 10.6848 13.4766 10.0391 13.4766C9.39297 13.4766 8.86719 12.9508 8.86719 12.3047V11.9969C8.86719 10.6824 9.54609 8.84531 10.7309 7.97773C11.641 7.30937 11.1684 5.85938 10.0391 5.85938C9.39297 5.85938 8.86719 6.38516 8.86719 7.03125C8.86719 7.67734 8.34102 8.20312 7.69531 8.20312C7.04922 8.20312 6.52344 7.67734 6.52344 7.03125C6.52344 5.09258 8.10039 3.51562 10.0391 3.51562C11.9777 3.51562 13.5547 5.09258 13.5547 7.03125C13.5547 8.14727 13.0168 9.20742 12.116 9.86758Z"></path></svg>'),
		""
	),
	Array(
		"Заказы",
		"",
		Array(),
		Array("FROM_IBLOCK"=>"1", "IS_PARENT"=>"1", "DEPTH_LEVEL"=>"1"),
		""
	),
	Array(
		"Новые заказы",
		"",
		Array(),
		Array("FROM_IBLOCK"=>"1", "IS_PARENT"=>"1", "DEPTH_LEVEL"=>"2", "link" => "new-order", "icon" => '<svg viewBox="0 0 20 20">
                  <g>
                    <path d="M16.3481 7.23105L10.4887 0.199805C10.2668 -0.0666016 9.73322 -0.0666016 9.51095 0.199805L3.65158 7.23105C3.33243 7.6127 3.60626 8.19238 4.10158 8.19238H7.03126V14.7266C7.03126 15.0504 7.29337 15.3125 7.6172 15.3125H12.3828C12.7067 15.3125 12.9688 15.0504 12.9688 14.7266V8.19238H15.8985C16.3938 8.19238 16.6672 7.6127 16.3481 7.23105Z"></path>
                    <path d="M19.4141 11.7969H17.0703C16.7465 11.7969 16.4844 12.059 16.4844 12.3828V16.4844H3.51562V12.3828C3.51562 12.059 3.25352 11.7969 2.92969 11.7969H0.585938C0.262109 11.7969 0 12.059 0 12.3828V18.2422C0 19.2117 0.788281 20 1.75781 20H18.2422C19.2113 20 20 19.2117 20 18.2422V12.3828C20 12.059 19.7379 11.7969 19.4141 11.7969Z"></path>
                  </g></svg>'),
		""
	),
	Array(
		"История заказов",
		"",
		Array(),
		Array("FROM_IBLOCK"=>"1", "IS_PARENT"=>"1", "DEPTH_LEVEL"=>"2", "link" => "history", "icon" => '<svg viewBox="0 0 18 18">
                  <g>
                    <path d="M13.2225 0H2.67566C1.80329 0 1.09363 0.709664 1.09363 1.58203V14.3086C1.09363 14.9952 1.53582 15.5751 2.14832 15.7935V5.1828C2.14832 4.47884 2.42282 3.81656 2.9208 3.31857L4.4122 1.82718C4.91019 1.32919 5.57246 1.05469 6.27643 1.05469H14.7074C14.489 0.442195 13.9091 0 13.2225 0Z"></path>
                    <path d="M15.3322 2.11639C10.6729 2.11639 12.0289 2.11639 7.422 2.11639V5.80077C7.422 6.09221 7.1861 6.33514 6.89465 6.33514H3.20325V16.418C3.20325 17.2906 3.9127 18 4.78528 18H15.3322C16.2044 18 16.9072 17.2906 16.9072 16.418V3.69139C16.9072 2.81917 16.2044 2.11639 15.3322 2.11639ZM14.2775 14.836H5.83997C5.54852 14.836 5.31262 14.6001 5.31262 14.3086C5.31262 14.0172 5.54852 13.7813 5.83997 13.7813H14.2775C14.5689 13.7813 14.8048 14.0172 14.8048 14.3086C14.8048 14.6001 14.5689 14.836 14.2775 14.836ZM14.2775 12.7266H5.83997C5.54852 12.7266 5.31262 12.4907 5.31262 12.1992C5.31262 11.9078 5.54852 11.6719 5.83997 11.6719H14.2775C14.5689 11.6719 14.8048 11.9078 14.8048 12.1992C14.8048 12.4907 14.5689 12.7266 14.2775 12.7266ZM14.2775 10.6172H5.83997C5.54852 10.6172 5.31262 10.3813 5.31262 10.0899C5.31262 9.79842 5.54852 9.56252 5.83997 9.56252H14.2775C14.5689 9.56252 14.8048 9.79842 14.8048 10.0899C14.8048 10.3813 14.5689 10.6172 14.2775 10.6172ZM14.2775 8.50784H5.83997C5.54852 8.50784 5.31262 8.27194 5.31262 7.98049C5.31262 7.68905 5.54852 7.45315 5.83997 7.45315H14.2775C14.5689 7.45315 14.8048 7.68905 14.8048 7.98049C14.8048 8.27194 14.5689 8.50784 14.2775 8.50784Z"></path>
                    <path d="M6.27644 2.10938C5.85414 2.10938 5.45659 2.27419 5.15791 2.57287L3.6665 4.06427C3.31491 4.41584 3.203 4.80895 3.203 5.27344H6.36707V2.10938H6.27644Z"></path>
                  </g></svg>'),
		""
	),
	Array(
		"Партнёрам",
		"partner",
		Array(),
		Array("FROM_IBLOCK"=>"1", "IS_PARENT"=>"1", "DEPTH_LEVEL"=>"1"),
		""
	),
	Array(
		"Бонусы",
		"partner",
		Array(),
		Array("FROM_IBLOCK"=>"1", "IS_PARENT"=>"1", "DEPTH_LEVEL"=>"2", "link" => "bonus", "icon" => '<svg viewBox="0 0 20 20">
                  <g>
                    <path d="M19.4987 7.30169L13.3248 6.40442L10.5643 0.810627C10.3674 0.410236 9.63262 0.410236 9.43574 0.810627L6.67558 6.40442L0.501308 7.30169C0.0208384 7.372 -0.169396 7.9638 0.177479 8.30091L4.64393 12.6553L3.58885 18.8037C3.5076 19.2776 4.00604 19.6479 4.43925 19.4213L10.0393 16.5186L15.5608 19.4213C15.9917 19.6479 16.4929 19.2776 16.4112 18.8037L15.3561 12.6553L19.823 8.30091C20.1694 7.9638 19.9792 7.372 19.4987 7.30169Z"></path>
                  </g></svg>'),
		""
	),
	Array(
		"Партнёрские заказы",
		"partner",
		Array(),
		Array("FROM_IBLOCK"=>"1", "IS_PARENT"=>"1", "DEPTH_LEVEL"=>"2", "link" => "partner", "icon" => '<svg viewBox="0 0 20 20">
                  <path d="M13.5547 4.6875H10.0391C9.7152 4.6875 9.45312 4.94957 9.45312 5.27344V17.6562H14.1406V5.27344C14.1406 4.94957 13.8786 4.6875 13.5547 4.6875Z"></path>
                  <path d="M19.4141 8.20312H15.8984C15.5746 8.20312 15.3125 8.4652 15.3125 8.78906V17.6562H20V8.78906C20 8.4652 19.7379 8.20312 19.4141 8.20312Z"></path>
                  <path d="M7.69531 0H4.17969C3.85582 0 3.59375 0.26207 3.59375 0.585938V17.6562H8.28125V0.585938C8.28125 0.26207 8.01918 0 7.69531 0Z"></path>
                  <path d="M9.45312 18.8281C6.33832 18.8281 4.30113 18.8281 1.17188 18.8281V17.6562H1.75781C2.08168 17.6562 2.34375 17.3942 2.34375 17.0703C2.34375 16.7464 2.08168 16.4844 1.75781 16.4844H1.17188V14.0625H1.75781C2.08168 14.0625 2.34375 13.8004 2.34375 13.4766C2.34375 13.1527 2.08168 12.8906 1.75781 12.8906H1.17188V10.5469H1.75781C2.08168 10.5469 2.34375 10.2848 2.34375 9.96094C2.34375 9.63707 2.08168 9.375 1.75781 9.375H1.17188V7.03125H1.75781C2.08168 7.03125 2.34375 6.76918 2.34375 6.44531C2.34375 6.12145 2.08168 5.85938 1.75781 5.85938H1.17188V3.51562H1.75781C2.08168 3.51562 2.34375 3.25355 2.34375 2.92969C2.34375 2.60582 2.08168 2.34375 1.75781 2.34375H1.17188V0.585938C1.17188 0.26207 0.909805 0 0.585938 0C0.26207 0 0 0.26207 0 0.585938V19.4141C0 19.7379 0.26207 20 0.585938 20C7.73426 20 2.06824 20 19.4141 20C19.7379 20 20 19.7379 20 19.4141V18.8281C15.9918 18.8281 13.212 18.8281 9.45312 18.8281Z"></path></svg>'),
		""
	),
);
if($arUser['UF_AFFILIATE']!=1){
	foreach ($aMenuLinks as $key => $item){
		if($item[1]=='partner'){
			unset($aMenuLinks[$key]);
		}
	}
	if($_GET['tab']=='bonus' ||  $_GET['tab']=='partner'){
		header('Location: https://'.$_SERVER['HTTP_HOST'].'/personal/?tab=profil');
	}
}
?>
